<?php

namespace AppBundle\Controller\PublicController\Internautes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\SignUp;
use AppBundle\Entity\Internaute;
use AppBundle\Entity\Utilisateur;
use AppBundle\Form\SignUpType;
use AppBundle\Form\InternauteType;
use AppBundle\Form\ImageType;
use AppBundle\Form\UtilisateurType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class InternauteController extends Controller
{

    /**
     * Call by views/Public/Navigation/nav.parent.menu
     */
    public function getChildNavPreSignupElementsAction()
    {

        $new_user = new SignUp();
        $form = $this->get('form.factory')->create(SignUpType::class, $new_user);
        // TODO prestataires favoris
        return $this->render('Public/Internautes/Register/form.pre.subscribe.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Get the favorites prestataires on success authenticated internaute (page home)
     */
    public function getPrestatairesFavorisAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_INTERNAUTE')) {
            $myFavoris = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Internaute')
                ->getPrestatairesFavoris($this->getUser()->getInternaute()->getId());//récupération Id internaute
        }
        $myFavoris = $myFavoris[0];
        dump($myFavoris);
        return $this->render('Public/Internautes/Favoris/display.prestataires.favoris.html.twig', array(
            'favoris' => $myFavoris
        ));
    }

    /**
     * @Route("/pre-inscription",options={"expose"=true},name="signup")
     */
    public function preSignupInternauteAction(Request $request)
    {
        $new_user = new SignUp();

        $form = $this->get('form.factory')->create(SignUpType::class, $new_user);

        $form->handleRequest($request);
        //ajax
        if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest()) {

            if (!$form->isValid()) {

                $errors = $this->get('app.geterrormessages')->getErrorMessages($form);

                return new JsonResponse(array(
                    'errors' => $errors,
                    'valide' => false,
                ));
            }
            if ($form->isValid()) {
                $values = $request->request->all();
                $new_user->setToken();
                $em = $this->getDoctrine()->getManager();
                $em->persist($new_user);
                $em->flush();

                $this->get('app.mailerbuilder')->signupMailer($new_user);

                return new JsonResponse(array(
                    'valide' => true,
                    'values' => $values,
                ));
            }
        }
        return $this->render('Public/Internautes/Register/form.pre.subscribe.html.twig', array(
            'form' => $form->createView(),
            'user' => $new_user
        ));
    }

    /**
     * @Route("/inscription-finale/{id}/{token}",options={"expose"=true},name="signup-final")
     */
    public function signupInternauteStepFinalAction(Request $request, $id, $token)
    {
        try {
            $first_step_signup = $this->getDoctrine()->getManager()->getRepository('AppBundle:SignUp')->findOneById($id);
        } catch (Exception $e) {
            return $this->redirectToRoute('home');
        }
        if (($first_step_signup) && ($first_step_signup->getToken() == $token)) {
            $internaute = new Utilisateur();
        } else {
            return $this->redirectToRoute('about');
        }

        $form = $this->get('form.factory')->create(UtilisateurType::class, $internaute)->add('internaute', InternauteType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $internaute->setSalt('')->setRoles("ROLE_INTERNAUTE");

                $em = $this->getDoctrine()->getManager();
                $em->persist($internaute);
                $em->remove($first_step_signup);
                $em->flush();

                return $this->redirectToRoute('home');
            }
        }
        return $this->render('Public/Internautes/Register/form.signup.internaute.html.twig', array(
            'form' => $form->createView(),
            'user' => $internaute,
            'signup' => $first_step_signup
        ));
    }

    /**
     * @Route("/internaute/gestion/liste/favoris",options={"expose"=true},name="display_favoris")
     */
    public function displayFavorisAction()
    {
        return $this->render('Public/Internautes/EditProfile/display.liste.favoris.html.twig');
    }

    /**
     * @Route("/internaute/ajout/favori/{nomPrestataire}",options={"expose"=true},name="add_favori")
     */
    public function addFavorisAction(Request $request, $nomPrestataire)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_INTERNAUTE')) {

            $em = $this->getDoctrine()->getManager();

            $newAbonne = $em->getRepository('AppBundle:Internaute')->getPrestatairesFavoris($this->getUser()->getInternaute()->getId());// récupération de l'Internaute qui s'abonne
            $newFavori = $em->getRepository('AppBundle:Prestataire')->findByNom($nomPrestataire);// récupération du Prestataire choisi

            $newAbonne[0]->addFavori($newFavori[0]);// ajout du nouvel abonné (Internaute) à son favori (Prestataire)

            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }
        return $this->redirectToRoute('home');

    }

    /**
     * @Route("/internaute/retrait/favori/{nomPrestataire}/{from}",options={"expose"=true},name="remove_favori")
     */
    public function removeFavorisAction(Request $request, $nomPrestataire = null, $from = 'home')
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_INTERNAUTE')) {

            $em = $this->getDoctrine()->getManager();

            $oldAbonne = $em
                ->getRepository('AppBundle:Internaute')
                ->findInternaute($this->getUser()->getInternaute()->getId());

            $oldFavori = $em
                ->getRepository('AppBundle:Prestataire')
                ->findByNom($nomPrestataire);

            $oldAbonne[0]->removeFavori($oldFavori[0]);

            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->redirectToRoute($from);
    }

    /**
     * @Route("/internaute/profil",name="show_internaute")
     */
    public function displayInfosInternauteAction()
    {
        dump($this->getUser());
        return $this->render('Public/Internautes/EditProfile/display.informations.internaute.html.twig');
    }

    /**
     * @Route("/internaute/mise-a-jour/{id}",options={"expose"=true},name="update_internaute")
     */
    public function updateIdentityInternauteAction(Request $request, $id = null)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $internaute = $this->getDoctrine()->getManager()->getRepository('AppBundle:Utilisateur')->findOneById($id);
        } else {
            $internaute = $this->getUser();
        }
        dump($internaute);
        $form = $this
            ->get('form.factory')
            ->create(UtilisateurType::class, $internaute)
            ->add('internaute', InternauteType::class)
//                ->add('image', ImageType::class)
            ->remove('password', PasswordType::class, array('required' => false));

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->persist($internaute)->flush();

                return $this->redirectToRoute('show_internaute');
            }
        }

        return $this->render('Public/Internautes/EditProfile/form.identity.internaute.html.twig', array(
            'form' => $form->createView(),
            'internaute' => $internaute,
        ));
    }

    /**
     * @Route("/internaute/photo/{id}",options={"expose"=true},name="update_photo_internaute")
     */
    public function updateImageInternauteAction(Request $request, $id = null)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $utilisateur = $this->getDoctrine()->getManager()->getRepository('AppBundle:Utilisateur')->findOneById($id);
            $image = $this->getDoctrine()->getManager()->getRepository('AppBundle:Image')->findOneByUrl($utilisateur->getInternaute()->getImage()->getUrl());
            dump($image, $utilisateur);
        } else {
            $image = $this->getDoctrine()->getManager()->getRepository('AppBundle:Image')->findOneByUrl($this->getUser()->getInternaute()->getImage()->getUrl());
            $utilisateur = $this->getUser();
        }
        $form = $this
            ->get('form.factory')
            ->create(ImageType::class, $image)
            ->remove('name', TextType::class, array('required' => false))
            ->add('Envoyer', SubmitType::class, array('attr' => array('class' => 'btn btn-default pull-right')));

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
//           $image->setFile(unserialize($image->getFile()));

            if ($form->isValid()) {
                //unserialize($image->getFile());
                /* if (file_exists(__DIR__ . '/../../../../../web/image/userUploads/' . $image->getUrl())) {
                     unlink(__DIR__ . '/../../../../../web/image/userUploads/' . $image->getUrl());
                 }*/
                //$image->preUpload();
                $em = $this->getDoctrine()->getManager();

                $em->persist($image);
                $em->flush();

                return $this->redirectToRoute('home');
            }
        }

        return $this->render('Public/Internautes/EditProfile/form.edit.photo.internaute.html.twig', array(
            'form' => $form->createView(),
            'image' => $image,
            'internaute' => $utilisateur
        ));
    }
}

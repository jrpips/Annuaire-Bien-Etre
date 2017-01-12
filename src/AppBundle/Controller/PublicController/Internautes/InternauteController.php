<?php

namespace AppBundle\Controller\PublicController\Internautes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\SignUp;
use AppBundle\Entity\Internaute;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Image;
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

        return $this->render('Public/Internautes/Favoris/display.prestataires.favoris.html.twig', array(
            'favoris' => $myFavoris
        ));
    }

    /**
     * @Route("/pre-inscription",name="signup",options={"expose"=true})
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
     * @Route("/inscription-finale/{signup}/{token}",options={"expose"=true},name="signup-final")
     */
    public function signupInternauteStepFinalAction(Request $request, SignUp $signup, $token)
    {
        if (($signup) && ($signup->getToken() == $token)) {
            $internaute = new Utilisateur();
        } else {
            return $this->redirectToRoute('about');
        }

        $form = $this->get('form.factory')->create(UtilisateurType::class, $internaute)->add('internaute', InternauteType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $plainPassword = $internaute->getPassword();
                $encoder = $this->container->get('security.password_encoder');
                $encoded = $encoder->encodePassword($internaute, $plainPassword);

                $internaute->setPassword($encoded);

                $internaute->setSalt('')->setRoles("ROLE_INTERNAUTE");

                $em = $this->getDoctrine()->getManager();
                $em->persist($internaute);
                $em->remove($signup);

                $this->get('app.addmsgflash')->addMsgFlash($request, 'success', 'Votre inscription est validée!',true);
                try {
                    $em->flush();
                } catch (\Exception $e) {
                    $this->get('app.addmsgflash')->addMsgFlash($request, 'danger', 'Une erreur est survenue lors de votre inscription! Veuillez réessayer plus tard.',true);
                }
                return $this->redirectToRoute('home');
            }
        }
        return $this->render('Public/Internautes/Register/form.signup.internaute.html.twig', array(
            'form' => $form->createView(),
            'user' => $internaute,
            'signup' => $signup
        ));
    }

    /**
     * @Route("/internaute/gestion/liste/favoris/{internaute}",options={"expose"=true},name="display_favoris")
     */
    public function displayFavorisAction(Internaute $internaute = null)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $internaute = $this->getUser()->getInternaute();
        }
        return $this->render('Public/Internautes/EditProfile/display.liste.favoris.html.twig', array(
            'internaute' => $internaute
        ));
    }

    /**
     * @Route("/internaute/ajout/favori/{nomPrestataire}",options={"expose"=true},name="add_favori")
     */
    public function addFavorisAction($nomPrestataire)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_INTERNAUTE')) {

            $em = $this->getDoctrine()->getManager();

            $newAbonne = $em->getRepository('AppBundle:Internaute')->getPrestatairesFavoris($this->getUser()->getInternaute()->getId());// récupération de l'Internaute qui s'abonne
            $newFavori = $em->getRepository('AppBundle:Prestataire')->findByNom($nomPrestataire);// récupération du Prestataire choisi

            $newAbonne[0]->addFavori($newFavori[0]);// ajout du nouvel abonné (Internaute) à son favori (Prestataire)

            $em = $this->getDoctrine()->getManager();
            $em->flush();

        }
        return $this->redirectToRoute('details_prestataire', array('prestataire_nom' => $nomPrestataire));

    }

    /**
     * @Route("/internaute/retrait/favori/{nomPrestataire}/{from}",options={"expose"=true},name="remove_favori")
     */
    public function removeFavorisAction(Request $request,$nomPrestataire = null, $from = 'home')
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_INTERNAUTE')) {

            $em = $this->getDoctrine()->getManager();

            $oldAbonne = $em
                ->getRepository('AppBundle:Internaute')
                ->findInternaute($this->getUser()->getInternaute()->getId());

            $oldFavori = $em
                ->getRepository('AppBundle:Prestataire')
                ->findOneByNom($nomPrestataire);

            $oldAbonne[0]->removeFavori($oldFavori);

            $em = $this->getDoctrine()->getManager();

            $this->get('app.addmsgflash')->addMsgFlash($request, 'success', 'vos favoris');
            try {
                $em->flush();
            } catch (\Exception $e) {
                $this->get('app.addmsgflash')->addMsgFlash($request, 'danger', 'vos favoris');
                //return $this->redirectToRoute('update_internaute');
            }

        }
        return $this->redirectToRoute($from);
    }

    /**
     * @Route("/internaute/profil",name="show_internaute")
     */
    public function displayInfosInternauteAction(Utilisateur $utilisateur = null)
    {
        if ($utilisateur) {
            $internaute = $utilisateur->getInternaute();
        }
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $internaute = $this->getUser()->getInternaute();
        }
        return $this->render('Public/Internautes/EditProfile/display.informations.internaute.html.twig', array(
            'internaute' => $internaute
        ));
    }

    /**
     * @Route("/internaute/mise-a-jour/{utilisateur}",options={"expose"=true},name="update_internaute")
     */
    public function updateIdentityInternauteAction(Request $request, Utilisateur $utilisateur = null)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $utilisateur = $this->getUser();
        }

        $utilisateur->setConfPwd($utilisateur->getPassword());

        $form = $this
            ->get('form.factory')
            ->create(UtilisateurType::class, $utilisateur)
            ->add('internaute', InternauteType::class)
           ;
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                try {
                    $em->flush();

                } catch (\Exception $e) {

                    $this->get('app.addmsgflash')->addMsgFlash($request, 'danger', 'votre profil');
                    return $this->redirectToRoute('update_internaute');
                }
                $this->get('app.addmsgflash')->addMsgFlash($request, 'success', 'votre profil');
                return $this->redirectToRoute('show_internaute');
            }
        }
        return $this->render('Public/Internautes/EditProfile/form.identity.internaute.html.twig', array(
            'form' => $form->createView(),
            'internaute' => $utilisateur->getInternaute(),
        ));
    }

    /**
     * @Route("/internaute/photo/{internaute}",options={"expose"=true},name="update_photo_internaute")
     */
    public function updateImageInternauteAction(Request $request, Internaute $internaute = null)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $internaute = $this->getUser()->getInternaute();
        }
        if ($internaute->getImage()) {//si l'Internaute à tjs l'Image par défaut
            $image = $internaute->getImage();
        } else {
            $image = new Image();
        }

        $form = $this
            ->get('form.factory')
            ->create(ImageType::class, $image)
            ->add('Envoyer', SubmitType::class, array('attr' => array('class' => 'btn btn-default pull-right')));

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $internaute->setImage($image);
                $em->persist($internaute);
                $em->flush();
                $this->get('app.addmsgflash')->addMsgFlash($request, 'success', 'votre photo');
                return $this->redirectToRoute('show_internaute');
            }
        }

        return $this->render('Public/Internautes/EditProfile/form.edit.photo.internaute.html.twig', array(
            'form' => $form->createView(),
            'image' => $image,
            'internaute' => $internaute
        ));
    }
}

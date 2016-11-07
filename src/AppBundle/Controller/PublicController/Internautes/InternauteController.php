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

class InternauteController extends Controller {

    /**
     * call by views/Public/Navigation/nav.parent.menu
     */
    public function getChildNavPreSignupElementsAction() {

        $new_user = new SignUp();
        $form = $this->get('form.factory')->create(SignUpType::class, $new_user);
        // TODO prestataires favoris
        return $this->render('Public/Internautes/Register/form.pre.subscribe.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/inscription/internaute/pre-inscription",options={"expose"=true},name="signup")
     */
    public function preSignupInternauteAction(Request $request) {

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
                $em = $this->getDoctrine()->getManager();
                $em->persist($new_user);
                $em->flush();

                $this->get('app.mailerbuilder')->mailer($new_user);

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
     * @Route("/inscription/internaute/finalisation/{id}",options={"expose"=true},name="signup-final")
     */
    public function signupInternauteStepFinalAction(Request $request, $id = null) {

        if ($id) {
            $first_step_signup = $this->getDoctrine()->getManager()->getRepository('AppBundle:SignUp')->find($id);
        } else {
            $first_step_signup = null;
        }

        $internaute = new Utilisateur();

        $form = $this->get('form.factory')->create(UtilisateurType::class, $internaute)->add('internaute', InternauteType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $internaute->setSalt('')->setRoles("ROLE_INTERNAUTE");

                $em = $this->getDoctrine()->getManager();
                $em->persist($internaute);

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
     * @Route("/internautes/informations",name="show_internaute")
     */
    public function displayInfosInternauteAction() {
        dump($this->getUser());
        return $this->render('Public/Internautes/EditProfile/display.informations.internaute.html.twig');
    }

    /**
     * @Route("/internautes/mise-a-jour/{id}",options={"expose"=true},name="update_internaute")
     */
    public function updateIdentityInternauteAction(Request $request, $id = null) {

        $internaute = $this->getUser();

        $form = $this
                ->get('form.factory')
                ->create(UtilisateurType::class, $internaute)
                ->add('internaute', InternauteType::class)
//                ->add('image', ImageType::class)
                ->remove('password', PasswordType::class, array('required' => false));

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($internaute);

                $em->flush();

                return $this->redirectToRoute('show_internaute');
            }
        }

        return $this->render('Public/Internautes/EditProfile/form.identity.internaute.html.twig', array(
                    'form' => $form->createView(),
                    'internaute' => $internaute,
        ));
    }

    /**
     * @Route("/internautes/photo/{id}",options={"expose"=true},name="update_photo_internaute")
     */
    public function updateImageInternauteAction(Request $request, $id = null) {

        $u = $this->getUser()->getInternaute()->getImage()->getUrl();
        $tabImage = $this->getDoctrine()->getManager()->getRepository('AppBundle:Image')->findByUrl($u);
        $image = $tabImage[0];
        dump($image);

        $form = $this
                ->get('form.factory')
                ->create(ImageType::class, $image)
                ->remove('name', TextType::class, array('required' => false))
                ->add('Envoyer', SubmitType::class, array('attr' => array('class' => 'btn btn-default pull-right')));

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
//           $image->setFile(unserialize($image->getFile()));
//            unlink(__DIR__ .'/../../../../../web/image/userUploads/'.$image->getUrl());
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($image);
                //$em->persist($user);
                $em->flush();

                return $this->redirectToRoute('show_internaute');
            }
        }

        return $this->render('Public/Internautes/EditProfile/form.edit.photo.internaute.html.twig', array(
                    'form' => $form->createView(),
                    'image' => $image,
        ));
    }

}

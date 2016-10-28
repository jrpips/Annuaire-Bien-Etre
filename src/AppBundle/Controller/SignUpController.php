<?php

namespace AppBundle\Controller;

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
use AppBundle\Form\UtilisateurType;

class SignUpController extends Controller {

    /**
     * call by views/Public/Navigation/nav.parent.menu
     */
    public function getNavPreSignupElementsAction() {

        $new_user = new SignUp();
        $form = $this->get('form.factory')->create(SignUpType::class, $new_user);
        // TODO prestataires favoris
        return $this->render('Public/form.pre.subscribe.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/inscription/internaute/pre-inscription",options={"expose"=true},name="signup")
     */
    public function signupAction(Request $request) {

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
        return $this->render('Public/form.pre.subscribe.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $new_user
        ));
    }

    /**
     * @Route("/inscription/internaute/finalisation/{id}",options={"expose"=true},name="signup-final")
     */
    public function signupFinalAction(Request $request, $id = null) {

        if ($id) {
            $first_step_signup = $this->getDoctrine()->getManager()->getRepository('AppBundle:SignUp')->find($id);
        } else {
            $first_step_signup = new SignUp();
        }

        $final_step_signup = new Internaute();
        $u = new Utilisateur();

        $form = $this->get('form.factory')->create(InternauteType::class, $final_step_signup);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($final_step_signup);
                $em->persist($u);
                $em->flush();

                return $this->redirectToRoute('home');
            }
        }
        return $this->render('Public/Internautes/form.signup.internaute.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $final_step_signup,
                    'signup' => $first_step_signup
        ));
    }

}

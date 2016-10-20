<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\SignUp;
use AppBundle\Entity\Internaute;
use AppBundle\Entity\Utilisateur;
use AppBundle\Form\SignUpType;
use AppBundle\Form\InternauteType;
use AppBundle\Form\UtilisateurType;

class SignUpController extends Controller {

    /**
     * @Route("/login",name="login")
     */
    public function loginAction() {
        $response = new JsonResponse;
        $response->setData(array('data' => '$errors'));
        return $response;
    }

    /**
     * @Route("/inscription/pre-inscription/",options={"expose"=true},name="signup")
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
        return $this->render('accueil/login.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $new_user
        ));
    }

    /**
     * @Route("/inscription/finalisation/{id}",options={"expose"=true},name="signup-final")
     */
    public function signupFinalAction(Request $request, $id = null) {

        if ($id) {
            $first_step_signup = $this->getDoctrine()->getManager()->getRepository('AppBundle:SignUp')->find($id);
        } else {
            $first_step_signup = new SignUp();
        }

        $final_step_signup = new Internaute();

        $form = $this->get('form.factory')->create(InternauteType::class, $final_step_signup);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($final_step_signup);
                $em->flush();

                return $this->redirectToRoute('home');
            }
        }
        //Auto-complete Ajax
        if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest()) {

            $val = $request->request->get('valeur');
            $response = $this->container->get('app.searchpostalcode')->getData($val);

            return new JsonResponse($response);
        }

        return $this->render('form.signup.internaute.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $final_step_signup,
                    'signup' => $first_step_signup
        ));
    }

}

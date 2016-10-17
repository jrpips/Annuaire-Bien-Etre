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
     * @Route("/signup/first/step",options={"expose"=true},name="signup")
     */
    public function signupAction(Request $request) {

        $newUser = new SignUp();

        $form = $this->get('form.factory')->create(SignUpType::class, $newUser);

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
                $em->persist($newUser);
                $em->flush();

                $this->get('app.mailerbuilder')->mailer($newUser);

                return new JsonResponse(array(
                    'valide' => true,
                    'values' => $values,
                ));
            }
        }
        return $this->render('accueil/login.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $newUser
        ));
    }

    /**
     * @Route("/signup/final/step/{id}",options={"expose"=true},name="signupFinal")
     */
    public function signupFinalAction(Request $request, $id = null) {

        if ($id) {
            $firstStepSignUp = $this->getDoctrine()->getManager()->getRepository('AppBundle:SignUp')->find($id);
        } else {
            $firstStepSignUp = new SignUp();
        }

        $finalStepSignUp = new Utilisateur();

        $form = $this->get('form.factory')->create(UtilisateurType::class, $finalStepSignUp);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($finalStepSignUp);
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

        return $this->render('finalSignUp.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $finalStepSignUp,
                    'signup' => $firstStepSignUp
        ));
    }

    /**
     * @Route("/signup/final/step/complete",options={"expose"=true},name="autocomplete")
     */
    public function autoCompleteAjaxAction(Request $request) {
        if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest()) {
            $val = $request->request->get('valeur');
            $response = $this->container->get('app.searchpostalcode')->getData($val);

            return new JsonResponse($response);
        }
    }

}

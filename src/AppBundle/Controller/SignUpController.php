<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\SignUp;
use AppBundle\Form\SignUpType;

class SignUpController extends Controller {

    /**
     * @Route("/login",name="login")
     */
    public function loginAction() {
        $response = new JsonResponse;
        $response->setData(array('data' => '$errors')); //$this->render('accueil/login.html.twig');
        return $response;
    }

    /**
     * @Route("/signup/first/step",name="signup")
     */
    public function signupAction(Request $request) {

        $newUser = new SignUp();

        $form = $this->get('form.factory')->create(SignUpType::class, $newUser);
        $form->handleRequest($request);
        //ajax
        if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest()) {

            if (!$form->isValid()) {
                $errors = $this->getErrorMessages($form);
                return new JsonResponse(array('errors' => $errors, 'valide' => false,));
            }
            if ($form->isValid()) {
                $values = $request->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->persist($newUser);
                $em->flush();

                $mailSending = \Swift_Message::newInstance()
                        ->setSubject('Validation de votre inscription')
                        ->setFrom(array('cw.bocaboca@gmail.com' => 'Annuaire Bien-Etre'))
                        ->setTo('wg.wargnier@gmail.com')
                        ->setCharset('utf-8')
                        ->setContentType('text/html')
                        ->setBody($this->renderView('mail.html.twig'));
                $this->get('mailer')->send($mailSending);

                return new JsonResponse(array('valide' => true, 'values' => $values,));
            }
        }
        return $this->render('accueil/login.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $newUser
        ));
    }

    protected function getErrorMessages(\Symfony\Component\Form\Form $form) {

        $errors = array();

        foreach ($form->getErrors() as $key => $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }
        return $errors;
//        foreach ($form->all() as $key => $child) {
//            if ($err == $this->getErrorMessages($child))
//                $errors[$key] = $err;
//        }
//        return $errors;
    }

}

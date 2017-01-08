<?php

namespace AppBundle\Controller\SystemController\Security;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PasswordModification;
use AppBundle\Form\PasswordModificationType;

class SecurityController extends Controller {

    /**
     * @Route("/login", name="login",options={"expose"=true})
     */
    public function loginAction() {
        //redirection si l'user est déjà connecté
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('home');
        }
        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('Public/form.login.html.twig', array(
                    'last_username' => $authenticationUtils->getLastUsername(),
                    'error' => $authenticationUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * @Route("/gestion/login", name="change_password",options={"expose"=true})
     */
    public function passwordModificationAction(Request $request) {
        $new_pwd = new PasswordModification();
        $form = $this->get('form.factory')->create(PasswordModificationType::class, $new_pwd);
        $form->handleRequest($request);

        $error = '';

        if ($new_pwd->getNewPassword() === $new_pwd->getConfNewPassword() && $new_pwd->getNewPassword() !== null) {
            if ($form->isValid()) {

                $u = $this->getUser();

                $plainPassword = $new_pwd->getNewPassword();
                $encoder = $this->container->get('security.password_encoder');
                $encoded = $encoder->encodePassword($u, $plainPassword);

                $u->setPassword($encoded);

                $em = $this->getDoctrine()->getManager();
                $em->persist($u);

                $this->get('app.addmsgflash')->addMsgFlash($request, 'success', 'La modification de votre mot de passe est enregistrée!',true);
                try {
                    $em->flush();
                } catch (\Exception $e) {
                    $this->get('app.addmsgflash')->addMsgFlash($request, 'danger', "Une erreur est survenue l'enregistrement de votre mot de passe!",true);
                }
                return $this->redirectToRoute('home');
            }
        } elseif ($new_pwd->getPassword() === null) {
            $error = '';
        } else {
            $error = 'has-error';//class Bootstrap
        }

        dump($new_pwd);

        return $this->render('Public/form.new.password.html.twig', array(
                    'form' => $form->createView(),
                    'error' => $error,
        ));
    }

}

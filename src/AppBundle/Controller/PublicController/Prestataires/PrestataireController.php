<?php

/**
 * Created by PhpStorm.
 * User: wargnierc
 * Date: 18/10/2016
 * Time: 19:51
 */

namespace AppBundle\Controller\PublicController\Prestataires;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Prestataire;
use AppBundle\Entity\Utilisateur;
use AppBundle\Form\PrestataireType;

class PrestataireController extends Controller {

    /**
     * call by views/Public/Navigation/nav.parent.menu
     */
    public function getNavPrestatairesElementsAction() {

        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findAll();
        return $this->render('Public/Navigation/nav.child.prestataires.elements.html.twig', array(
                    'prestataires' => $prestataires,
        ));
    }

    /**
     * @Route("/inscription/prestataire",name="signupPrestataire")
     */
    public function subscribeNewPrestataireAction(Request $request) {

        $new_prestataire = new Prestataire();

        $form = $this->get('form.factory')->create(PrestataireType::class, $new_prestataire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($new_prestataire);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Profil Prestataire bien enregistré.');

            return $this->redirectToRoute('home');
        }
        return $this->render('Public\Prestataires\form.signup.prestataire.html.twig', array(
                    'form' => $form->createView(),
                    'prestataire' => $new_prestataire
        ));
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: wargnierc
 * Date: 18/10/2016
 * Time: 19:51
 */
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\SignUp;
use AppBundle\Entity\Prestataire;
use AppBundle\Entity\Internaute;
use AppBundle\Entity\Utilisateur;
use AppBundle\Form\SignUpType;
use AppBundle\Form\InternauteType;
use AppBundle\Form\UtilisateurType;
use AppBundle\Form\PrestataireType;

class PrestataireController extends Controller{

    /**
     * @Route("/prestataire/inscription",name="signupPrestataire")
     */
    public function subscribeNewPrestataireAction(Request $request) {
        $new_prestataire = new Prestataire();

        $form = $this->get('form.factory')->create(UtilisateurType::class, $new_prestataire);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($new_prestataire);
            $em->flush();
        }
        return $this->render('signupPrestataire.html.twig', array(
            'form' => $form->createView(),
            'prestataire' => $new_prestataire
        ));
    }
}
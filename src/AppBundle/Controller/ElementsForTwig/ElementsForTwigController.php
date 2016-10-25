<?php

namespace AppBundle\Controller\ElementsForTwig;

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

class ElementsForTwigController extends Controller {

    public function htmlBaseHeaderAction() {

        $new_user = new SignUp();
        $form = $this->get('form.factory')->create(SignUpType::class, $new_user);

        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findAll();
        $promotions = $this->getDoctrine()->getManager()->getRepository('AppBundle:Promotion')->findAll();
        $stages = $this->getDoctrine()->getManager()->getRepository('AppBundle:Stage')->findAll();
        $services = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->findAll();

        return $this->render('base.header.html.twig', array(
                    'prestataires' => $prestataires,
                    'promotions' => $promotions,
                    'stages' => $stages,
                    'services' => $services,
                    'form' => $form->createView(),
        ));
    }

}

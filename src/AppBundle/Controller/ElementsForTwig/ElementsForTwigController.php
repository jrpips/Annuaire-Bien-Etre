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
        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findAll();
        $promos = $this->getDoctrine()->getManager()->getRepository('AppBundle:Promotion')->findAll();
        $stages = $this->getDoctrine()->getManager()->getRepository('AppBundle:Stage')->findAll();
        $services = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->findAll();

        return $this->render('base.header.html.twig', array(
                    'p' => $prestataires,
                    'promos' => $promos,
                    'stages' => $stages,
                    'services' => $services
        ));
    }

}

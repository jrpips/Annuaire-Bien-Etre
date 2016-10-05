<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller {

    /**
     * @Route("/", name="accueil")
     */
    public function indexAction() {
        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findAll();
        $promos = $this->getDoctrine()->getManager()->getRepository('AppBundle:Promotion')->findAll();
        $stages = $this->getDoctrine()->getManager()->getRepository('AppBundle:Stage')->findAll();
        $services = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->findAll();
        dump($prestataires);
        return $this->render('accueil/index.html.twig', array(
            'p'=>$prestataires ,
            'promos'=>$promos,
            'stages'=>$stages,
            'services'=>$services
        ));
    }

}

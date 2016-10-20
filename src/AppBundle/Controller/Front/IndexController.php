<?php

namespace AppBundle\Controller\Front;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller {

    /**
     * @Route("/", name="home")
     */
    public function indexAction() {
        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findAll();
        
        return $this->render('accueil/index.html.twig', array(
                    'prestataires' => $prestataires,
       ));
    }

    /**
     * @Route("/about",name="about")
     */
    public function aboutAction() {
        return $this->render('accueil/login.html.twig');
    }

    /**
     * @Route("/contact",name="contact")
     */
    public function contactAction() {
        
    }

}

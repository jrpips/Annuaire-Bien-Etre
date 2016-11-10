<?php

namespace AppBundle\Controller\PublicController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller {

    /**
     * @Route("/", name="home")
     */
    public function indexAction() {

        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findAll();

        dump($prestataires);
        return $this->render('Public/index.html.twig', array(
                    'prestataires' => $prestataires,                  
        ));
    }

    /**
     * @Route("/about",name="about")
     */
    public function aboutAction() {
        return $this->render('Public/index.html.twig');
    }

    /**
     * @Route("/contact",name="contact")
     */
    public function contactAction() {
        
    }

}

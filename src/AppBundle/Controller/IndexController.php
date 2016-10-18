<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Utilisateur;
use AppBundle\AjaxDataValidation\AjaxDataValidation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;

class IndexController extends Controller {

    /**
     * @Route("/", name="home")
     */
    public function indexAction() {
        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findAll();
//        $promos = $this->getDoctrine()->getManager()->getRepository('AppBundle:Promotion')->findAll();
//        $stages = $this->getDoctrine()->getManager()->getRepository('AppBundle:Stage')->findAll();
//        $services = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->findAll();
        
        return $this->render('accueil/index.html.twig', array(
                    'p' => $prestataires,
//                    'promos' => $promos,
//                    'stages' => $stages,
//                    'services' => $services
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

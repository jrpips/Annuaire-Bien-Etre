<?php

namespace AppBundle\Controller\PublicController\CategServices;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\CategService;

class CategServiceController extends Controller {
    /** 
     * call by views/Public/Navigation/nav.parent.menu
     */
    public function getNavServicesElementsAction() {

        $services = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->myFindValideServices();
        return $this->render('Public/Navigation/Links/link.services.elements.html.twig', array(
                    'services' => $services,
        ));
    }

    /**
     * @Route("/services/liste", name="liste_services")
     */
    public function getListServicesAction() {

        $services = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->myFindValideServices();
        dump($services);
        return $this->render('Public/Services/display.liste.services.html.twig', array(
                    'services' => $services,
        ));
    }

    /**
     * @Route("/services/details/du/service/{service_nom}", name="details_service")
     */
    public function getDetailsServiceAction($service_nom) {

        $service = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->findOneByNom($service_nom);
        dump($service);
        return $this->render('Public/Services/display.details.service.html.twig', array(
                    'service' => $service,
        ));
    }

}

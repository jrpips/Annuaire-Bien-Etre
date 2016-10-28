<?php

namespace AppBundle\Controller\PublicController\CategServices;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\CategService;

class CategServicesController extends Controller {
    /** 
     * call by views/Public/Navigation/nav.parent.menu
     */
    public function getNavServicesElementsAction() {

        $services = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->findAll();
        return $this->render('Public/Navigation/nav.child.services.elements.html.twig', array(
                    'services' => $services,
        ));
    }

    /**
     * @Route("/services/liste", name="liste_services")
     */
    public function getListServicesAction() {

        $services = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->findAll();
        dump($services);
        return $this->render('Public/Services/display.liste.services.html.twig', array(
                    'services' => $services,
        ));
    }

    /**
     * @Route("/services/service/details/{service_id}", name="details_service")
     */
    public function getDetailsServiceAction($service_id) {

        $service = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->find($service_id);
        dump($service);
        return $this->render('Public/Services/display.details.service.html.twig', array(
                    'service' => $service,
        ));
    }

}

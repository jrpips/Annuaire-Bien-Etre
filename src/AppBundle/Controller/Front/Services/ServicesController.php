<?php

namespace AppBundle\Controller\Front\Services;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\CategService;

class ServicesController extends Controller {

    /**
     * @Route("/services/liste", name="liste_services")
     */
    public function getListServicesAction() {

        $services = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->findAll();
        dump($services);
        return $this->render('accueil/liste.services.html.twig', array(
                    'services' => $services,
        ));
    }
    /**
     * @Route("/services/service/details/{service_id}", name="details_service")
     */
    public function getDetailsServiceAction($service_id) {

        $service = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->find($service_id);
        dump($service);
        return $this->render('accueil/details.service.html.twig', array(
                    'service' => $service,
        ));
    }

}

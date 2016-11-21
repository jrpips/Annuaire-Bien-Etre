<?php

namespace AppBundle\Controller\PublicController\CategServices;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\CategService;
use AppBundle\Entity\Prestataire;

class PrestataireServicesController extends Controller {
    /**
     * @Route("/prestataire/consultation/liste/services",name="prestataire_services")
     */
    public function listeStageAction(Request $request)
    {
        $services = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->findServicesByNomPrestataire($this->getUser()->getPrestataire()->getNom());
        dump($services);
        return $this->render('Public/Prestataires/FrontOffice/Services/display.list.services.prestataire.html.twig', array(
            'services' => $services,
        ));
    }
}
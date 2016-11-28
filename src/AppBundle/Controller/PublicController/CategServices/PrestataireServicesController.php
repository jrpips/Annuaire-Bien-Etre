<?php
namespace AppBundle\Controller\PublicController\CategServices;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\CategService;
use AppBundle\Entity\Prestataire;
use AppBundle\Form\CategServiceType;

class PrestataireServicesController extends Controller
{
    /**
     * @Route("/prestataire/consultation/liste/services",name="prestataire_services")
     */
    public function listeServicesPrestataireAction(Request $request)
    {
     $nomPrestataire=$this->getUser()->getPrestataire()->getNom();
        $listeServicesPrestataire = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')
            ->findServicesByNomPrestataire($nomPrestataire);

        $listeServicesAnnuaire = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')
             ->findAll();

        dump($listeServicesPrestataire, $listeServicesAnnuaire);

        return $this->render('Public/Prestataires/FrontOffice/Services/display.list.services.prestataire.html.twig', array(
            'servicesP' => $listeServicesPrestataire,
            'servicesA' => $listeServicesAnnuaire
        ));
    }

    /**
     * @Route("/prestataire/ajouter/service",name="add_service")
     */
    public function addNewServiveAction(Request $request)
    {
        $newService = new CategService();
        $form = $this->get('form.factory')->create(CategServiceType::class, $newService);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $newService->setValide(false)->addPrestataire($this->getUser()->getPrestataire());

            $em = $this->getDoctrine()->getManager();
            $em->persist($newService);
            $em->flush();

            $this->get('app.mailerbuilder')->addNewServiceMailer(null);
        }
        //dump($newService);
        return $this->render('Public/Prestataires/FrontOffice/Services/form.new.service.html.twig', array(
            'form' => $form->createView(),
            'newService' => $newService
        ));
    }

}
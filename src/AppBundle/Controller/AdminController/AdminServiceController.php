<?php
/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 1/01/2017
 * Time: 15:17
 */

namespace AppBundle\Controller\AdminController;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\CategService;
use AppBundle\Form\CategServiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Commentaire;

class AdminServiceController extends Controller
{
    /**
     * @Route("/admin/gestion/demande/service",name="dashboard_services")
     */
    public function gestionDemandeServiceAction()
    {
        $services = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->myFindValideServices(false);
        dump($services);
        return $this->render('Admin/GestionServices/dashboard.services.html.twig', array(
            'services' => $services
        ));
    }

    /**
     * @Route("/admin/suppression/service/{service}",name="delete_service")
     */
    public function deleteServiveAction(CategService $service)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($service);
        $em->flush();

        return $this->redirectToRoute('dashboard_services');
    }

    /**
     * @Route("/admin/validation/service/{service}",name="valid_service")
     */
    public function validServiveAction(CategService $service)
    {
        $em = $this->getDoctrine()->getManager();
        $service->setValide(true);
        $em->flush();

        return $this->redirectToRoute('dashboard_services');
    }

    /**
     * @Route("/admin/mise-a-jour/service/{service}",name="cu_service")
     */
    public function updateServiveAction(Request $request,CategService $service=null)
    {
        $service=($service==null)?new CategService():$service;

        $form = $this->get('form.factory')->create(CategServiceType::class, $service);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $service->setValide(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            return $this->redirectToRoute('dashboard_services');
        }
        //dump($newService);
        return $this->render('Admin/GestionServices/form.update.service.html.twig', array(
            'form' => $form->createView(),
            'service' => $service
        ));


    }
}
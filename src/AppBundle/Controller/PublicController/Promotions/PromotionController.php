<?php

/**
 *
 * User: wargnierc
 * Date: 28/10/2016
 *
 */

namespace AppBundle\Controller\PublicController\Promotions;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Promotion;
use AppBundle\Form\PromotionType;

class PromotionController extends Controller
{

    /**
     * call by views/Public/Navigation/nav.parent.menu
     */
    public function getNavPromotionsElementsAction()
    {

        $promotions = $this->getDoctrine()->getManager()->getRepository('AppBundle:Promotion')->findBy(array(), array('dateDebut' => 'desc'), 5);
        dump($promotions);
        return $this->render('Public/Navigation/Links/link.promotions.elements.html.twig', array(
            'promotions' => $promotions,
        ));
    }

    /**
     * @Route("/prestataire/promotion",options={"expose"=true},name="dashboard_promotion")
     */
    public function promotionDashboardAction(Request $request)
    {
        $promotions = $this->getDoctrine()->getManager()->getRepository('AppBundle:Promotion')->findPrestatairePromotions($this->getUser()->getPrestataire()->getNom());
        dump($promotions);
        return $this->render('Public/Prestataires/FrontOffice/Promotions/display.dashboard.promotion.html.twig', array(
            'promotions' => $promotions,
        ));
    }

    /**
     * @Route("/prestataire/promotion/ajouter",options={"expose"=true},name="new_promotion")
     */
    public function addNewPromotionAction(Request $request)
    {
        $promotion = new Promotion();

        $form = $this->get('form.factory')->create(PromotionType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $promotion->setPrestataire($this->getUser()->getPrestataire());

            $em->persist($promotion);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Profil Prestataire bien enregistré.');

            return $this->redirectToRoute('home');
        }

        return $this->render('Public/Prestataires/FrontOffice/Promotions/form.add.promotion.html.twig', array(
            'promotion' => $promotion,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/prestataire/mise-a-jour/promotion/{nom_promotion}",name="update_promotion")
     */
    public function updatepromotionAction(Request $request, $nom_promotion)
    {
        $promotion = $this->getDoctrine()->getManager()->getRepository('AppBundle:promotion')->findByNom($nom_promotion);

        dump($promotion);
        $form = $this->get('form.factory')->create(promotionType::class, $promotion[0]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'promotion modifiée.');//TODO : fenêtre popup affichage message succès...

            return $this->redirectToRoute('dashboard_promotion');//TODO : ...sur la page de redirection
        }

        return $this->render('Public/Prestataires/FrontOffice/Promotions/update.promotion.html.twig', array(
            'promotion' => $promotion[0],
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/prestataire/suppression/promotion/{nom_promotion}",name="delete_promotion")
     */
    public function deletepromotionAction(Request $request, $nom_promotion)
    {
        //$prestaire_nom =$this->getUser()->getPrestataire()->getNom();

        $promotion = $this->getDoctrine()->getManager()->getRepository('AppBundle:Promotion')->findByNom($nom_promotion);
        $em = $this->getDoctrine()->getManager();
        $em->remove($promotion[0]);
        $em->flush();

        return $this->redirectToRoute('dashboard_promotion');

    }
}
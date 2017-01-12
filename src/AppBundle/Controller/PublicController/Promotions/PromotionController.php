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
use AppBundle\Entity\CategService;
use AppBundle\Form\PromotionType;
//use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PromotionController extends Controller
{

    /**
     * call by views/Public/Navigation/nav.parent.menu
     */
    public function getNavPromotionsElementsAction()
    {

        $promotions = $this->getDoctrine()->getManager()->getRepository('AppBundle:Promotion')->findBy(array(), array('dateDebut' => 'desc'), 5);

        return $this->render('Public/Navigation/Links/link.promotions.elements.html.twig', array(
            'promotions' => $promotions,
        ));
    }

    /**
     * @Route("/prestataire/promotion",options={"expose"=true},name="dashboard_promotion")
     */
    public function promotionDashboardAction(/*Request $request*/)
    {
        $promotions = $this->getDoctrine()->getManager()->getRepository('AppBundle:Promotion')->findPrestatairePromotions($this->getUser()->getPrestataire()->getNom());

        return $this->render('Public/Prestataires/FrontOffice/Promotions/display.dashboard.promotion.html.twig', array(
            'promotions' => $promotions,
        ));
    }

    /**
     * @Route("/prestataire/ajout/promotion",options={"expose"=true},name="new_promotion")
     */
    public function addNewPromotionAction(Request $request)
    {
        $promotion = new Promotion();

        $form = $this->get('form.factory')->create(PromotionType::class, $promotion,['user'=>$this->getUser()->getPrestataire()->getId()]);//->add('categService', EntityType::class, array(

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $promotion->setPrestataire($this->getUser()->getPrestataire());

            $em->persist($promotion);

            $statut = 'success';
            $text = 'Votre promotion a été créée!';

            try {
                $em->flush();

            } catch (\Exception $e) {
                $statut = 'danger';
                $text = 'Une erreur est survenue lors de la création de votre promotion!';
            }
            $this->get('app.addmsgflash')->addMsgFlash($request, $statut, $text, true);
            return $this->redirectToRoute('dashboard_promotion');
        }
        return $this->render('Public/Prestataires/FrontOffice/Promotions/form.promotion.html.twig', array(
            'promotion' => $promotion,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/prestataire/mise-a-jour/promotion/{nom_promotion}",name="update_promotion")
     */
    public function updatepromotionAction(Request $request, $nom_promotion)
    {
        $promotion = $this->getDoctrine()->getManager()->getRepository('AppBundle:promotion')->findOneByNom($nom_promotion);


        $form = $this->get('form.factory')->create(promotionType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $statut = 'success';

            try {
                $em->flush();

            } catch (\Exception $e) {
                $statut = 'danger';
            }
            $this->get('app.addmsgflash')->addMsgFlash($request, $statut, 'votre promotion');
            return $this->redirectToRoute('dashboard_promotion');
        }

        return $this->render('Public/Prestataires/FrontOffice/Promotions/form.promotion.html.twig', array(
            'promotion' => $promotion,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/prestataire/retrait/promotion/{nom_promotion}",name="delete_promotion")
     */
    public function deletepromotionAction(/*Request $request,*/ $nom_promotion)
    {
        //$prestaire_nom =$this->getUser()->getPrestataire()->getNom();

        $promotion = $this->getDoctrine()->getManager()->getRepository('AppBundle:Promotion')->findOneByNom($nom_promotion);
        $em = $this->getDoctrine()->getManager();
        $em->remove($promotion);
        $em->flush();

        return $this->redirectToRoute('dashboard_promotion');

    }
}
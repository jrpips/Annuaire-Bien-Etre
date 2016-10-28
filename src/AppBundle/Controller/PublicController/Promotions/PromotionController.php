<?php

/**
 * 
 * User: wargnierc
 * Date: 28/10/2016
 * 
 */

namespace AppBundle\Controller\PublicController\Promotions;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Promotion;

class PromotionController extends Controller {

    /**
     * call by views/Public/Navigation/nav.parent.menu
     */
    public function getNavPromotionsElementsAction() {

        $promotions = $this->getDoctrine()->getManager()->getRepository('AppBundle:Promotion')->findAll();
        return $this->render('Public/Navigation/nav.child.promotions.elements.html.twig', array(
                    'promotions' => $promotions,
        ));
    }
}
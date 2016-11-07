<?php

/**
 * 
 * User: wargnierc
 * Date: 28/10/2016
 * 
 */

namespace AppBundle\Controller\PublicController\Stages;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Stage;

class StageController extends Controller {

    /**
     * call by views/Public/Navigation/nav.parent.menu
     */
    public function getNavStagesElementsAction() {

        $stages = $this->getDoctrine()->getManager()->getRepository('AppBundle:Stage')->findAll();
        return $this->render('Public/Navigation/Children/nav.child.stages.elements.html.twig', array(
                    'stages' => $stages,
        ));
    }
}
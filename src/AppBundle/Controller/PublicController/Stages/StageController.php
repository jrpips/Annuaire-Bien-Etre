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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\StageType;


class StageController extends Controller
{

    /**
     * call by views/Public/Navigation/nav.parent.menu
     */
    public function getNavStagesElementsAction()
    {
        $stages = $this->getDoctrine()->getManager()->getRepository('AppBundle:Stage')->findAll();

        return $this->render('Public/Navigation/Links/link.stages.elements.html.twig', array(
            'stages' => $stages,
        ));
    }

    /**
     * @Route("/prestataire/dashboard/stages/{prestataire_nom}",name="dashboard_stage")
     */
    public function dashboardStageAction(Request $request, $prestataire_nom)
    {
        $stages = $this->getDoctrine()->getManager()->getRepository('AppBundle:Stage')->findStagesByNomPrestataire($prestataire_nom);
        dump($stages);
        return $this->render('Public/Prestataires/FrontOffice/Stages/display.dashboard.stage.html.twig', array(
            'stages' => $stages,
        ));
    }

    /**
     * @Route("/prestataire/creation/nouveau/stage",name="create_stage")
     */
    public function createStageAction(Request $request)
    {
        $stage = new Stage();
        $prestataire = $this->getUser()->getPrestataire();

        $form = $this->get('form.factory')->create(StageType::class, $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $stage->setPrestataire($prestataire);

            $em = $this->getDoctrine()->getManager();
            $em->persist($stage);
            try {
                $em->flush();

            } catch (\Exception $e) {
                $this->get('app.addmsgflash')->addMsgFlash($request, 'danger', 'Une erreur est survenue lors de la création de votre stage!',true);
                return $this->redirectToRoute('create_stage');
            }
            $this->get('app.addmsgflash')->addMsgFlash($request, 'success', 'Votre nouveau stage est enregistré!');

            return $this->redirectToRoute('dashboard_stage',array('prestataire_nom'=>$this->getUser()->getPrestataire()->getNom()));
        }

        return $this->render('Public/Prestataires/FrontOffice/Stages/form.stage.html.twig', array(
            'stage' => $stage,
            'form' => $form->createView(),
            'title'=>"Création d'un stage"
        ));
    }

    /**
     * @Route("/prestataire/mise-a-jour/stage/{nom_stage}",name="update_stage")
     */
    public function updateStageAction(Request $request, $nom_stage)
    {
        $stage = $this->getDoctrine()->getManager()->getRepository('AppBundle:Stage')->findOneByNom($nom_stage);

        $form = $this->get('form.factory')->create(StageType::class, $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $statut='success';
            try {
                $em->flush();

            } catch (\Exception $e) {
               $statut='danger';
            }
            $this->get('app.addmsgflash')->addMsgFlash($request, $statut, 'votre stage');

            return $this->redirectToRoute('list_stages',array('prestataire_nom'=>$this->getUser()->getPrestataire()->getNom()));
        }

        return $this->render('Public/Prestataires/FrontOffice/Stages/form.stage.html.twig', array(
            'stage' => $stage,
            'form' => $form->createView(),
        ));
    }
    /**
     * @Route("/prestataire/retrait/stage/{nom_stage}",name="delete_stage")
     */
    public function deleteStageAction(Request $request, $nom_stage)
    {
        $stage = $this->getDoctrine()->getManager()->getRepository('AppBundle:Stage')->findOneByNom($nom_stage);
        $em = $this->getDoctrine()->getManager();
        $em->remove($stage);
        $em->flush();

        return $this->redirectToRoute('dashboard_stage',array('prestataire_nom'=>$this->getUser()->getPrestataire()->getNom()));

    }
}
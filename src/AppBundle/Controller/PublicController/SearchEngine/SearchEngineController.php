<?php
/**
 * User: Wargnier C.
 * Date: 12/01/2017
 */

namespace AppBundle\Controller\PublicController\SearchEngine;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\SearchEngineType;


class SearchEngineController extends Controller
{
    /**
     * @Route("/recherche",options={"expose"=true},name="form_advanced_search")
     */
    public
    function searchEngineAction()
    {
        $form = $this->get('form.factory')->create(SearchEngineType::class);

        return $this->render('Public\Navigation\Links\MoteurDeRecherche\form.moteur.de.recherche.prestataire.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/resultat/recherche/simple/{mot}",options={"expose"=true},name="simple_search_prestataire")
     */
    public
    function simpleSearchAction(Request $request, $mot = null)
    {//TODO : FAIRE UN CONTROLLER POUR LE MOTEUR RECHERCHE
        if ($mot) {
            $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findAll();
        } else {
            $criteria = $request->request->all();
            $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->simpleSearchPrestataire($criteria);
        }
        return $this->render('Public\Prestataires\FoundPrestataires\display.liste.selected.prestataires.html.twig', array(
            'prestataires' => $prestataires
        ));
    }

    /**
     * @Route("/resultat/recherche/avancee",options={"expose"=true},name="advanced_search_prestataire")
     */
    public
    function advancedSearcheAction(Request $request)
    {
        $criteria = $request->request->get('search_engine');
        dump($criteria);
        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->advancedSearchPrestataire($criteria);

        return $this->render('Public\Prestataires\FoundPrestataires\display.liste.selected.prestataires.html.twig', array(
            'prestataires' => $prestataires
        ));
    }

}
<?php

/**
 * Controller PRESTATAIRE
 *
 *      getChildNavPrestatairesElementsAction()  -->   collecte en DB des 5 derniers Prestataires inscrits pour la construction du menu principale
 *
 *      subscribeNewPrestataireAction()          -->   inscription d'un nouveau Prestataire
 *
 *      getPrestataireDetailsAction(param: nom)  -->   collecte en DB le profil complet du Prestataire correspondant au choix de l'utilisateur
 *
 *      moteurDeRechercheAction()                -->   construction du formulaire de recherche d'un Prestataire
 *
 *      moteurDeRechercheResultAction(param: value form recherche)
 *                                               -->   recherche pour affichage des Prestataires correspondant aux param. reçus
 *      addCommentAction(param: nom Prestataire) -->   ajout d'un commentaire
 */

namespace AppBundle\Controller\PublicController\Prestataires;

use Faker\Provider\cs_CZ\DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Prestataire;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Commentaire;
use AppBundle\Form\PrestataireType;
use AppBundle\Form\MoteurDeRechercheType;

class PrestataireController extends Controller
{
    /**
     * call by views/Public/Navigation/nav.parent.menu
     */
    public function getChildNavPrestatairesElementsAction()
    {
        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findAll();

        return $this->render('Public/Navigation/Children/nav.child.prestataires.elements.html.twig', array(
            'prestataires' => $prestataires,
        ));
    }

    /**
     * @Route("/inscription/prestataires",name="signupPrestataire")
     */
    public function subscribeNewPrestataireAction(Request $request)
    {
        $new_prestataire = new Prestataire();

        $form = $this->get('form.factory')->create(PrestataireType::class, $new_prestataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($new_prestataire);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Profil Prestataire bien enregistré.');

            return $this->redirectToRoute('home');
        }
        return $this->render('Public\Prestataires\form.signup.prestataire.html.twig', array(
            'form' => $form->createView(),
            'prestataire' => $new_prestataire
        ));
    }

    /**
     * @Route("/details/prestataire/{prestataire_nom}",name="details_prestataire")
     */
    public function getPrestataireDetailsAction($prestataire_nom)
    {
        $prestataire = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->getCompleteProfilePrestataire($prestataire_nom);
        $categServices = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->findAll();
        dump($prestataire, $categServices);
        return $this->render('Public/Prestataires/display.details.prestataire.html.twig', array(
            'prestataire' => $prestataire,
            'categServices' => $categServices
        ));
    }

    /**
     * @Route("recherche/prestataire",options={"expose"=true},name="search_prestataire")
     */
    public function moteurDeRechercheAction()
    {

        $form = $this->get('form.factory')->create(MoteurDeRechercheType::class);

        return $this->render('Public\Navigation\Children\MoteurDeRecherche\form.moteur.de.recherche.prestataire.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("recherche/prestataire/resultat",options={"expose"=true},name="search_nom_prestataire")
     */
    public function moteurDeRechercheResultAction(Request $request)
    {

        dump($request->request);
        $criteria = $request->request->all();

        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findMyPrestataire($criteria);
        dump($prestataires, $criteria);

        return $this->render('Public\Prestataires\SearchPrestataire\resultat.recherche.prestataire.html.twig', array(
            'prestataires' => $prestataires
        ));
    }


}

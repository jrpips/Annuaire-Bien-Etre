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
use AppBundle\Entity\CategService;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Commentaire;
use AppBundle\Form\PrestataireType;
use AppBundle\Form\ContactPrestataireType;
use AppBundle\Form\MoteurDeRechercheType;

class PrestataireController extends Controller
{
    /**
     * call by views/Public/Navigation/nav.parent.menu
     */
    public function getChildNavPrestatairesElementsAction()
    {
        if (!$this->isGranted('ROLE_ADMIN')&&$this->isGranted('ROLE_INTERNAUTE')) {
            $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')
                ->findPrestatairesFavoris($this->getUser()->getInternaute()->getNom());
        } else {
            $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')
                ->findLastPrestataires();
        }
        dump($prestataires);
        return $this->render('Public/Navigation/Links/link.prestataires.elements.html.twig', array(
            'prestataires' => $prestataires,
        ));
    }

    /**
     * @Route("/inscription/prestataires",name="signupPrestataire")
     */
    public
    function subscribeNewPrestataireAction(Request $request)
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
    public
    function getPrestataireDetailsAction($prestataire_nom)
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
     * @Route("recherche/prestataire",options={"expose"=true},name="form_advanced_search")
     */
    public
    function moteurDeRechercheAction()
    {

        $form = $this->get('form.factory')->create(MoteurDeRechercheType::class);

        return $this->render('Public\Navigation\Children\MoteurDeRecherche\form.moteur.de.recherche.prestataire.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("recherche/prestataire/resultat",options={"expose"=true},name="simple_search_prestataire")
     */
    public
    function simpleMoteurDeRechercheAction(Request $request)
    {
        dump($request->request);
        $criteria = $request->request->all();

        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->simpleSearchPrestataire($criteria);
        dump($prestataires, $criteria);

        return $this->render('Public\Prestataires\FoundPrestataires\display.liste.selected.prestataires.html.twig', array(
            'prestataires' => $prestataires
        ));
    }
    /**
     * @Route("recherche/prestataire/resultat",options={"expose"=true},name="advanced_search_prestataire")
     */
    public
    function advancedMoteurDeRechercheAction(Request $request)
    {
        dump($request->request);
        $criteria = $request->request->all();

        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->advancedSearchPrestataire($criteria);
        dump($prestataires, $criteria);

        return $this->render('Public\Prestataires\FoundPrestataires\display.liste.selected.prestataires.html.twig', array(
            'prestataires' => $prestataires
        ));
    }

    /**
     *  render formulaire contact Prestataire
     */
    public
    function getFormContactPrestataireAction()
    {
        $form = $this->get('form.factory')->create(ContactPrestataireType::class);
        return $this->render('Public/Prestataires/form.contact.prestataire.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/prestataire/mise-a-jour",options={"expose"=true},name="update_prestataire")
     */
    public
    function updatePrestataireAction(Request $request)
    {
        return false;
    }

    /**
     * @Route("internaute/contact/prestataire",options={"expose"=true},name="send_mail_prestataire")
     */
    public
    function sendMailToPrestataireAction(Request $request)
    {
        $emailPrestataire = $request->get('prestataire_email');
        $form = $this->get('form.factory')->create(ContactPrestataireType::class);

        $form->handleRequest($request);
        //ajax
        if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest()) {

            if (!$form->isValid()) {

                $errors = $this->get('app.geterrormessages')->getErrorMessages($form);

                return new JsonResponse(array(
                    'errors' => $errors,
                    'valide' => false,
                ));
            }
            if ($form->isValid()) {

                $values = $request->request->all();

                $this->get('app.mailerbuilder')->contactPrestataireMailer($values);

                return new JsonResponse(array(
                    'valide' => true,
                    'values' => $values,
                    'email' => $emailPrestataire
                ));
            }
        }
    }

    /**
     * @Route("/utilisateur/selection/prestataires/proposant/service/{service}",name="service_prestataires")
     */
    public
    function getListePrestatairesByService($service)
    {
        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findPrestatairesByService($service);
        dump($prestataires);

        return $this->render('Public\Prestataires\FoundPrestataires\display.liste.selected.prestataires.html.twig', array(
            'prestataires' => $prestataires
        ));
    }

    /**
     * @Route("/prestataire/retirer/service",options={"expose"=true},name="remove_service")
     */
    public function removeServiveAction(Request $request)
    {
        $service = $request->request->get('service');

        $em = $this->getDoctrine()->getManager();

        $oldService = $em
            ->getRepository('AppBundle:CategService')
            ->findByNom($service);
        $nom = $this->getUser()->getPrestataire()->getNom();
        echo $nom;
        $p = $em
            ->getRepository('AppBundle:Prestataire')
            ->findPrestataire($nom);

        $oldService[0]->removePrestataire($p[0]);

        $em = $this->getDoctrine()->getManager();
        $em->flush();
        //dump($oldService,$p);
        return new JsonResponse('ok');//$this->redirectToRoute('prestataire_services');
    }
    /**
     * @Route("/prestataire/add/service",options={"expose"=true},name="ajout_service")
     */
    public function addServiveAction(Request $request)
    {
        $service = $request->request->get('service');

        $em = $this->getDoctrine()->getManager();

        $oldService = $em
            ->getRepository('AppBundle:CategService')
            ->findByNom($service);

        $nom = $this->getUser()->getPrestataire()->getNom();

        $p = $em
            ->getRepository('AppBundle:Prestataire')
            ->findPrestataire($nom);

     $oldService[0]->addPrestataire($p[0]);

        $em = $this->getDoctrine()->getManager();
        $em->flush();
        dump($oldService,$p);
        return new JsonResponse('ok');//$this->redirectToRoute('prestataire_services');
    }
}

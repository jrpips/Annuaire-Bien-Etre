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
use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use AppBundle\Form\UtilisateurType;
use AppBundle\Form\PrestataireType;
use AppBundle\Form\ContactType;
use AppBundle\Form\MoteurDeRechercheType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PrestataireController extends Controller
{
    /**
     * call by views/Public/Navigation/nav.parent.menu
     */
    public function getChildNavPrestatairesElementsAction()
    {
        if ($this->isGranted('ROLE_INTERNAUTE') && !$this->isGranted('ROLE_ADMIN')) {
            $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')
                ->findPrestatairesFavoris($this->getUser()->getInternaute()->getNom());
        } else {
            $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')
                ->findLastPrestataires();
        }
        return $this->render('Public/Navigation/Links/link.prestataires.elements.html.twig', array(
            'prestataires' => $prestataires,
        ));
    }

    /**
     * @Route("/inscription",name="signupPrestataire")
     */
    public
    function subscribeNewPrestataireAction(Request $request)
    {
        $new_prestataire = new Utilisateur();

        $form = $this->get('form.factory')->create(UtilisateurType::class, $new_prestataire)->add('prestataire', PrestataireType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $new_prestataire->setSalt('')->setRoles('ROLE_PRESTATAIRE');

            $em = $this->getDoctrine()->getManager();
            $em->persist($new_prestataire);
            try {
                $em->flush();

            } catch (\Exception $e) {

                $this->get('app.addmsgflash')->addMsgFlash($request, 'danger', 'Une erreur est survenue lors de votre inscription!',true);
                return $this->redirectToRoute('signupPrestataire');
            }
            $this->get('app.addmsgflash')->addMsgFlash($request, 'success', 'Votre inscription est enregistrée!',true);

            return $this->redirectToRoute('details_prestataire', array('prestataire_nom' => $new_prestataire->getNom()));
        }
        return $this->render('Public\Prestataires\Register\form.signup.prestataire.html.twig', array(
            'form' => $form->createView(),
            'prestataire' => $new_prestataire
        ));
    }

    /**
     * @Route("/prestataire/image/{type}/{prestataire}",options={"expose"=true},name="image_prestataire")
     */
    public
    function logoPrestataireAction(Request $request, Prestataire $prestataire = null, $type = null)
    {
        $prestataire = (!$this->isGranted('ROLE_ADMIN')) ? $this->getUser()->getPrestataire() : $prestataire;

        if ($type == 'logo' && $prestataire->getLogo()) {
            $img = $prestataire->getLogo();
        } elseif ($type == 'cover' && $prestataire->getCover()) {
            $img = $prestataire->getCover();
        } else {
            $img = new Image();
        }

        $form = $this->get('form.factory')->create(ImageType::class, $img)->add('Envoyer', SubmitType::class, array('attr' => array('class' => 'btn btn-default pull-right')));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $img->setName($prestataire->getNom());
            ($type == 'logo') ? $prestataire->setLogo($img) : $prestataire->setCover($img);

            $em = $this->getDoctrine()->getManager();
            $em->persist($img);
            try {
                $em->flush();

            } catch (\Exception $e) {

                $this->get('app.addmsgflash')->addMsgFlash($request, 'danger', 'votre ' . $type);
                return $this->redirectToRoute('image_prestataire', array('type' => $type));
            }
            $this->get('app.addmsgflash')->addMsgFlash($request, 'success', 'votre ' . $type);
            return $this->redirectToRoute('details_prestataire', array('prestataire_nom' => $prestataire->getNom()));

        }
        return $this->render('Public\Prestataires\EditProfil\form.image.prestataire.html.twig', array(
            'form' => $form->createView(),
            'image'=>$img,
            'type' => $type
        ));

    }

    /**
     * @Route("/prestataire/mise-a-jour/{nomPrestataire}",options={"expose"=true},name="update_prestataire")
     */
    public
    function updatePrestataireAction(Request $request, $nomPrestataire = null)
    {
        if ($nomPrestataire) {
            $userP = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findOneByNom($nomPrestataire);
        } else {
            $userP = $this->getUser();
        }

        $userP->setConfPwd($userP->getPassword());

        $form = $this->get('form.factory')->create(UtilisateurType::class, $userP)->add('prestataire', PrestataireType::class)
            ->remove('password', PasswordType::class, array('required' => false))->remove('confPwd', PasswordType::class, array('required' => false));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            try {
                $em->flush();

            } catch (\Exception $e) {
                $this->get('app.addmsgflash')->addMsgFlash($request, 'danger', 'votre profil');
                return $this->redirectToRoute('update_prestataire', array('nomPrestataire' => $userP->getPrestataire()->getNom()));
            }
            $this->get('app.addmsgflash')->addMsgFlash($request, 'success', 'votre profil');
            return $this->redirectToRoute('details_prestataire', array('prestataire_nom' => $userP->getPrestataire()->getNom()));

        }
        return $this->render('Public\Prestataires\Register\form.signup.prestataire.html.twig', array(
            'form' => $form->createView(),
            'prestataire' => $userP
        ));
    }

    /**
     * @Route("/profil/{prestataire_nom}",name="details_prestataire")
     */
    public
    function getPrestataireDetailsAction($prestataire_nom)
    {
        $prestataire = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->getCompleteProfilePrestataire($prestataire_nom);
        $categServices = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->findAll();

        return $this->render('Public/Prestataires/display.details.prestataire.html.twig', array(
            'prestataire' => $prestataire,
            'categServices' => $categServices
        ));
    }

    /**
     * @Route("/recherche",options={"expose"=true},name="form_advanced_search")
     */
    public
    function moteurDeRechercheAction()
    {
        $form = $this->get('form.factory')->create(MoteurDeRechercheType::class);

        return $this->render('Public\Navigation\Links\MoteurDeRecherche\form.moteur.de.recherche.prestataire.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/resultat/recherche/simple/{mot}",options={"expose"=true},name="simple_search_prestataire")
     */
    public
    function simpleMoteurDeRechercheAction(Request $request, $mot = null)
    {
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
    function advancedMoteurDeRechercheAction(Request $request)
    {
        $criteria = $request->request->all();
        dump($criteria);
        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->advancedSearchPrestataire($criteria);

        return $this->render('Public\Prestataires\FoundPrestataires\display.liste.selected.prestataires.html.twig', array(
            'prestataires' => $prestataires
        ));
    }

    /**
     *  render formulaire contact Prestataire
     */
    public
    function getFormContactAction()
    {
        $form = $this->get('form.factory')->create(ContactType::class);

        return $this->render('Form/form.contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/contacter/prestataire",options={"expose"=true},name="send_mail_prestataire")
     */
    public
    function sendMailToPrestataireAction(Request $request)
    {
        $emailPrestataire = $request->get('prestataire_email');
        $form = $this->get('form.factory')->create(ContactType::class);

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
     * @Route("/selection/service/{service}",name="service_prestataires")
     */
    public
    function getListePrestatairesByService($service)
    {
        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findPrestatairesByService($service);

        return $this->render('Public\Prestataires\FoundPrestataires\display.liste.selected.prestataires.html.twig', array(
            'prestataires' => $prestataires
        ));
    }

    /**
     * @Route("/prestataire/retrait/service",options={"expose"=true},name="remove_service")
     */
    public function removeServiveAction(Request $request)
    {
        $service = $request->request->get('service');

        $em = $this->getDoctrine()->getManager();

        $oldService = $em
            ->getRepository('AppBundle:CategService')
            ->findOneByNom($service);

        $p = $this->getUser()->getPrestataire();

        $oldService->removePrestataire($p);

        $em->flush();

        return new JsonResponse('ok');
    }

    /**
     * @Route("/prestataire/ajout/service",options={"expose"=true},name="ajout_service")
     */
    public function addServiceAction(Request $request)
    {
        $service = $request->request->get('service');

        $em = $this->getDoctrine()->getManager();

        $oldService = $em
            ->getRepository('AppBundle:CategService')
            ->findOneByNom($service);

        $p = $this->getUser()->getPrestataire();

        $oldService->addPrestataire($p);

        $em->flush();

        return new JsonResponse('ok');
    }
}

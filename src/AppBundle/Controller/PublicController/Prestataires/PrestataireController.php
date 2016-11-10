<?php

/**
 * Created by PhpStorm.
 * User: wargnierc
 * Date: 18/10/2016
 * Time: 19:51
 */

namespace AppBundle\Controller\PublicController\Prestataires;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Prestataire;
use AppBundle\Entity\Utilisateur;
use AppBundle\Form\PrestataireType;
use AppBundle\Form\MoteurDeRechercheType;

class PrestataireController extends Controller {

    /**
     * call by views/Public/Navigation/nav.parent.menu
     */
    public function getChildNavPrestatairesElementsAction() {

        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findAll();
        return $this->render('Public/Navigation/Children/nav.child.prestataires.elements.html.twig', array(
                    'prestataires' => $prestataires,
        ));
    }

    /**
     * @Route("/inscription/prestataires",name="signupPrestataire")
     */
    public function subscribeNewPrestataireAction(Request $request) {

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
     * @Route("/prestataires/details/prestataire/{prestataire_nom}",name="details_prestataire")
     */
    public function getPrestataireDetailsAction($prestataire_nom) {
        $prestataire = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findOneByNom($prestataire_nom);
        dump($prestataire);
        return $this->render('Public\Prestataires\display.details.prestataire.html.twig', array(
                    'prestataire' => $prestataire
        ));
    }

    /**
     * @Route("recherche/prestataire",options={"expose"=true},name="search_prestataire")
     */
    public function moteurDeRecherchePrestatairesAction() {

//        $prestataire = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->recherche($param);
//        dump($prestataire);
        $form = $this->get('form.factory')->create(MoteurDeRechercheType::class);

        return $this->render('Public\Navigation\Children\MoteurDeRecherche\form.moteur.de.recherche.prestataire.html.twig', array(
                    'form' => $form->createView(),
                        //  'prestataire' => $prestataire
        ));
    }

    /**
     * @Route("recherche/prestataire/resultat",options={"expose"=true},name="search_nom_prestataire")
     */
    public function moteurDeRecherchePrestatairesByNomAction(Request $request) {

        if ($request->getMethod() == 'POST') {

            $criteria = $request->request->all();
            //$nom=$request->request->get('recherche');
//            foreach ($nom as $k => $v) {
//                $nom = $v['recherche'];
//                $commune = $v['commune'];
//            }
        }
        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findMyPrestataire($criteria);
        dump($prestataires);


        return $this->render('Public\Prestataires\SearchPrestataire\resultat.recherche.prestataire.html.twig', array(
                    'prestataires' => $prestataires
        ));
    }

}

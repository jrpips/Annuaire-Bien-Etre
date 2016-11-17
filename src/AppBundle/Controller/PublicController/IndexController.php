<?php

namespace AppBundle\Controller\PublicController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{

    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {

        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findAll();//TODO : déterminer une limite

        /* Tri du tableau des Prestataires par comparaison avec les Favoris de l'Internaute */

        if ($this->isGranted('ROLE_INTERNAUTE')) {

            $favoris = $this->getUser()->getInternaute()->getFavoris();

            $j = count($prestataires);

                foreach ($favoris as $k => $v) {  // moteur de comparaison
                    $i = $j - count($prestataires); // adaptation de la clé en cas de retrait de la clé/valeur Prestataires en cours
                    foreach ($prestataires as $nom) {
                        if ($v == $nom) {
                            unset($prestataires[$i]);
                        } // si Pretataire = Favori -> retrait du Prestataire
                        $i++;
                    }
                }

        }
        return $this->render('Public/index.html.twig', array(
            'prestataires' => $prestataires,
        ));
    }

    /**
     * @Route("/about",name="about")
     */
    public function aboutAction()
    {
        return $this->render('Public/index.html.twig');
    }

    /**
     * @Route("/contact",name="contact")
     */
    public function contactAction()
    {

    }

}

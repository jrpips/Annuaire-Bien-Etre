<?php

namespace AppBundle\Controller\PublicController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ContactType;

class IndexController extends Controller
{

    /**
     * @Route("/", name="home")
     */
    public function indexAction(Request $request)
    {   //déconnection d'un User banni
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            if($this->getUser() !=null && $this->getUser()->getBanni()){
                //$this->get('app.addmsgflash')->addMsgFlash($request, 'success', 'Votre compte est désactiver! Veuillez contacter le webmestre du site.', true);
                return $this->redirectToRoute('logout');
            }
        }
        $services = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->myFindValideServices();

        return $this->render('Public/index.html.twig', array(
            'services' => $services,
        ));
    }

    /*************
     ** @Route("/", name="home")
     */
    public function _indexAction()
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
        return $this->render('Public/About/about.html.twig');
    }

    /**
     * @Route("/contact",name="contact")
     */
    public function contactAction(Request $request)
    {
        $form = $this->get('form.factory')->create(ContactType::class);

        $form->handleRequest($request); $values = $request->request->get('contact');
        dump($values);
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

               /* $values = $request->request->get('contact');
dump($values);*/
                $this->get('app.mailerbuilder')->mailConstruct($values,'contact','to','Demande infos B to C','wg.wargnier@gmail.com');

                return new JsonResponse(array(
                    'valide' => true,
                    'values' => $values,
                ));
            }
        }
        return $this->render('Public/Contact/display.contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

}

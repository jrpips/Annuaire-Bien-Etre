<?php
namespace AppBundle\Controller\PublicController\Abus;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Abus;
use AppBundle\Form\AbusType;

class AbusController extends Controller
{

    /**
     * @Route("/signaler/abus/{commentaire_id}/{prestataire_nom}",options={"expose"=true},name="signaler_abus")
     */
    public function constructFormAbusAction(Request $request,$commentaire_id,$prestataire_nom)
    {
        $abus = new abus();
        $commentaire=$this->getDoctrine()->getManager()->getRepository('AppBundle:Commentaire')->findOneById($commentaire_id);

        $form = $this->get('form.factory')->create(AbusType::class, $abus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $abus
                ->setDenonceur($this->getUser())
                ->setCommentDenonce($commentaire);

            $em->persist($abus);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Signalement envoyé.');

            return $this->redirectToRoute('details_prestataire', array('prestataire_nom'=>$prestataire_nom));
        }

        return $this->render('Public/Utilisateurs/Abus/form.add.abus.html.twig', array(
            'abus' => $abus,
            'form' => $form->createView()
        ));
    }
    /**
     * @Route("/admi/abus/supprimer{abus_id}",options={"expose"=true},name="delete_abus")
     */
    public function deleteAbusAction(Request $request,$abus_id){
        $abus=$this->getDoctrine()->getManager()->getRepository('AppBundle:Abus')->findById($abus_id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($abus[0]);
        $em->flush();

        return $this->redirectToRoute('dashboard',array('method'=>'gestionAbus'));
    }
}
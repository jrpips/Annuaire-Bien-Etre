<?php
namespace AppBundle\Controller\AdminController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Commentaire;
use AppBundle\Entity\Abus;

class AdminAnnuaireController extends Controller
{
    /**
     * @Route("/admin/gestion/abus",name="dashboard_abus")
     */
    public function gestionAbusAction()
    {
        $abus = $this->getDoctrine()->getManager()->getRepository('AppBundle:Abus')->findAll();
        dump($abus);
        return $this->render('Admin/GestionAbus/dashboard.abus.html.twig', array(
            'abus' => $abus
        ));
    }

    /**
     * @Route("/admin/gestion/compte/bannis",name="dashboard_banned_account")
     */
    public function gestionCompteBannisAction()
    {
        $users = $this->getDoctrine()->getManager()->getRepository('AppBundle:Utilisateur')->findBannedUsers();
        dump($users);
        return $this->render('Admin/GestionBannedAccount/dashboard.banned.account.html.twig', array(
            'users' => $users
        ));
    }


    /**
     * @Route("/admin/gestion/commentaires",name="dashboard_commentaires")
     */
    public function gestionCommentairesAction()
    {
        $commentaires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Commentaire')->getAllCommentaires();
        return $this->render('Admin/GestionCommentaires/dashboard.gestion.commmentaires.html.twig', array(
            'commentaires' => $commentaires
        ));
    }

    /**
     * @Route("/admin/debloquer/utilisateur/{user_id}",name="debloquer_account")
     */
    public function debloquerCompteUtilisateurAction($user_id)
    {
        $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:Utilisateur')->findOneById($user_id);
        $em = $this->getDoctrine()->getManager();
        $user->setBanni(false);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('dashboard_banned_account');
    }

    /**
     * @Route("/admin/abus/supprimer/{abus_id}",options={"expose"=true},name="delete_abus")
     */
    public function deleteAbusAction(Request $request, $abus_id)
    {
        $abus = $this->getDoctrine()->getManager()->getRepository('AppBundle:Abus')->findOneById($abus_id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($abus);
        $em->flush();

        return $this->redirectToRoute('dashboard_abus');
    }

    /**
     * @Route("/admin/supprimer/commentaire/{commentaire}/{abus}/{banni}",options={"expose"=true},name="delete_comment")
     */
    public function deleteCommentAction(Request $request,Commentaire $commentaire,Abus $abus=null, $banni = null)
    {
        //$commentaire = $this->getDoctrine()->getManager()->getRepository('AppBundle:Commentaire')->findOneByTitre($commentaire_titre);
        //$abus = $this->getDoctrine()->getManager()->getRepository('AppBundle:Abus')->findOneById($abus_id);
        if ($banni) {
            $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:Utilisateur')->findUtilisateur($banni);
        }

        $em = $this->getDoctrine()->getManager();

        if ($banni) {
            $user[0]->setBanni(true);
            $em->persist($user[0]);
        }
        if($abus){
        $em->remove($abus);
        $em->flush();}
        $em->remove($commentaire);
        $em->flush();

        return $this->redirectToRoute('dashboard_abus');
    }
}

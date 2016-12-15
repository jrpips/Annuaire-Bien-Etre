<?php
namespace AppBundle\Controller\AdminController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Commentaire;

class AdminAnnuaireController extends Controller
{
    /**
     * @Route("/admin",name="dashboard_accueil")
     */
    public function adminAction()
    {
        return $this->render('Admin/Accueil/dashboard.accueil.html.twig');
    }

    /**
     * Render : retourne le nombre d'Abus signalés --> navigation Dashboard
     */
    public function countAbusAction()
    {
        $countAbus = $this->getDoctrine()->getManager()->getRepository('AppBundle:Abus')->countAbus();
        return $this->render('Admin/AdminNavigation/link.count.abus.html.twig', array(
            'countAbus' => $countAbus,
        ));
    }

    /**
     * Render : retourne le nombre de Comptes bannis  --> navigation Dashboard
     */
    public function countBannedAccountAction()
    {
        $countBannedUsers = $this->getDoctrine()->getManager()->getRepository('AppBundle:Utilisateur')->countBannedUsers();
        return $this->render('Admin/AdminNavigation/link.banned.account.html.twig', array(
            'countBannedUsers' => $countBannedUsers,
        ));
    }

    /**
     * Render : retourne le nombre de Prestataires inscrits --> navigation Dashboard
     */
    public function countPrestatairesAction()
    {
        $countPrestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->countPrestataires();
        return $this->render('Admin/AdminNavigation/link.count.prestataires.html.twig', array(
            'countPrestataires' => $countPrestataires,
        ));
    }

    /**
     * Render : retourne le nombre de Internautes inscrits --> navigation Dashboard
     */
    public function countInternautesAction()
    {
        $countInternautes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Internaute')->countInternautes();
        return $this->render('Admin/AdminNavigation/link.count.internautes.html.twig', array(
            'countInternautes' => $countInternautes,
        ));
    }

    /**
     * Render : retourne le nombre de Commentaires  --> navigation Dashboard
     */
    public function countCommentairesAction()
    {
        $countCommentaires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Commentaire')->countCommentaires();
        return $this->render('Admin/AdminNavigation/link.count.commentaires.html.twig', array(
            'countCommentaires' => $countCommentaires,
        ));
    }

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
}

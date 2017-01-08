<?php


namespace AppBundle\Controller\AdminController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Commentaire;


class AdminDashboardController extends Controller
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
     * Render : retourne le nombre de demandes de création de Services --> navigation Dashboard
     */
    public function countServicesToBeValideAction()
    {
        $countServices = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->countServices();
        return $this->render('Admin/AdminNavigation/link.count.newServices.html.twig', array(
            'countServices' => $countServices,
        ));
    }
}
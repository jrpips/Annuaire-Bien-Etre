<?php
namespace AppBundle\Controller\AdminController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdminAnnuaireController extends Controller
{
    /**
     * @Route("/admin",name="dashboard")
     */
    public function adminAction()
    {
        $countAbus = $this->getDoctrine()->getManager()->getRepository('AppBundle:Abus')->countAbus();
        $countPrestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->countPrestataires();
        $countInternautes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Internaute')->countInternautes();
        $countBannedUsers = $this->getDoctrine()->getManager()->getRepository('AppBundle:Utilisateur')->countBannedUsers();
        return $this->render('Admin/dashboard.html.twig', array(
            'countAbus' => $countAbus,
            'countPrestataires' => $countPrestataires,
            'countInternautes' => $countInternautes,
            'countBannedUsers' => $countBannedUsers
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
}

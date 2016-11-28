<?php
namespace AppBundle\Controller\AdminController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdminAnnuaireController extends Controller
{
    /**
     * @Route("/admin/{method}",name="dashboard")
     */
    public function adminAction($method='a')
    {
        $countAbus = $this->getDoctrine()->getManager()->getRepository('AppBundle:Abus')->countAbus();
        $countPrestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->countPrestataires();
        $countInternautes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Internaute')->countInternautes();
        $countBannedUsers = $this->getDoctrine()->getManager()->getRepository('AppBundle:Utilisateur')->countBannedUsers();
        return $this->render('Admin/dashboard.html.twig', array(
            'countAbus' => $countAbus,
            'countPrestataires' => $countPrestataires,
            'countInternautes' => $countInternautes,
            'countBannedUsers' => $countBannedUsers,
            'method'=>$method
        ));
    }

    /**
     * render
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
     * render
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

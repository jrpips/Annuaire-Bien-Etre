<?php
namespace AppBundle\Controller\AdminController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Finder\Finder;

use AppBundle\Entity\Prestataire;
use AppBundle\Entity\Image;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Commentaire;
use AppBundle\Entity\Abus;

use AppBundle\Form\UtilisateurType;
use AppBundle\Form\PrestataireType;
use AppBundle\Form\InternauteType;

class AdminAnnuaireController extends Controller
{
    /**
     * @Route("/admin/gestion/abus",name="dashboard_abus")
     */
    public function gestionAbusAction()
    {
        $abus = $this->getDoctrine()->getManager()->getRepository('AppBundle:Abus')->findAll();

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

        $em->persist($user)->flush();

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
    public function deleteCommentAction(Request $request, Commentaire $commentaire, Abus $abus = null, $banni = null)
    {
        if ($banni) {


            $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:Utilisateur')->findUtilisateur($banni);

        }

        $em = $this->getDoctrine()->getManager();

        if ($banni) {


            $user[0]->setBanni(true);
            $em->persist($user[0]);

        }
        if ($abus) {


            $em->remove($abus);
            $em->flush();

        }

        $em->remove($commentaire);
        $em->flush();

        return $this->redirectToRoute('dashboard_abus');
    }

    /**
     * @Route("/admin/liste/{type}",name="ad_utilisateurs")
     */
    public function listePrestatairesAction($type)
    {
        if ($type == 'prestataire') {


            $utilisateurs = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findAll();

        } else {


            $utilisateurs = $this->getDoctrine()->getManager()->getRepository('AppBundle:Internaute')->findUtilisateurs();

        }

        return $this->render('Admin/GestionUtilisateurs/dashboard.gestion.utilisateurs.html.twig', array(
            'utilisateurs' => $utilisateurs,
            'type' => $type
        ));
    }

    /**
     * @Route("/admin/utilisateur/edition/{utilisateur}/{type}",name="ad_edit_utilisateur")
     */
    public function editPrestataireAction(Request $request, Utilisateur $utilisateur, $type)
    {
        if ($type == 'prestataire') {


            $form = $this->get('form.factory')->create(UtilisateurType::class, $utilisateur)->add('prestataire', PrestataireType::class);

        } else {


            $form = $this->get('form.factory')->create(UtilisateurType::class, $utilisateur)->add('internaute', InternauteType::class);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();

            $statut = 'success';
            $text = 'du ' . $type . ' ' . $utilisateur->getUsername();

            try {


                $em->flush();

            } catch (\Exception $e) {


                $statut = 'danger';

            }$this->get('app.addmsgflash')->addMsgFlash($request, $statut, $text);

            return $this->redirectToRoute('ad_utilisateurs', array('type' => $type));

        }
        return $this->render('Admin/GestionUtilisateurs/Links/edit.utilisateur.html.twig', array(
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
            'type' => $type
        ));
    }

    /**
     * @Route("/admin/utilisateur/bannir/{utilisateur}/{type}",name="ban_utilisateur")
     */
    public function banUtilisateurAction(Request $request, Utilisateur $utilisateur, $type)
    {
        $utilisateur->setBanni(true);

        $em = $this->getDoctrine()->getManager();

        $statut = 'success';
        $text = "L'utilisateur " . $utilisateur->getUsername() . " est à présent banni!";

        try {


            $em->flush();

        } catch (\Exception $e) {


            $statut = 'danger';
            $text = "Une erreur est survenue lors de l'action demandée!";

        }
        $this->get('app.addmsgflash')->addMsgFlash($request, $statut, $text, true);

        return $this->redirectToRoute('ad_utilisateurs', array('type' => $type));
    }

    /**
     * @Route("/admin/contacter/utilisateur/{utilisateur}",name="contact_user")
     */
    public function contactUserAction(Request $request, Utilisateur $utilisateur = null)
    {

        $values = $request->request->get('contact_user');
        $error = '';

        if ($request->getMethod() == 'POST') {


            if ($values['message']) {


                $values['contact']['email'] = $utilisateur->getEmail();

                $this->get('app.mailerbuilder')->mailConstruct($values, 'admin', 'from');

                $this->get('app.addmsgflash')->addMsgFlash($request, 'success', 'Message envoyé!', true);

                return $this->redirectToRoute('dashboard_accueil');

            } else {


                $error = "Votre message est vide!";
            }
        }

        return $this->render('Admin/GestionUtilisateurs/Links/contact.utilisateur.html.twig', array(
            'utilisateur' => $utilisateur,
            'error' => $error
        ));
    }

    /**
     * @Route("/admin/gestion/images",name="image_dashboard")
     */
    public function gestionImageAction()
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/../../../../web/image/userUploads');

        foreach ($finder as $file) {

            $files[] = '/image/userUploads/' . $file->getRelativePathname();
        }

        return $this->render('Admin/GestionImages/finder.html.twig', array(
            'finder' => $files,

        ));
    }

    /**
     * @Route("/admin/infos/image",options={"expose"=true},name="get_infos_img")
     */
    public function autoCompleteAjaxAction(Request $request) {
       if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest()) {


            $val = $request->request->get('path');
            $response = $this->getDoctrine()->getManager()->getRepository('AppBundle:Utilisateur')->findOwnerImage($val);//->findOneByPath($val);

            dump($response);

            return new JsonResponse($response);
        }
    }

}

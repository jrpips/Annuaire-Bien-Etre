<?php

namespace AppBundle\Controller\PublicController\Commentaires;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Prestataire;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Commentaire;
use AppBundle\Form\CommentaireType;
use AppBundle\Form\MoteurDeRechercheType;


class CommentaireController extends Controller
{
    /**
     * Call by views/Public/Navigation/nav.parent.menu
     */
    public function constructFormCommentaireAction()
    {
        $comment = new Commentaire();
        $form = $this->get('form.factory')->create(CommentaireType::class, $comment);
        return $this->render('Public/Prestataires/form.commentaire.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/internaute/commentaire/prestataire",options={"expose"=true},name="add_comment")
     */
    public function addCommentAction(Request $request)
    {

        if ($this->get('security.authorization_checker')->isGranted('ROLE_INTERNAUTE')) {// ne commente pas qui veut...

            $nomPrestataire = $request->get('prestataire_nom');
            $comment = new Commentaire();

            $form = $this->get('form.factory')->create(CommentaireType::class, $comment);

            $form->handleRequest($request);

            if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest()) {

                if (!$form->isValid()) {

                    $errors = $this->get('app.geterrormessages')->getErrorMessages($form);

                    return new JsonResponse(array(
                        'errors' => $errors,
                        'valide' => false,
                    ));
                }
                if ($form->isValid()) {

                    //$comment->setCote(3);

                    dump($request->request);
                    $em = $this->getDoctrine()->getManager();

                    $auteurComment = $em
                        ->getRepository('AppBundle:Internaute')
                        ->getPrestatairesFavoris($this->getUser()->getInternaute()->getId());// récupération de l'auteur du commentaire

                    $prestataireCommented = $em
                        ->getRepository('AppBundle:Prestataire')
                        ->findByNom($nomPrestataire);// récupération du sujet du commentaire

                    $comment
                        ->setInternaute($auteurComment[0])
                        ->setPrestataire($prestataireCommented[0]);// ajout de l'auteur (internaute) et du sujet (prestataire)

                    $prestataireCommented[0]->addCommentaire($comment);// injection du commentaire

                    $em = $this->getDoctrine()->getManager();
                    $em->flush();

                    return new JsonResponse(array(

                        'valide' => false,
                    ));
                }
            }
        }
        return $this->redirectToRoute('details_prestataire', array('prestataire_nom' => $nomPrestataire));
    }
}
<?php

/*
  src/AppBundle/Controller/Newsletters/NewsletterController.php

  NewsletterController
  ====================

  1.newsletterSubscribeAction   -> gestion inscription à la newsletter
  2.newsletterGeneratePdfAction -> génération d'un pdf contenant les infos de la newsletter
  3.newsletterUploadAction      -> téléchargement des newsletters
  4.newsletterUnscribeAction    -> désinscription

 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewslettersController extends Controller {

    /**
     * @Route("/newsletters/signup/{id_internaute}", name="newslettersSignUp")
     */
    public function newsletterSubscribeAction(Request $request, $id_internaute) {

        return false;
    }

    /**
     * @Route("/newsletters/generatePdf/{content_newsletter}", name="newslettersGeneratePdf")
     */
    public function newsletterGeneratePdfAction($content_newsletter) {

        return false;
    }

    /**
     * @Route("/newsletters/upload/{id_newsletter}", name="newslettersUpload")
     */
    public function newsletterUploadAction(Request $request, $id_newsletter) {

        return false;
    }

    /**
     * @Route("/newsletters/unsubscribe/{id_internaute}", name="newslettersUnsubscribe")
     */
    public function newsletterUnscribeAction(Request $request, $id_internaute) {

        return false;
    }

}

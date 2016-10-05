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

class NewsletterController extends Controller {

    /**
     * @Route("/newsletter/subscribe/{id_internaute}", name="newsletterSubscribe")
     */
    public function newsletterSubscribeAction(Request $request, $id_internaute) {

        return $this;
    }

    /**
     * @Route("/newsletter/generatePdf/{content}", name="newsletterGeneratePdf")
     */
    public function newsletterGeneratePdfAction($content) {

        return $this;
    }

    /**
     * @Route("/newsletter/upload/{id}", name="newsletterUpload")
     */
    public function newsletterUploadAction(Request $request, $id) {

        return $this;
    }

    /**
     * @Route("/newsletter/unscribe/{id_internaute}", name="newsletterUnscribe")
     */
    public function newsletterUnscribeAction(Request $request, $id_internaute) {

        return $this;
    }

}

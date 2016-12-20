<?php
/*
  src/AppBundle/Controller/PublicController/Newsletters/NewsletterController.php

  NewsletterController
  ====================

  1.newsletterSubscribeAction   -> gestion inscription à la newsletter
  2.newsletterGeneratePdfAction -> génération d'un pdf contenant les infos de la newsletter
  3.newsletterUploadAction      -> téléchargement des newsletters
  4.newsletterUnscribeAction    -> désinscription

 */

namespace AppBundle\Controller\PublicController\Newsletters;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Newsletter;
use Symfony\Component\HttpFoundation\Response;
use Knp\Snappy\Pdf;

class NewslettersController extends Controller
{

    /**
     * @Route("/pdf", name="pdf")
     */
    public function newsletterSubscribeAction(Request $request, $id_internaute)
    {
        //$this->get('knp_snappy.pdf')->generate('http://127.0.0.1/Annuaire-Bien-Etre/web/app_dev.php/',__DIR__. '/pdf/file.pdf');
        // return $this->redirectToRoute('home');
        /*$pageUrl = $this->generateUrl('home', array(), true); // use absolute path!

        return new Response(
            $this->get('knp_snappy.pdf')->getOutput($pageUrl),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );*/
        $snappy = new Pdf('C:\"Program Files"\EasyPHP-Devserver-16.1\eds-www\Annuaire-Bien-Etre\vendor\wemersonjanuario\wkhtmltopdf-windows\bin\32bit\wkhtmltopdf.exe');

        /*   header('Content-Type: application/pdf');
           header('Content-Disposition: attachment; filename="file2.pdf"');
           $snappy->getOutput('https://www.github.com');*/
        $snappy->generateFromHtml('<a style="color:red" href="https://www.google.com">Bill</a>', 'C:\Users\Chris\Desktop\bill-12oo345.pdf');
        return new Response('ok');
    }

    /**
     * @Route("/generatePdf", name="newslettersGeneratePdf")
     */
    public function newsletterGeneratePdfAction($content_newsletter)
    {


        //$this->get('knp_snappy.pdf')->generate('http://127.0.0.1/Annuaire-Bien-Etre/web/app_dev.php/', 'C:\Users\Chris\Desktop\file4.pdf');
        //return new Response('ok');
        $html = $this->renderView('pdf.html.twig');
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="dossiercandidat.pdf"'
            )
        );
        // $pageUrl = $this->generateUrl('home', array(), true); // use absolute path!
           // $this->get('knp_snappy.pdf')->getOutput($pageUrl),
           // 200,
           // array(
          //      'Content-Type' => 'application/pdf',
         //       'Content-Disposition' => 'attachment; filename="file.pdf"'
          //  )
       // );
    }
}
//
//    /**
//     * @Route("/newsletters/upload/{id_newsletter}", name="newslettersUpload")
//     */
//    public function newsletterUploadAction(Request $request, $id_newsletter) {
//
//        return false;
//    }
//
//    /**
//     * @Route("/newsletters/unsubscribe/{id_internaute}", name="newslettersUnsubscribe")
//     */
//    public function newsletterUnscribeAction(Request $request, $id_internaute) {
//
//        return false;
//    }
//
//}

<?php

namespace AppBundle\Services\MailerBuilder;

class MailerBuilder
{

    protected $twig;
    protected $mailer;

    public function __construct(\Twig_Environment $twig, \Swift_Mailer $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    /**
     *  $values:            the content  (type object of array)
     *
     *  $type:              tag to render format template ['signup','service'
     *
     *  $direction:         1.'from'
     *                      2.'to'
     *
     *  $subject            title
     */
//TODO: soumettre les arguments via un array() associatif
    public function mailConstruct($values = null, $type = null, $direction = null, $subject = 'Contact from Bien-Etre', $mailExpediteur = null, $mailDestinataire = null)
    {
        $body = $this->renderTemplate($values, $type);

        $message = \Swift_Message::newInstance()
            ->setSubject($subject);

        if ($direction == 'from') {//from admin to users


            $message
                ->setFrom(array('bien.etre@gmail.com' => 'Annuaire Bien-Etre'))
                ->setTo((gettype($values) == 'object') ? $values->getEmail() : $values['contact']['email']);

        } else {//from users to admin of providers


            $expediteur = ($mailExpediteur) ? $mailExpediteur : (gettype($values) == 'object') ? $values->getEmail() : $values['contact']['email'];
            $destinataire = ($mailDestinataire) ? $mailDestinataire : 'bien.etre@gmail.com';

            $message
                ->setFrom(array($expediteur => 'Demande d informations'))
                ->setTo($destinataire);
        }


        $message->setCharset('utf-8')
            ->setContentType('text/html')
            ->setBody($body);

        $this->mailer->send($message);
    }

    public function renderTemplate($values, $type)
    {
        return $this->twig->render('System/SwiftMailer/mail.html.twig', array(
            'values' => $values,
            'type' => $type
        ));
    }
}

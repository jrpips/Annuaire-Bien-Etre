<?php

namespace AppBundle\Services\MailerBuilder;

class MailerBuilder {

    protected $twig;
    protected $mailer;

    public function __construct(\Twig_Environment $twig, \Swift_Mailer $mailer) {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public function mailer($newUser) {
        $body = $this->renderTemplate($newUser);

        $message = \Swift_Message::newInstance()
                ->setSubject('Validation de votre inscription')
                ->setFrom(array('cw.bocaboca@gmail.com' => 'Annuaire Bien-Etre'))
                ->setTo($newUser->getEmail())
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody($body);

        $this->mailer->send($message);
    }

    public function renderTemplate($newUser) {
        return $this->twig->render('SwiftMailer/mail.html.twig', array('user' => $newUser));
    }

}

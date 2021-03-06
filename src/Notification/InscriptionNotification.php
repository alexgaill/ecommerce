<?php

namespace App\Notification;

use App\Entity\User;
use Twig\Environment;

class InscriptionNotification
{
    private $mailer;
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }
    /**
     * Undocumented function
     *
     * @param User $user
     * @return void
     */
    public function notify(User $user)
    {
            $message = new \Swift_Message('Validation de votre inscription sur YCS');
            $message->setFrom('no-reply@ycs.fr', 'YCS')
            ->setTo($user->getEmail())
            ->setBody($this->renderer->render('emails/inscription.html.twig',[
                'user' => $user
                ]), 'text/html');
            $this->mailer->send($message);
    }
}

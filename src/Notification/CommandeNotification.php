<?php

namespace App\Notification;

use App\Entity\Commande;
use Twig\Environment;

class CommandeNotification
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
    public function notify(Commande $commande)
    {
        $message = new \Swift_Message('Votre commande n°: ' . $commande->getId());
        $message->setFrom('contact@steptosuccess.fr', 'YCS')
                ->setTo($commande->getUserId()->getEmail())
                ->setBody($this->renderer->render('emails/commande.html.twig',[
                    'commande' => $commande
                ]), 'text/html');
        $this->mailer->send($message);
    }
}

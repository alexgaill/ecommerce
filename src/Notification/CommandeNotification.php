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
     * @param Commande $commande
     * @param LigneCommande[] $lignes
     * @return void
     */
    public function notify(Commande $commande, $lignes)
    {
        $message = new \Swift_Message('Votre commande n°: ' . $commande->getId());
        $message->setFrom('no-reply@ycs.fr', 'YCS')
                ->setTo($commande->getUserId()->getEmail())
                ->setBody($this->renderer->render('emails/commande.html.twig',[
                    'commande' => $commande,
                    'lignes' => $lignes
                ]), 'text/html');
        $this->mailer->send($message);
    }
}

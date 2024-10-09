<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationAlertePrix extends Notification
{
    use Queueable;
    private $alertes;

    /**
     * Create a new notification instance.
     */
    public function __construct($alertes)
    {
        $this->alertes = $alertes;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        
        $mailMessage = (new MailMessage)
            ->subject('Alertes de prix : variation détecté sur un ou plusieurs produits')
            ->greeting('Bonjour,')
            ->salutation("L'équipe Concurrence H-BP");

        foreach($this->alertes as $alerte){
            $mailMessage->line('Produit : ' . $alerte['produit'])
                        ->line('> ' . $alerte['texte'])
                        ->line('PVP : ' . $alerte['pvp'] . '€')
                        ->line('Prix Minimum de vente: ' . $alerte['prix-minimum'] . '€')
                        ->line('**Prix Concurrent: '. $alerte['prix'] . '€**')
                        ->line('Voir le produit: [Lien vers le produit](' . $alerte['lien'] . ')')
                        ->line("----");
        }
        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

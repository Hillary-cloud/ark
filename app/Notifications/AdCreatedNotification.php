<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdCreatedNotification extends Notification
{
    use Queueable;

    protected $ad;

    /**
     * Create a new notification instance.
     *
     * @param mixed $ad The ad that was created
     */
    public function __construct($ad)
    {
        $this->ad = $ad;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Your advert has been listed: ' . $this->ad->uuid,
            'ad_uuid' => $this->ad->uuid,
        ];
    }
}

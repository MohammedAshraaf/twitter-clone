<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TwitterNotification extends Notification
{
    use Queueable;
	/**
	 * @var
	 */
	private $notification;

	/**
	 * Create a new notification instance.
	 *
	 * @param $notification
	 */
    public function __construct($notification)
    {
        //
	    $this->notification = $notification;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notification)
    {
    	return [
    		'notification' => $this->notification,
	    ];
    }


	public function toBroadcast($notifiable)
	{
		return new BroadcastMessage([
			'notification' => $this->notificatio
		]);
	}

	/**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

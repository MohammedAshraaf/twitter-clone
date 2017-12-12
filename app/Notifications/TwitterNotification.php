<?php

namespace App\Notifications;

use App\Events\NotificationSaved;
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
	public $notification;

	/**
	 * Create a new notification instance.
	 *
	 * @param $notification
	 */
    public function __construct($notification)
    {
        //
	    $this->notification = $notification;
	    event(new NotificationSaved());
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
			'notification' => $this->notification
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

<?php


namespace App\Events;


use App\Mention;
use App\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationSaved implements ShouldBroadcast
{

	use Dispatchable, InteractsWithSockets, SerializesModels;



	public function broadcastOn() {
		return new Channel('notificationChannel');
	}
}
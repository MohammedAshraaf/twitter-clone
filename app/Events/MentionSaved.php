<?php


namespace App\Events;


use App\Mention;
use App\Notification;
use App\Repositories\User\UserInterface;

class MentionSaved
{
	/**
	 * Creates Notification when user mentions other
	 * @param Mention $mention
	 * @param UserInterface $userRepo
	 */
	public function saved(Mention $mention, UserInterface $userRepo)
	{
		$user = $userRepo->searchUser(['id' => $mention->mention_id]);

		$notification = new Notification();
		$notification->notification = $user->username . ' has mentioned you in his tweet';
		$notification->user_id = $mention->user_id;
		$notification->save();

	}
}
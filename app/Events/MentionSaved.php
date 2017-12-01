<?php


namespace App\Events;


use App\Mention;
use App\Notifications\TwitterNotification;


class MentionSaved
{
	/**
	 * Creates Notification when user mentions other
	 * @param Mention $mention
	 */
	public function saved(Mention $mention)
	{
		$userRepo = app()->make('App\Repositories\User\UserInterface');
		$user = $userRepo->searchUser(['id' => $mention->mention_id]);
		$userToNotify = $userRepo->searchUser(['id' => $mention->user_id]);

		$userToNotify->notify(new TwitterNotification($user->username . ' has mentioned you in his tweet'));

	}
}
<?php


namespace App\Events;


use App\Like;
use App\Notifications\TwitterNotification;


class LikeSaved
{
	/**
	 * Creates Notification when user mentions other
	 *
	 * @param Like $like
	 *

	 */
	public function saved(Like $like)
	{

		$userRepo = app()->make('App\Repositories\User\UserInterface');
		$tweetRepo = app()->make('App\Repositories\Tweet\TweetInterface');

		$userToNotify = $tweetRepo->getTweet($like->tweet_id)->user;

		$user = $userRepo->searchUser(['id' => $like->user_id]);

		if($userToNotify->id == $user->id)
			return;

		$userToNotify->notify(new TwitterNotification($user->username . ' has Liked your tweet'));


	}
}
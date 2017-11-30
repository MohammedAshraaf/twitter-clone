<?php


namespace App\Services;

use App\Repositories\Mention\MentionInterface;


class MentionService
{

	private $mentionRepo;

	public function __construct(MentionInterface $mention)
	{

		$this->mentionRepo = $mention;
	}


	/**
	 * Gets Mentions to be displayed in activity feed
	 * @param $user
	 * @param $usersIFollow
	 * @param UserService $userService
	 *
	 * @return mixed
	 */
	public function getMentionsForFeeds($user, $usersIFollow, UserService $userService)
	{

		return $this->mentionRepo->mentionForActivityFeeds($userService->extractIds($usersIFollow->toArray()), $user->id);
	}

}

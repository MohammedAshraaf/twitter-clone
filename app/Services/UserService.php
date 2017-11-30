<?php

namespace App\Services;

use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserService
{
	private $userRepository;

	public function __construct(UserInterface $user)
	{
		$this->userRepository = $user;
	}


	/**
	 * handles the following functionality
	 * @param $user
	 */
	public function followingHandler($user)
	{
		// if the user has already followed
		if($this->userRepository->currentUserFollows($user))
		{
			// un follow
			$this->userRepository->unFollow($user);
			return;
		}
		// follow
		$this->userRepository->follow($user);
	}


	/**
	 * extracts ids from users models
	 * @param $users
	 *
	 * @return array
	 */
	public function extractIds($users)
	{
		return array_map(function($user){
			return $user['id'];
		}, $users);
	}


	/**
	 * Counts likes for each tweet made by the given users
	 * @param $users
	 * @param TweetService $tweetService
	 *
	 * @return array
	 */
	public function countTweetsLikes($users, TweetService $tweetService)
	{
		$likes = [];
		foreach ($users as $user)
		{
			$likes = $likes + $tweetService->countTweetsLikes($user->tweets, app()->make('App\Services\LikeService'));
		}
		return $likes;
	}


	/**
	 * Handles news Feed and Activity Feed Query
	 * @param $user
	 * @param bool $push
	 *
	 * @return mixed
	 */
	public function handlesFeedQuery($user, $push = false)
	{
		$usersIds = $this->extractIds($user->following()->get()->toArray());

		if($push)
			array_push($usersIds, $user->id);

		// get the followers with their tweets
		return $this->userRepository->feedQuery($usersIds);
	}



	public function generatePassword($length = 10)
	{
		$password = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
		$codeAlphabet.= "0123456789";
		$max = strlen($codeAlphabet);

		for ($i=0; $i < $length; $i++) {
			$password .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
		}

		return $password;
	}

	private function crypto_rand_secure($min, $max)
	{
		$range = $max - $min;
		if ($range < 1) return $min; // not so random...
		$log = ceil(log($range, 2));
		$bytes = (int) ($log / 8) + 1; // length in bytes
		$bits = (int) $log + 1; // length in bits
		$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
		do {
			$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
			$rnd = $rnd & $filter; // discard irrelevant bits
		} while ($rnd > $range);
		return $min + $rnd;
	}


}
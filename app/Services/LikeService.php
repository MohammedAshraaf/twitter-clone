<?php


namespace App\Services;


use App\Repositories\Like\LikeInterface;
use Illuminate\Support\Facades\Auth;


class LikeService
{
	private $likeRepo;

	private $tweetService;

	/**
	 * LikeService constructor.
	 *
	 * @param LikeInterface $like
	 * @param TweetService $tweetService
	 */
	public function __construct(LikeInterface $like, TweetService $tweetService)
	{
		$this->likeRepo = $like;
		$this->tweetService = $tweetService;
 	}


	/**
	 * handles like functionality
	 *
	 * @param $tweet
	 *
	 * @param $userId
	 *
	 * @return array|bool|\Illuminate\Contracts\Translation\Translator|null|string
	 */
	public function likeHandler($tweet, $userId)
	{
		// check if the tweet exists
		$tweet = $this->tweetService->getTweetOrFail($tweet);

		// check if user has already liked the tweet
		$like = $this->likeRepo->getLike($userId, $tweet->id);

		// like exists, then fire unlike action
		if($like)
		{
			$this->likeRepo->unlike($like->id);
			return true;
		}

		// new like
		if(! $this->likeRepo->store(['user_id' => $userId, 'tweet_id' => $tweet->id]))
		{
			return trans('likes.errorSavingLike');
		}

		return true;
	}


	/**
	 * returns whether the user liked the tweet or not
	 * @param $tweet
	 *
	 * @return int
	 */
	public function userLikes($tweet)
	{
		// if user liked then it will be 1, otherwise 0
		return count(array_filter($tweet->likes->toArray(),function($i){
			return $i['user_id'] == Auth::user()->id;
		}));
	}

	/**
	 * Gets Likes to be displayed in activity feed
	 * @param $user
	 * @param $usersIFollow
	 * @param TweetService $tweetService
	 *
	 * @return mixed
	 */
	public function getLikesForFeeds($user, $usersIFollow, TweetService $tweetService )
	{

		return $this->likeRepo
			->likesForActivityFeeds($tweetService->extractTweetsIds($user->tweets()->get()->toArray()), $usersIFollow);
	}


	public function countLikes($tweet)
	{
		return count($tweet->likes);
	}


}

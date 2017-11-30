<?php


namespace App\Services;


use App\Repositories\Tweet\TweetInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TweetService
{
	private $tweetRepo;

	/**
	 * TweetService constructor.
	 *
	 * @param TweetInterface $tweet
	 */
	public function __construct(TweetInterface $tweet)
	{
		$this->tweetRepo = $tweet;
	}


	/**
	 * handles deleting tweets
	 * @param $id
	 *
	 * @return bool
	 */
	public function deleteTweet($id)
	{
		$tweet = $this->tweetRepo->getTweet($id, ['user_id' => Auth::user()->id]);
		if(!$tweet)
		{
			return false;
		}
		$tweet->delete();
		return true;
	}


	/**
	 * validates Tweets creation
	 * @param $data
	 *
	 * @return bool
	 */
	public function validateTweet($data, $id)
	{
		// create the rules
		$rules = [
			'tweet' => 'required|string|max:255',
			'mention' => 'not_in:' . $id . '|exists:users,id'
		];

		// validate
		$validation = Validator::make($data, $rules);

		// return the error
		if ($validation->fails())
		{
			return $validation->errors();
		}
		return true;
	}


	/**
	 * checks if tweet exists or fails
	 * @param $tweet
	 *
	 * @return mixed
	 */
	public function getTweetOrFail($tweet)
	{
		// check if the tweet exists
		$tweet = $this->tweetRepo->getTweet($tweet);
		if(!$tweet)
		{
			abort(404);
		}
		return $tweet;
	}

	/**
	 * Categorises the tweets based on whether current user like it
	 * @param $tweets
	 * @param LikeService $likeService
	 *
	 * @return array
	 */
	public function getCurrentUserLikes(&$tweets, LikeService $likeService)
	{
		$likes = array();


		foreach ($tweets as $tweet)
		{
			$likes[$tweet->id] = $likeService->userLikes($tweet);
		}
		return $likes;
	}


	/**
	 * Handles categorising the tweets for different users
	 * @param $users
	 *
	 * @return array
	 */
	public function categoriseLikes(&$users)
	{

		// if it's only one user
		if($this->isSingleUser($users))
		{

			return $this->getCurrentUserLikes($users->tweets, app()->make('App\Services\LikeService'));
		}

		$likes = array();
		// More than one user
		foreach ($users as $user)
		{
			// merge the arrays
			$likes = $likes + $this->getCurrentUserLikes($user->tweets, app()->make('App\Services\LikeService'));
		}
		return $likes;
	}


	/**
	 * Handles extracting tweets id for users
	 * @param $users
	 *
	 * @return array
	 */
	public function getTweetsIds(&$users)
	{
		$ids = [];
		foreach ($users as $user)
		{
			$ids = array_merge($ids,$this->extractTweetsIds($user->tweets));
		}
		return $ids;
	}

	/**
	 * Extracts Tweets id
	 * @param $tweets
	 *
	 * @return array
	 */
	public function extractTweetsIds($tweets)
	{
		return array_map(function($tweet){
			return $tweet['id'];
		}, $tweets);
	}


	/**
	 * Counts Likes for each tweet
	 * @param $tweets
	 * @param LikeService $likeService
	 *
	 * @return array
	 */
	public function countTweetsLikes($tweets, LikeService $likeService)
	{
		$likes = [];
		foreach ($tweets as $tweet)
		{
			$likes[$tweet->id] = $likeService->countLikes($tweet);
		}
		return $likes;
	}


	/**
	 * Checks if it's a single user
	 * @param $users
	 *
	 * @return bool
	 */
	public function isSingleUser($users)
	{
		return count($users) == 1 && !($users instanceof Collection) && !($users instanceof Paginator);
	}
}

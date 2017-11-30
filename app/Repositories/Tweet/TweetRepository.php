<?php

namespace App\Repositories\Tweet;

use App\Mention;
use App\Tweet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TweetRepository implements TweetInterface
{
	private $tweet;

	/**
	 * UserRepository constructor.
	 *
	 * @param Model $model
	 */
	public function __construct(Model $model)
	{
			$this->tweet = $model;
	}

	/**
	 * Stores Tweet
	 * @param $tweet
	 *
	 * @return mixed
	 */
	public function store($tweet)
	{
		return $this->tweet->create($tweet);
	}


	/**
	 * Gets Tweets
	 * @param $id
	 * @param array $options
	 *
	 * @return mixed
	 */
	public function getTweet($id, $options = [])
	{
		foreach ($options as $option => $value)
		{

			$this->tweet = $this->tweet->where($option, $value);
		}
		return $this->tweet->find($id);
	}

	/**
	 * Counts likes on this tweet
	 *
	 * @param $tweet
	 *
	 * @return mixed
	 */
	public function countLikes($tweet)
	{
		return $this->tweet->find($tweet)->likes()->count();
	}


}
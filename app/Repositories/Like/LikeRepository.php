<?php

namespace App\Repositories\Like;

use App\Tweet;
use Illuminate\Database\Eloquent\Model;

class LikeRepository implements LikeInterface
{
	private $like;

	/**
	 * UserRepository constructor.
	 *
	 * @param Model $model
	 */
	public function __construct(Model $model)
	{
			$this->like = $model;
	}

	/**
	 * Stores Tweet
	 *
	 * @param $like
	 *
	 * @return mixed
	 *
	 */
	public function store($like)
	{
		return $this->like->create($like);
	}

	/**
	 * Gets specific like
	 * @param $userId
	 * @param $tweetId
	 *
	 * @return mixed
	 */
	public function getLike($userId, $tweetId)
	{
		return $this->like->where('user_id', $userId)->where('tweet_id', $tweetId)->first();
	}


	/**
	 * unlike a tweet
	 * @param $like
	 */
	public function unlike($like)
	{
		$this->like->where('id', $like)->delete();
	}


	public function likesForActivityFeeds($tweetsIds, $usersIds, $pagination = 10)
	{
		return $this->like
			->whereIn('tweet_id', $tweetsIds)
			->whereIn('user_id', $usersIds)
			->with('user')
			->orderBy('created_at', 'DESC')
			->simplePaginate($pagination, ['*'],'likes');
	}





}
<?php

namespace App\Repositories\Mention;

use Illuminate\Database\Eloquent\Model;

class MentionRepository implements MentionInterface
{
	private $mention;

	/**
	 * UserRepository constructor.
	 *
	 * @param Model $model
	 */
	public function __construct(Model $model)
	{
			$this->mention = $model;
	}


	/**
	 * Stores New Mention
	 * @param $tweetId
	 * @param $userId
	 * @param $mention
	 */
	public function storeMention($tweetId, $userId, $mention)
	{
		$this->mention->create(['user_id' => $userId, 'mention_id' => $mention, 'tweet_id' => $tweetId] );
	}


	/**
	 * Queries Mentions for Activity feeds
	 *
	 * @param $mentionIds
	 * @param $userId
	 *
	 * @param int $pagination
	 *
	 * @return mixed
	 */
	public function mentionForActivityFeeds($mentionIds, $userId, $pagination = 10)
	{
		return $this->mention
			->whereIn('mention_id', $mentionIds)
			->where('user_id', $userId)
			->with('mention')
			->orderBy('created_at', 'DESC')
			->simplePaginate($pagination, ['*'],'mentions');
	}





}
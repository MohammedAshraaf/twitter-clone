<?php

namespace App\Repositories\User;

use App\Follower;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserInterface
{
	private $user;

	private $original;

	/**
	 * UserRepository constructor.
	 *
	 * @param Model $model
	 */
	public function __construct(Model $model)
	{
			$this->user = $model;
			$this->original = $model;
	}


	/**
	 * stores new user
	 * @param $data
	 *
	 * @return mixed
	 */
	public function storeUser($data)
	{
		$this->updateModel();
		return $this->user->create([
			'username' => $data['username'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'facebook_token' => isset($data['facebook_token']) ? $data['facebook_token'] : null
		]);
	}


	/**
	 * Searches for Users by username
	 *
	 * @param $user
	 * @param bool $usePaginate
	 * @param int $paginate
	 *
	 * @return mixed
	 */
	public function searchUsername($user, $usePaginate = true, $paginate = 15)
	{
		$this->updateModel();
		$user = $this->user->where('username', 'LIKE', "$user%")->where('id', '!=', Auth::id());

		// queries pagination
		if($usePaginate)
		{
			return $user->simplePaginate($paginate);
		}

		// single search
		return $user->first();

	}

	/**
	 * Check if current user follows another user
	 * @param $user
	 *
	 * @return mixed
	 */
	public function currentUserFollows($user)
	{

		return Follower::where('user_id', $user)->where('follower_id' , Auth::user()->id)->exists();
	}


	/**
	 * un follow users
	 * @param $user | user to be un followed
	 */
	public function unFollow($user)
	{
		Follower::where('user_id', $user)->where('follower_id' , Auth::user()->id)->delete();
	}

	/**
	 * follow user
	 * @param $user | user to be followed
	 */
	public function follow($user)
	{
		Follower::create( ['user_id' => $user, 'follower_id' => Auth::user()->id] );
	}


	/**
	 * Queries the displayed data for news feed sorted by tweets creation time
	 *
	 * @param $usersIds
	 *
	 * @param int $pagination
	 *
	 * @return mixed
	 */
	public function feedQuery($usersIds, $pagination = 20)
	{
		$this->updateModel();
		return $this->user->join('tweets', 'tweets.user_id', 'users.id')
		    ->orderBy('tweets.created_at', 'DESC')
		    ->whereIn('users.id', $usersIds)
		    ->select('users.username', 'users.id', 'tweets.tweet', 'tweets.id as tweet_id', 'tweets.created_at')
		    ->with('tweets.likes')
		    ->simplePaginate($pagination, ['*'], 'tweets');
	}


	/**
	 * Last Registered User with the username in alpha order
	 * @param $username
	 */
	public function lastUserName($username)
	{
		$this->updateModel();
		return $this->user->where('username', 'LIKE', "$username%")->orderBy('username', 'DESC')->first();
	}


	/**
	 * Searches in general
	 * @param $options
	 * @param bool $single
	 *
	 * @return mixed
	 */
	public function searchUser($options, $single = true)
	{
		$this->updateModel();
		foreach ($options as $key => $value)
		{
			$this->user = $this->user->where($key, $value);
		}
		if($single)
			return $this->user->first();
		return $this->user->get();
	}


	/**
	 * Updates the model for new queries
	 */
	public function updateModel()
	{
		$this->user = $this->original;
	}
}
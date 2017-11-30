<?php

namespace App\Http\Controllers;


use App\Repositories\User\UserInterface;
use App\Services\LikeService;
use App\Services\MentionService;
use App\Services\TweetService;
use App\Services\UserService;
use App\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FeedController extends Controller
{

	/**
	 * @var UserService
	 */
	private $userService;

	public function __construct(UserService $userService)
	{
		$this->userService = $userService;
	}


	/**
	 * Shows the news feed.
	 *
	 * @param TweetService $tweetService
	 *
	 * @param UserInterface $userRepo
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function newsFeed(TweetService $tweetService, UserInterface $userRepo)
	{

		// get the followers with their tweets
		$followers = $this->userService->handlesFeedQuery(Auth::user(), true);

		// count likes for each tweet
		$likesCounter = $this->userService->countTweetsLikes($followers, $tweetService);

		// booleans whether the current user likes the tweet or not
		$likes = $tweetService->categoriseLikes($followers);



		return view('feeds.news', compact('followers', 'likes', 'likesCounter'));
	}


	/**
	 * Shows activity feed
	 *
	 * @param MentionService $mentionService
	 * @param LikeService $likeService
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function activityFeed(MentionService $mentionService, LikeService $likeService)
	{


		$user = Auth::user();

		$usersIFollow = $user->following()->get();

		$followers = $this->userService->handlesFeedQuery($user);

		$mentions = $mentionService->getMentionsForFeeds($user, $usersIFollow, app()->make('App\Services\UserService'));

		$likes = $likeService->getLikesForFeeds($user, $usersIFollow, app()->make('App\Services\TweetService'));

		return view('feeds.activity', compact('usersIFollow', 'mentions', 'likes', 'followers'));
	}
}

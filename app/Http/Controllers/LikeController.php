<?php

namespace App\Http\Controllers;

use App\Repositories\Like\LikeInterface;
use App\Services\LikeService;
use App\Services\TweetService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LikeController extends Controller
{

	private $likeRepo;

	private $tweetService;

	private $likeService;


	public function __construct(TweetService $tweetService, LikeInterface $likeRepo, LikeService $likeService)
	{
		$this->likeRepo = $likeRepo;
		$this->tweetService = $tweetService;
		$this->likeService = $likeService;
	}

	/**
	 * Likes or Unlikes tweets
	 * @param $tweet
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function like($tweet)
    {
    	$message = $this->likeService->likeHandler($tweet, Auth::id());
		if($message !== true)
			Session::flash('alert', $message);

	    return redirect()->back();
    }

}

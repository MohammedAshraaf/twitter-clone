<?php

namespace App\Http\Controllers;

use App\Repositories\Mention\MentionInterface;
use App\Repositories\Tweet\TweetInterface;
use App\Services\LikeService;
use App\Services\TweetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TweetController extends Controller
{

	/**
	 * @var TweetInterface
	 */
	private $tweetRepo;
	/**
	 * @var TweetService
	 */
	private $tweetService;


	public function __construct(TweetInterface $tweetRepo, TweetService $tweetService)
	{
		$this->tweetRepo = $tweetRepo;
		$this->tweetService = $tweetService;
	}


	/**
	 * Store a newly created tweet.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @param MentionInterface $mentionRepo
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function store(Request $request, MentionInterface $mentionRepo)
    {
    	$validate = $this->tweetService->validateTweet($request->all(), Auth::id());

    	// Validation Failed!
    	if($validate !== true)
	    {
		    return redirect()->back()->withErrors($validate);
	    }

    	// store new tweet
		$tweet = $this->tweetRepo->store(['tweet' => $request->tweet, 'user_id' => Auth::user()->id]);

		// Failed!
		if(!$tweet)
		{
			Session::flash('alert', trans('tweet.errorSavingNewTweet'));
		}

		// Store new Mention
		if($request->filled('mention'))
		{
			$mentionRepo->storeMention($tweet->id, $request->mention, Auth::id());
		}
		return redirect()->route('user.profile');
    }

	/**
	 * Display the specified tweet.
	 *
	 * @param  int $id
	 * @param LikeService $likeService
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function show($id, LikeService $likeService)
    {
        $tweet = $this->tweetService->getTweetOrFail($id);

        $like = $likeService->userLikes($tweet);

        $user = $tweet->user;

        return view('tweets.view', compact('tweet', 'like', 'user'));
    }


	/**
	 * Remove the specified tweet.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 *
	 */
    public function destroy($id)
    {
    	// user is trying to delete a tweet that he doesn't have!
		if(!$this->tweetService->deleteTweet($id))
		{
			abort(403);
		}
		return redirect()->route('user.profile');
    }
}

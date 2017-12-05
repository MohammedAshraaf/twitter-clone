<?php

namespace App\Http\Controllers;

use App\Repositories\User\UserInterface;
use App\Services\LikeService;
use App\Services\TweetService;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	private $userRepo;

    public function __construct(UserInterface $userRepo)
    {
    	$this->userRepo = $userRepo;
    }

	/**
	 * handles searching request
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @internal param UserInterface $userRepo
	 *
	 */
    public function searchForUser(Request $request)
    {
		$users = $this->userRepo->searchUsername($request->username);

		return view('users.search', compact('users'));
    }

    public function searchAjax(Request $request)
    {
    	$results = $this->userRepo->searchUsername($request->q);
		return ['results' => $results->items(), 'pagination' => $results->hasMorePages()];
    }


	/**
	 * views user's profiles
	 *
	 * @param $username
	 * @param TweetService $tweetService
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @internal param UserInterface $userRepo
	 *
	 */
    public function viewUser($username, TweetService $tweetService)
    {
	    if(Auth::user()->username == $username)
		    return redirect()->route('user.profile');

	    $user = $this->userRepo->searchUsername($username, false);

	    // trying to open profile doesn't exists
	    if(!$user && $username != Auth::user()->username)
	    {
	    	abort(404);
	    }


	    // current user's tweets
	    $tweets = $user->tweets()->with('likes')->get();

	    // booleans whether current users likes the tweet or not!
	    $likes = $tweetService->categoriseLikes($user);

	    // check if current user follows the desired user
	    $follow = $this->userRepo->currentUserFollows($user->id);


	    return view('users.view', [
	    	'user' => $user,
		    'tweets' => $tweets,
		    'likes' => $likes,
		    'follow' => $follow
	    ]);
    }


	/**
	 * Views current user's profile
	 *
	 * @param TweetService $tweetService
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function viewProfile(TweetService $tweetService)
    {
    	// current user's profile
    	$user = Auth::user();

    	// current user's tweets
    	$tweets = $user->tweets()->with('likes')->get();

    	// booleans whether current users likes the tweet or not!
    	$likes = $tweetService->categoriseLikes($user);


	    return view('users.profile', [

    		'user' => Auth::user(),
		    'tweets' => $tweets,
		    'likes' => $likes,
		    'profile' => true
	    ]);
    }


	/**
	 * Follows or un follow user
	 *
	 * @param $username
	 * @param UserService $userService
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function follow($username, UserService $userService)
    {
    	// user not exists
    	$user = $this->userRepo->searchUsername($username, false);
    	if(! $user)
	    {
	    	abort(404);
	    }

	    // handle the following
	    $userService->followingHandler($user->id);

    	return redirect()->back();
    }
}

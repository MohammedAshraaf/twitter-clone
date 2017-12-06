<?php

namespace App\Http\Controllers;

use App\Repositories\User\UserInterface;
use App\Services\SocialLoginService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
	public function loginFacebook(SocialLoginService $socialLoginService, UserInterface $userRepo, UserService $userService)
	{
		// still needs to communicate with Facebook
		if(!Session::has('facebookUser'))
		{
			return Socialite::with('facebook')->redirect();
		}


		// fetch the user and forget the session
		$facebookUser = Session::get('facebookUser');
		Session::forget('facebookUser');

		$currentUser = $socialLoginService->alreadyExists($facebookUser->id);

		// if user already exists then log him in
		if($currentUser)
		{
			Auth::login($currentUser);
			return redirect()->route('news.feed');
		}


		// check for username and email uniqueness
		$name = str_replace(' ', '', $facebookUser->name);


		$match = $socialLoginService->matchExistedUser($name, $facebookUser->email);

		// check for username and email uniqueness
		if($match === false)
		{
			// All is good, create new user and log him in
			$newUser = $userRepo->storeUser(['username' => $name, 'email' => $facebookUser->email, 'password' => $userService->generatePassword(), 'facebook_token' => $facebookUser->id]);

			// add index to be used in search
			$newUser->searchable();

			Auth::login($newUser);

			return redirect()->route('news.feed');
		}

		// email exists
		if($match == 'email')
		{
			Session::flash('alert', trans('auth.emailExists'));

			return redirect()->route('register');
		}

		// new name
		$name = $socialLoginService->generateAvailableName($name);

		// Good Log him in
		$newUser = $userRepo->storeUser(['username' => $name, 'email' => $facebookUser->email, 'password' => $userService->generatePassword(), 'facebook_token' => $facebookUser->id]);

		// add index to be used in search
		$newUser->searchable();

		Auth::login($newUser);

		return redirect()->route('news.feed');
	}

}

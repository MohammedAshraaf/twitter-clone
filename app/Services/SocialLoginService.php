<?php


namespace App\Services;


use App\Repositories\User\UserInterface;

class SocialLoginService
{

	private $userService;


	private $userRepo;

	public function __construct(UserService $userService, UserInterface $userRepo)
	{

		$this->userService = $userService;
		$this->userRepo = $userRepo;
	}


	/**
	 * checks if we have this facebook credentials before
	 * @param $id
	 *
	 * @return mixed
	 */
	public function alreadyExists($id)
	{
		return $this->userRepo->searchUser(['facebook_token' => $id]);
	}


	/**
	 * check if user's credentials matches any existed user
	 * @param $name
	 * @param $email
	 *
	 * @return bool|string
	 */
	public function matchExistedUser($name, $email)
	{
		$checkUserName =  $this->userRepo->searchUsername($name, false);

		$checkEmail =  $this->userRepo->searchUser(['email' => $email]);

		if(!$checkUserName && !$checkEmail)
		{
			return false;
		}
		if($email)
			return 'email';
		return 'name';
	}


	/**
	 * Generates a unique username
	 * @param $name
	 *
	 * @return string
	 */
	public function generateAvailableName($name)
	{
		// get the last register user with username in alpha order
		$availableName = $this->userRepo->lastUserName($name);

		// give him unique username
		$availableName = str_replace($name, '', $availableName->username);

		if($availableName == '')
		{
			return $name . '1';
		}

		$name  .= intval($availableName) + 1;
		return $name;

	}


}
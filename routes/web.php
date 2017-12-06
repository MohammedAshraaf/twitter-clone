<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/login/facebook', ['as' => 'login.facebook', 'uses' => 'SocialLoginController@loginFacebook']);

Route::group(['middleware' =>  'auth'], function () {

	/**
	 * Feeds Routes
	 */
	Route::get( '/', ['as' => 'home', 'uses' => 'HomeController@home']);
	Route::get( '/home', ['as' => 'news.feed', 'uses' => 'FeedController@newsFeed']);
	Route::get( '/activity', ['as' => 'activity.feed', 'uses' => 'FeedController@activityFeed']);

	/**
	 * Users Routes
	 */
	Route::get('/find/user', ['as' => 'user.search', 'uses' => 'UserController@searchForUser']);
	Route::get('/search/user', ['as' => 'user.search.ajax', 'uses' => 'UserController@searchAjax']);
	Route::get('/visit/{username}', ['as' => 'user.view', 'uses' => 'UserController@viewUser']);
	Route::get('/profile', ['as' => 'user.profile', 'uses' => 'UserController@viewProfile']);
	Route::get('/follow/{username}', ['as' => 'user.follow', 'uses' => 'UserController@follow']);



	/**
	 * Tweets Routes
	 */
	Route::get('/tweet/{id}', ['as' => 'tweet.show', 'uses' => 'TweetController@show']);
	Route::post('/tweet/create', ['as' => 'tweet.create', 'uses' => 'TweetController@store']);
	Route::delete('/tweet/{id}', ['as' => 'tweet.delete', 'uses' => 'TweetController@destroy']);


	/**
	 * Likes Route
	 */
	Route::get('like/{tweet}' , ['as' => 'likes.like', 'uses' => 'LikeController@like']);
});



<?php

namespace App\Providers;

use App\Like;
use App\Mention;
use App\Repositories\Like\LikeRepository;
use App\Repositories\Mention\MentionRepository;
use App\Repositories\Tweet\TweetRepository;
use App\Tweet;
use App\User;
use App\Repositories\User\UserRepository;

use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    public function register()
    {
	    /*
         * Bind User Repository
         */
	    $this->app->bind('App\Repositories\User\UserInterface', function($app){
		    return new UserRepository(new User());
	    });
	    $this->app->bind('App\Repositories\Tweet\TweetInterface', function($app){
		    return new TweetRepository(new Tweet());
	    });
	    $this->app->bind('App\Repositories\Like\LikeInterface', function($app){
		    return new LikeRepository(new Like());
	    });
	    $this->app->bind('App\Repositories\Mention\MentionInterface', function($app){
		    return new MentionRepository(new Mention());
	    });
    }
}

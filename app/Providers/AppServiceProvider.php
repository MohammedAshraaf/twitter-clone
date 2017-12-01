<?php

namespace App\Providers;

use App\Events\MentionSaved;
use App\Events\LikeSaved;
use App\Like;
use App\Mention;
use App\Notification;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Mention::observe(MentionSaved::class);
        Notification::observe(LikeSaved::class);
        Like::observe(LikeSaved::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

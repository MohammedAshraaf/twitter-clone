<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','email', 'password','facebook_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


	/**
	 * Tweets relationship
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
    public function tweets()
    {
    	return $this->hasMany('App\Tweet');
    }

	/**
	 * Following Relationship
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function following()
	{
		return $this->belongsToMany('App\User', 'followers', 'follower_id', 'user_id');
	}

	/**
	 * Followers Relationship
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function followers()
	{
		return $this->belongsToMany('App\User', 'followers', 'user_id', 'follower_id');
	}


	/**
	 * Likes Relationship
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function likes()
	{
		return $this->hasMany('App\Like');
	}
}

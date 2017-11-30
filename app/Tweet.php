<?php

namespace App;

use App\QueryScopes\Tweets;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $fillable = [
    	'tweet', 'user_id'
    ];


	/**
	 * User Relationship
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }


	/**
	 * Likes Relationship
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
    public function likes()
    {
    	return $this->hasMany('App\Like');
    }

	/**
	 * Global Scope query
	 */
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope(new Tweets);
	}
}

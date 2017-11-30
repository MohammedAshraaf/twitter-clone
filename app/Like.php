<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{

	protected $fillable = [
		'user_id', 'tweet_id'
	];

	/**
	 * Tweet Relationship
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function tweet()
    {
    	return $this->belongsTo('App\Tweet');
    }

	/**
	 * User RelationShip
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}

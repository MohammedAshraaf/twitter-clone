<?php

namespace App;

use App\Events\MentionSaved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Mention extends Model
{
	use Notifiable;


    protected $fillable = [
        'tweet_id', 'user_id', 'mention_id'
    ];


	/**
	 * Mention Relationship
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function mention()
    {
    	return $this->belongsTo('App\User');
    }


    public function user()
    {
	    return $this->belongsTo('App\User');
    }


}

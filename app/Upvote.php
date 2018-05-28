<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upvote extends Model
{
    protected $table = 'upvotes';

    protected $fillable = ['answer_id', 'user_id'];

    /**
     * Answer relationship.
     *
     * @return App\Answer
     * @author Soumen Dey
     **/
    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    /**
     * User relationship.
     *
     * @return App\User
     * @author Soumen Dey
     **/
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

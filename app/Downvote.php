<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Downvote extends Model
{
    protected $table = 'downvotes';

    protected $fillable = ['user_id', 'answer_id'];

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

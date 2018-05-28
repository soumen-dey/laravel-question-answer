<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'follows';

    protected $fillable = ['followable_id', 'followable_type', 'user_id'];

    /**
     * Polymorphic relationship.
     *
     * @return Relationship
     * @author Soumen Dey
     **/
    public function followable()
    {
        return $this->morphTo();
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

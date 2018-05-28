<?php

namespace App;

use App\Question;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    protected $fillable = ['reportable_id', 'reportable_type', 'user_id'];

    /**
     * Polymorphic relationship.
     *
     * @return Relationship
     * @author Soumen Dey
     **/
    public function reportable()
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

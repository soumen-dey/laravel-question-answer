<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $table = 'views';

    protected $fillable = ['viewable_id', 'viewable_type', 'user_id'];

    /**
     * Polymorphic relationship.
     *
     * @return Relationship
     * @author Soumen Dey
     **/
    public function viewable()
    {
        return $this->morphTo();
    }
}

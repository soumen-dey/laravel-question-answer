<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = ['name'];

    /**
     * User relationship.
     *
     * @return Collection(App\User)
     * @author Soumen Dey
     **/
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

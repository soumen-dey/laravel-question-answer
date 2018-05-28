<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $table = 'details';

    protected $fillable = [
    	'bio',
		'qualification',
		'works_at',
		'college',
		'designation',
		'dob',
		'city_id',
		'user_id',
    ];

    /**
     * User Detail relationship.
     *
     * @return App\User
     * @author Soumen Dey
     **/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * City Detail relationship.
     *
     * @return App\City
     * @author Soumen Dey
     **/
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $table = 'avatars';

    protected $fillable = [
    	'original_file_name',
        'file_name',
        'file_path',
        'file_extension',
        'mime_type',
        'user_id',
    ];

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

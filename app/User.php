<?php

namespace App;

use App\Http\Traits\Role\HasRole;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Route Model Binding.
     *
     * @return String
     * @author Soumen Dey
     **/
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * Detail User relationship.
     *
     * @return App\Detail
     * @author Soumen Dey
     **/
    public function detail()
    {
        return $this->hasOne(Detail::class);
    }

    /**
     * Avatar User relationship.
     *
     * @return App\Avatar
     * @author Soumen Dey
     **/
    public function avatar()
    {
        return $this->hasOne(Avatar::class);
    }

    /**
     * Roles relationship.
     *
     * @return Collection(App\Role)
     * @author Soumen Dey
     **/
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Questions relationship.
     *
     * @return Collection(App\Question)
     * @author Soumen Dey
     **/
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Answer relationship.
     *
     * @return Collection(App\Answer)
     * @author Soumen Dey
     **/
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Follow relationship.
     *
     * @return Collection(App\Follow)
     * @author Soumen Dey
     **/
    public function follows()
    {
        return $this->morphMany(Follow::class, 'followable');
    }

    /**
     * Following relationship.
     *
     * @return Collection(App\User)
     * @author Soumen Dey
     **/
    public function followings()
    {
        return $this->hasMany(Follow::class, 'user_id');
    }

    /**
     * Get the followings of the user.
     *
     * @return Collection(App\Follow)
     * @author Soumen Dey
     **/
    public function getFollowings()
    {
        return $this->follows;
    }

    /**
     * Get the questions that the user is following.
     *
     * @return Collection(App\Question)
     * @author Soumen Dey
     **/
    public function getQuestionFollowings()
    {
        $questions = $this->follows
                    ->where('followable_type', Question::class)
                    ->pluck('followable_id')
                    ->toArray();

        return Question::whereIn('id', $questions)->get();
    }

    /**
     * Get the topics that the user is following.
     *
     * @return Collection(App\Topic)
     * @author Soumen Dey
     **/
    public function getTopicFollowings()
    {
        $topics = $this->follows
                    ->where('followable_type', Topic::class)
                    ->pluck('followable_id')
                    ->toArray();

        return Topic::whereIn('id', $topics)->get();
    }

    /**
     * Get the users that the user is following.
     *
     * @return Collection(App\User)
     * @author Soumen Dey
     **/
    public function getUserFollowings()
    {
        $users = $this->follows
                    ->where('followable_type', User::class)
                    ->pluck('followable_id')
                    ->toArray();

        return User::whereIn('id', $users)->get();
    }

    /**
     * Get the user followers.
     *
     * @return Collection(App\User)
     * @author Soumen Dey
     **/
    public function getFollowers()
    {
        $users = Follow::whereFollowableId($this->id)
                    ->whereFollowableType(self::class)
                    ->get()->pluck('user_id')->toArray();

        return User::whereIn('id', $users)->get();
    }

    /**
     * Determine if the currently authenticated user is following the user.
     *
     * @return Boolean
     * @author Soumen Dey
     **/
    public function isFollowing()
    {
        if ($this->follows()->where('user_id', auth()->user()->id)->first()) {
            return true;
        }

        return false;
    }
}

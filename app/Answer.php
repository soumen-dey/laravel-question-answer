<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';

    protected $fillable = [
        'body', 'reference', 'user_id', 'question_id', 'is_anonymous', 'is_moderated'
    ];

    /**
     * Route Model binding.
     *
     * @return String
     * @author Soumen Dey
     **/
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * Question relationship.
     *
     * @return App\Question
     * @author Soumen Dey
     **/
    public function question()
    {
        return $this->belongsTo(Question::class);
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

    /**
     * Upvotes relationship.
     *
     * @return Collection(App\Upvote)
     * @author Soumen Dey
     **/
    public function upvotes()
    {
        return $this->hasMany(Upvote::class);
    }

    /**
     * Downvotes relationship.
     *
     * @return Collection(App\Downvote)
     * @author Soumen Dey
     **/
    public function downvotes()
    {
        return $this->hasMany(Downvote::class);
    }

    /**
     * Report relationship.
     *
     * @return Collection(App\Report)
     * @author Soumen Dey
     **/
    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    /**
     * View relationship.
     *
     * @return Collection(App\Follow)
     * @author Soumen Dey
     **/
    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    /**
     * Determine if the answer is the best answer.
     *
     * @return Boolean
     * @author Soumen Dey
     **/
    public function isBestAnswer()
    {
        $question = $this->question;
        
        if ($question->hasBestAnswer()) {
            return $question->best_answer->id == $this->id;
        }

        return false;
    }

    /**
     * Determine if the specified user has already upvoted the answer.
     *
     * @return Boolean
     * @author Soumen Dey
     **/
    public function hasAlreadyUpvoted($user = null)
    {
        $user = _user($user);

        return $this->upvotes->contains('user_id', $user);
    }

    /**
     * Determine if the specified user has already downvoted the answer.
     *
     * @return Boolean
     * @author Soumen Dey
     **/
    public function hasAlreadyDownvoted($user = null)
    {
        $user = _user($user);

        return $this->downvotes->contains('user_id', $user);
    }

    /**
     * Determine if the specified user 
     * has already reported the answer.
     *
     * @return Boolean
     * @author Soumen Dey
     **/
    public function hasAlreadyReported($user = null)
    {
        $user = _user($user);

        return $this->reports->contains('user_id', $user);
    }

    /**
     * Determine if the answer is already moderated.
     *
     * @return Boolean
     * @author Soumen Dey
     **/
    public function isModerated()
    {
        return $this->is_moderated == 1;
    }

    /**
     * Get all reported questions.
     *
     * @return App\Question
     * @author Soumen Dey
     **/
    public function scopeGetReported()
    {
        $answers = self::all();

        return $answers->map(function($answer) {
            if ($answer->reports->count() && !$answer->isModerated()) {
                return $answer;
            }
        })->filter();
    }

    /**
     * Determine if the currently authenticated 
     * user the author/owner of the answer.
     *
     * @return Boolean
     * @author Soumen Dey
     **/
    public function isOwner()
    {
        return $this->user_id == auth()->user()->id;
    }

    /**
     * Alias for $this->isOwner() method.
     *
     * @return Boolean
     * @author Soumen Dey
     **/
    public function isAuthor()
    {
        return $this->isOwner();
    }
}

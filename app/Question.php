<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = [
        'title', 'body', 'slug', 'reference', 'user_id', 'is_moderated', 'is_anonymous', 'topic_id'
    ];

    /**
     * Route Model binding.
     *
     * @return String
     * @author Soumen Dey
     **/
    public function getRouteKeyName()
    {
        return 'slug';
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
     * User relationship.
     *
     * @return Collection(App\User)
     * @author Soumen Dey
     **/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Best answer relationship.
     *
     * @return Collection(App\User)
     * @author Soumen Dey
     **/
    public function best_answer()
    {
        return $this->hasOne(Answer::class, 'id', 'best_answer_id');
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
     * Topic relationship.
     *
     * @return App\Topic
     * @author Soumen Dey
     **/
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Determine if the currently authenticated 
     * user the author/owner of the question.
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

    /**
     * Determine if the specified user 
     * has already answered the question.
     *
     * @return Boolean
     * @author Soumen Dey
     **/
    public function hasAlreadyAnswered($user = null)
    {
        $user = _user($user);

        return $this->answers->contains('user_id', $user);
    }

    /**
     * Determine if the specified user 
     * has already reported the question.
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
     * Determine if the currently logged in user is following the question.
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

    /**
     * Determine if the question is anonymous.
     *
     * @return Boolean
     * @author Soumen Dey
     **/
    public function isAnonymous()
    {
        if ($this->is_anonymous === 1) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the question has a best answer.
     *
     * @return App\Answer
     * @author Soumen Dey
     **/
    public function hasBestAnswer()
    {
        if (!is_null($this->best_answer_id)) {
            return $this->best_answer;
        }

        return false;
    }

    /**
     * Determine if the specified answer belongs to the question.
     *
     * @return Boolean
     * @author Soumen Dey
     **/
    public function hasAnswerWithId($id = null)
    {
        return $this->answers->contains('id', $id);
    }

    /**
     * Determines if the question has a topic.
     *
     * @return App\Topic
     * @author Soumen Dey
     **/
    public function hasTopic()
    {
        if ($this->topic) {
            return $this->topic;
        }

        return false;
    }

    /**
     * Determine if the question is already moderated.
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
        $questions = self::all();

        return $questions->map(function($question) {
            if ($question->reports->count() && !$question->isModerated()) {
                return $question;
            }
        })->filter();
    }

    /**
     * Get popularity index for a question.
     *
     * @return Integer
     * @author Soumen Dey
     **/
    public function getPopularity()
    {
        // Formula
        // a = total answers 
        // b = total views 
        // c = total answer views 
        // d = followers 
        // e = answer upvotes
        // x = a + b + c + d + e
        // y = total questions
        // f = (x / y) * 100

        $answers = $this->answers;
        $views = $this->views->count();
        $followers = $this->follows->count();

        $answers_views = $answers->map(function($answer) {
            return $answer->views->count();
        })->toArray();

        $answer_upvotes = $answers->map(function($answer) {
            return $answer->upvotes->count();
        })->toArray();

        $answers_count = $answers->count();

        return ((array_sum($answers_views) + $views + $answers_count + $followers + array_sum($answer_upvotes)) / self::all()->count()) * 100;
    }
}

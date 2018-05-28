<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topics';

    protected $fillable = ['name', 'slug'];

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
     * Question relationship.
     *
     * @return Collection(App\Question)
     * @author Soumen Dey
     **/
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Determine if the currently logged in user is following the topic.
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
     * Get the top questions for the topic.
     *
     * @return Collection(App\Question)
     * @author Soumen Dey
     **/
    public function getTopQuestions()
    {
        return $this->questions()->where('is_moderated', 0)->get();
    }

    /**
     * Get the unanswered questions for the topic.
     *
     * @return Collection(App\Question)
     * @author Soumen Dey
     **/
    public function getUnansweredQuestions()
    {
        $questions = $this->questions;

        return collect($questions->map(function($question) {
            if ($question->answers->count() <= 0 && !$question->isModerated()) {
                return $question;
            }
        })->filter());
    }

    /**
     * Get the recent questions for the topic.
     *
     * @return Collection(App\Question)
     * @author Soumen Dey
     **/
    public function getRecentQuestions()
    {
        return $this->questions()
                ->where('is_moderated', 0)
                ->get()
                ->sortByDesc('id');
    }

    /**
     * Get the number of answers from all questions belonging
     * to this topic combined.
     *
     * @return Integer
     * @author Soumen Dey
     **/
    public function getTotalAnswers()
    {
        $questions = $this->questions()->with('answers')->get();

        $answers = $questions->map(function($question) {
            return $question->answers->count();
        })->toArray();

        return array_sum($answers);
    }
}

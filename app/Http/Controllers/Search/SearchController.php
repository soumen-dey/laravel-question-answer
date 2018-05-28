<?php

namespace App\Http\Controllers\Search;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Search questions.
     *
     * @return App\Question
     * @author Soumen Dey
     **/
    public function questions(Request $request)
    {
        $questions = Question::where('title', 'like', '%'.$request->q.'%')
        				->where('is_moderated', 0)
        				->with('answers', 'follows', 'views')
        				->limit(20)
        				->get();

        return $questions->map(function($question) {
        	$q['title'] = $question->title;
        	$q['link'] = route('questions.show', $question->slug);
        	$q['created_at'] = $question->created_at->diffForHumans();
        	$q['answers'] = $question->answers->count();
        	$q['follows'] = $question->follows->count();
        	$q['views'] = $question->views->count();
        	return $q;
        });

        return $questions;
    }
}

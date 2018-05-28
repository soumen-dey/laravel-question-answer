<?php

namespace App\Http\Controllers\Website;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebsiteController extends Controller
{
    /**
     * Welcome page.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function welcome()
    {
        if (!auth()->guest()) {
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');   
            }    
        }

        return view('welcome', [
	    	'questions' => Question::inRandomOrder()->take(4)->get(),
	    ]);
    }

    /**
     * Home page
     *
     * @return View
     * @author Soumen Dey
     **/
    public function home()
    {
        return view('home', [
            'questions' => Question::inRandomOrder()->take(20)->get(),
        ]);
    }

    

    /**
     * Questions.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function questions(Request $request)
    {
        $questions = Question::inRandomOrder()->take(20)->get();

        if ($request->has('q')) {

            $questions = Question::where('title', 'like', '%'.$request->q.'%')
                        ->where('is_moderated', 0)
                        ->with('answers', 'follows', 'views')
                        ->limit(20)
                        ->get();

            $questions->map(function($question) {
                $q['title'] = $question->title;
                $q['link'] = route('questions.show', $question->slug);
                $q['created_at'] = $question->created_at->diffForHumans();
                $q['answers'] = $question->answers->count();
                $q['follows'] = $question->follows->count();
                $q['views'] = $question->views->count();
                return $q;
            });
        }

        return view('questions', [
            'questions' => $questions,
        ]);
    }
}

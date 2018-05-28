<?php

namespace App\Http\Controllers\Question;

use App\Topic;
use App\Answer;
use App\Follow;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Question\StoreQuestionRequest;
use App\Http\Requests\Question\UpdateQuestionRequest;

class QuestionController extends Controller
{
    /**
     * Show a question.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function show(Question $question, $answer = null)
    {
        if ($question->isModerated()) {
            abort(401, 'The Question is Moderated.');
        }

        if (!is_null($answer)) {
            // Log view for the answer
            $answer = Answer::findOrFail($answer);
            _view($answer);

            return redirect('/questions/show/'.$question->slug.'#answer_'.$answer->id);    
        }

        return view('questions.show', [
            'question' => $question,
            'views' => _view($question),
            'topics' => Topic::inRandomOrder()->take(5)->get(),
            'questions' => Question::inRandomOrder()->take(10)->get(),
        ]);
    }

    /**
     * Add a question.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function add()
    {
        return view('questions.add');
    }

    /**
     * Store a question.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function store(StoreQuestionRequest $request)
    {
        $question = Question::create([
            'title' => ucfirst($request->title),
            'body' => $request->body,
            'reference' => $request->reference,
            'user_id' => auth()->user()->id,
            'slug' => _slug($request->title),
            'is_anonymous' => ($request->anonymous) ? 1 : 0,
        ]);

        return redirect()
                ->route('questions.show', $question->slug)
                ->with('message', 'Question added successfully!');
    }

    /**
     * Edit a question.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function edit(Question $question)
    {
        if (!$question->isOwner()) {
            abort(404);
        }

        return view('questions.edit', [
            'question' => $question,
        ]);
    }

    /**
     * Update a question.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function update(UpdateQuestionRequest $request)
    {
        $question = Question::find($request->question);

        // Check if the user owns the question
        if (!$question->isOwner()) {
            return redirect()
                    ->route('questions.show', $question->slug)
                    ->with('message', 'You cannot edit the question');
        }

        $question->title = ucfirst($request->title);
        $question->body = $request->body;
        $question->reference = $request->reference;
        $question->slug = _slug($request->title);
        $question->is_anonymous = ($request->anonymous) ? 1 : 0;
        $question->save();

        return redirect()
                    ->route('questions.show', $question->slug)
                    ->with('message', 'Question has been edited!');
    }
}

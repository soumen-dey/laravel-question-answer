<?php

namespace App\Http\Controllers\Answer;

use App\Upvote;
use App\Answer;
use App\Question;
use App\Downvote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Answer\StoreAnswerRequest;
use App\Http\Requests\Answer\UpdateAnswerRequest;

class AnswerController extends Controller
{
    /**
     * Add a answer.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function add()
    {
        return view('questions.add');
    }

    /**
     * Store a answer.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function store(StoreAnswerRequest $request)
    {
    	// Check if the user has already answered the question
    	$if_answered = Question::find($request->question)
    					->hasAlreadyAnswered();

    	if ($if_answered) {
    		return response(['message' => 'An error occured.'], 422);
    	}

        $answer = Answer::create([
        	'body' => $request->body,
        	'reference' => $request->reference,
        	'user_id' => auth()->user()->id,
        	'question_id' => $request->question,
        ]);
    }

    /**
     * Edit a answer.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function edit(Answer $answer)
    {
        if (!$answer->isOwner()) {
            abort(404);
        }

        return view('questions.answers.edit', [
            'answer' => $answer,
        ]);
    }

    /**
     * Update a answer.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function update(UpdateAnswerRequest $request)
    {
        $answer = Answer::find($request->answer);

        // Check if the user owns the answer
        if (!$answer->isOwner()) {
            return redirect()
                    ->route('questions.show', $answer->question->slug)
                    ->with('message', 'You cannot edit the answer');
        }

        $answer->body = $request->body;
        $answer->reference = $request->reference;
        $answer->is_anonymous = ($request->anonymous) ? 1 : 0;
        $answer->save();

        return redirect()
                    ->route('questions.show', $answer->question->slug)
                    ->with('message', 'Answer has been edited!');
    }

    /**
     * Pick the best answer for the question.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function best(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:answers,id',
            'question' => 'required|integer|exists:questions,id',
        ]);

        $question = Question::find($request->question);

        // Check if the question already has best answer
        if ($question->hasBestAnswer()) {
            return response()->json([
                'status' => 'error',
                'message' => 'already_has_best_answer',
            ], 422);
        }

        // Check if the question is owned by the user
        if (!$question->isOwner()) {
            return response()->json([
                'status' => 'error',
                'message' => 'not_owner',
            ], 422);
        }

        // Check if the answer belong to the question
        if (!$question->hasAnswerWithId($request->id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'answer_does_not_belong_to_question',
            ], 422);
        }

        $question->best_answer_id = $request->id;
        $question->save();

        return response()->json([
            'status' => 'OK',
            'message' => 'best_answer',
        ], 200);
    }

    /**
     * Upvote an answer.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function upvote(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:answers,id',
            'question' => 'required|integer|exists:questions,id',
        ]);

        $question = Question::find($request->question);
        $answer = Answer::find($request->id);

        // Check if the answer belongs to the question
        if (!$question->hasAnswerWithId($request->id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'answer_does_not_belong_to_question',
            ], 422);
        }

        // Check if the user has already upvoted the answer
        if ($answer->hasAlreadyUpvoted()) {
            $upvote = Upvote::whereUserId(auth()->user()->id)
                            ->whereAnswerId($answer->id)
                            ->first()
                            ->delete();

            return response()->json([
                'status' => 'OK',
                'message' => 'un_upvoted',
                'upvotes' => $answer->upvotes->count(),
            ], 200);
        }

        Upvote::create([
            'user_id' => auth()->user()->id,
            'answer_id' => $answer->id,
        ]);

        return response()->json([
            'status' => 'OK',
            'message' => 'upvoted',
            'upvotes' => $answer->upvotes->count(),
        ], 200);
    }

    /**
     * Downvote an answer.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function downvote(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:answers,id',
            'question' => 'required|integer|exists:questions,id',
        ]);

        $question = Question::find($request->question);
        $answer = Answer::find($request->id);

        // Check if the answer belongs to the question
        if (!$question->hasAnswerWithId($request->id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'answer_does_not_belong_to_question',
            ], 422);
        }

        // Check if the user has already downvoted the answer
        if ($answer->hasAlreadyDownvoted()) {
            return response()->json([
                'status' => 'error',
                'message' => 'already_downvoted',
            ], 422);
        }

        Downvote::create([
            'user_id' => auth()->user()->id,
            'answer_id' => $answer->id,
        ]);

        return response()->json([
            'status' => 'OK',
            'message' => 'downvoted',
            'downvotes' => $answer->downvotes->count(),
        ], 200);
    }

    /**
     * Log a view for the answer.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function view(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:answers,id',
        ]);

        $answer = Answer::find($request->id);

        _view($answer);

        return response()->json([
            'status' => 'OK',
            'message' => 'logged_view',
        ], 200);
    }
}

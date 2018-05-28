<?php

namespace App\Http\Controllers\Report;

use App\Answer;
use App\Report;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Report a question.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function question(Request $request)
    {
        $request->validate([
        	'id' => 'required|integer|exists:questions,id',
        ]);

        $question = Question::find($request->id);

        if ($question->hasAlreadyReported()) {
        	return response()->json([
        		'status' => 'error', 
        		'message' => 'already_reported',
        	], 422);
        }

        $question->reports()->create([
        	'user_id' => auth()->user()->id,
        ]);

        return response()->json([
    		'status' => 'OK', 
    		'message' => 'reported',
    	], 200);
    }

    /**
     * Report an answer.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function answer(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:answers,id',
        ]);

        $answer = Answer::find($request->id);

        // Check if the user has already reported the answer
        if ($answer->hasAlreadyReported()) {
            return response()->json([
                'status' => 'error', 
                'message' => 'already_reported',
            ], 422);
        }

        $answer->reports()->create([
            'user_id' => auth()->user()->id,
        ]);

        return response()->json([
            'status' => 'OK', 
            'message' => 'reported',
        ], 200);
    }
}

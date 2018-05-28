<?php

namespace App\Http\Controllers\Admin;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Report index for questions.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function questions()
    {
        return view('admin.reports.questions', [
            'questions' => Question::getReported(),
        ]);
    }

    /**
     * Report for a single question.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function question(Question $question)
    {
        return view('admin.reports.question', [
        	'question' => $question,
        ]);
    }

    /**
     * Report index for answers.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function answers()
    {
        return view('admin.reports.answers', [
            'answers' => Answer::getReported(),
        ]);
    }

    /**
     * Report index for a single answer.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function answer(Answer $answer)
    {
        return view('admin.reports.answer', [
        	'answer' => $answer,
        ]);
    }

    /**
     * Moderate a question.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function moderateQuestion(Request $request)
    {
        $request->validate([
        	'id' => 'required|integer|exists:questions,id',
        ]);

        $question = Question::find($request->id);

        // Check if the question is already moderated
        if ($question->isModerated()) {
        	return response()->json([
        		'status' => 'error',
        		'message' => 'already_moderated',
        	], 422);
        }

        $question->is_moderated = 1;
        $question->save();

        return response()->json([
        	'status' => 'OK',
        	'message' => 'moderated',
       	], 200);
    }

    /**
     * Moderate a answer.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function moderateAnswer(Request $request)
    {
        $request->validate([
        	'id' => 'required|integer|exists:questions,id',
        ]);

        $answer = Answer::find($request->id);

        // Check if the answer is already moderated
        if ($answer->isModerated()) {
        	return response()->json([
        		'status' => 'error',
        		'message' => 'already_moderated',
        	], 422);
        }

        $answer->is_moderated = 1;
        $answer->save();

        return response()->json([
        	'status' => 'OK',
        	'message' => 'moderated',
       	], 200);
    }
}

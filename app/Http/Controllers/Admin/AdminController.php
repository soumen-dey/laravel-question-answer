<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Index
     *
     * @return View
     * @author Soumen Dey
     **/
    public function index()
    {
        return view('admin.dashboard', [
            'questions' => Question::getReported(),
            'answers' => Answer::getReported(),
            'users' => User::all(),
        ]);
    }
}

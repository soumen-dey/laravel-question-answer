<?php

namespace App\Http\Controllers\Topic;

use App\Topic;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Topic\StoreTopicQuestionRequest;

class TopicController extends Controller
{
    /**
     * Show a topic.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function show(Topic $topic)
    {
        $request = request();
        $params = [
            'topic' => $topic,
            'totalAnswers' => $topic->getTotalAnswers(),
            'topics' => Topic::inRandomOrder()->take(5)->get(),
        ];

        if ($request->has('v')) {
            $v = $request->v;

            if ($v = 'top') {
                $params['topQuestions'] = $topic->getTopQuestions();
            }

            if ($v = 'unanswered') {
                $params['unansweredQuestions'] = $topic->getUnansweredQuestions();
            }

            if ($v = 'recent') {
                $params['recentQuestions'] = $topic->getRecentQuestions();
            }
        } else {
            $params['topQuestions'] = $topic->getTopQuestions();
        }

        return view('topics.show', $params);
    }

    /**
     * Add a question to the topic.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function question(Topic $topic)
    {
        return view('topics.question', [
            'topic' => $topic,
        ]);
    }

    /**
     * Store topic question.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function storeQuestion(StoreTopicQuestionRequest $request)
    {
        $question = Question::create([
            'title' => ucfirst($request->title),
            'body' => $request->body,
            'reference' => $request->reference,
            'user_id' => auth()->user()->id,
            'slug' => _slug($request->title),
            'is_anonymous' => ($request->anonymous == 'on') ? 1 : 0,
            'topic_id' => $request->topic,
        ]);

        return redirect()
                ->route('questions.show', $question->slug)
                ->with('message', 'Question added successfully!');
    }

    /**
     * Add a topic.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function add()
    {
        return view('topics.add');
    }

    /**
     * Store a topic.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function store(Request $request)
    {
    	$request->validate([
            'title' => 'required|string|max:190',
        ]);

        $topic = Topic::create([
            'name' => $request->title,
            'slug' => _slug($request->title),
        ]);

        return redirect()->route('topics.show', $topic->slug);
    }

    /**
     * Edit a topic.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function edit()
    {
        
    }

    /**
     * Update a topic.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function update(Request $request)
    {
        
    }
}

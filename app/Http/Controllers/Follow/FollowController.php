<?php

namespace App\Http\Controllers\Follow;

use App\User;
use App\Topic;
use App\Follow;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FollowController extends Controller
{
    /**
     * Follow a question.
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

        if ($question->is_moderated === 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'question_moderated',
            ], 422);
        }

    	return $this->followOrUnfollow($question);
    }

    /**
     * Follow a topic.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function topic(Request $request)
    {
    	$request->validate([
    		'id' => 'required|integer|exists:topics,id',
    	]);

    	$topic = Topic::find($request->id);

    	return $this->followOrUnfollow($topic);
    }

    /**
     * Follow a user.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function user(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:users,id',
        ]);

        $user = User::find($request->id);

        if (auth()->user()->id == $user->id) {
            return response()->json([
                        'status' => 'OK', 
                        'message' => 'user_following_self',
                    ], 422);
        }

        return $this->followOrUnfollow($user);
    }

    /**
     * Follows or unfollows an entity.
     *
     * @return Response
     * @author Soumen Dey
     **/
    private function followOrUnfollow($object)
    {
        $follows = $object->follows()
							->where('user_id', auth()->user()->id)
							->first();

		// Check if the user already follows the object.
		if ($follows) {
			
			// Unfollow the object
			$follows->delete();

			return response()->json([
						'status' => 'OK', 
						'message' => 'unfollowed', 
						'count' => $object->follows()->count()
					], 200);
		}

		// Follow the object
		$object->follows()->create([
			'user_id' => auth()->user()->id,
		]);
		
		return response()->json([
					'status' => 'OK', 
					'message' => 'followed', 
					'count' => $object->follows()->count()
				], 200);
    }
}

<?php

namespace App\Http\Controllers\User;

use App\City;
use App\User;
use App\Detail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Show a user.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function show(User $user, $section = null)
    {
        return view('users.show', [
        	'user' => $user,
        ]);
    }

    /**
     * Edit a user.
     *
     * @return View
     * @author Soumen Dey
     **/
    public function edit()
    {
        return view('users.edit', [
            'user' => auth()->user(),
            'cities' => City::all(),
        ]);
    }

    /**
     * Update a user.
     *
     * @return Response
     * @author Soumen Dey
     **/
    public function update(UpdateUserRequest $request)
    {
        $user = User::find(auth()->user()->id);

        $user->name = ucwords($request->name);
        $user->save();

        $detail = Detail::whereUserId($user->id)->first();
        $detail->bio = $request->bio;
        $detail->qualification = $request->qualification;
        $detail->works_at = $request->working;
        $detail->college = $request->college;
        $detail->designation = $request->designation;
        $detail->dob = $request->dob;
        $detail->city_id = $request->city;
        $detail->save();

        return redirect()->route('users.show', $user->id);
    }
}

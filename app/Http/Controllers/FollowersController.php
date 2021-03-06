<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class FollowersController extends Controller
{
    //

	public function __construct() {
		$this->middleware('auth');
	}

    public function store(User $user) {
    	if (Auth::user()->id === $user->id) {
    		return redirect('/');
    	}

    	if (!Auth::user()->isFollowings($user->id)) {
    		Auth::user()->follow($user->id);
    	}

    	return redirect()->route('users.show', $user->id);

    }

    public function destroy(User $user) {
    	if (Auth::user()->id === $user->id) {
    		return redirect('/');
    	}

    	if (Auth::user()->isFollowings($user->id)) {
    		Auth::user()->unfollow($user->id);
    	}

    	return redirect()->route('users.show', $user->id);
    }
}

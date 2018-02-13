<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    //

    public function __construct() {
    	$this->middleware('auth', [
    		'except' => ['create', 'show', 'store'],
    	]);

    	$this->middleware('guest', [
    		'only' => ['create']
    	]);
    }

    public function index() {
    	$users = User::paginate(15);
    	return view('users.index', compact('users'));
    }

    public function create() {
    	return view('users.create');
    }

    public function show(User $user) {
    	return view('users.show', compact('user'));
    }

    public function store(Request $request) {
    	$this->validate($request, [
    		'name' => 'required|max:20',
    		'email' => 'required|email|max:255|unique:users',
    		'password' => 'required|confirmed|min:6',
    	]);

    	$user = User::create([
    		'name' => $request['name'],
    		'email' => $request['email'],
    		'password' => bcrypt($request['password']),
    	]);

    	session()->flash('success', '注册成功。');
    	Auth::login($user);
    	return redirect()->route('users.show', $user->id);
    }

    public function edit(User $user) {
    	if (Auth::user()->can('update', $user)) {
    		return view('users.edit', compact('user'));
    	} else {
    		return "DON'T";
    	}
    	
    }

    public function update(User $user, Request $request) {
    	$this->validate($request, [
    		'name' => 'required|max:50',
    		'password' => 'nullable|confirmed|min:6|max:50',
    	]);

    	if (Auth::user()->can('update', $user)) {
    		$data = [];
	    	$data['name'] = $request->name;
	    	if ($request->password) {
	    		$data['password'] = bcrypt($request->password);
	    	}

	    	$user->update($data);

	    	session()->flash('success', '更新成功。');
	    	return redirect()->route('users.show', $user->id);
    	} else {
    		return "DON'T";
    	}
    	
    }

    public function destroy(User $user) {
    	$this->authorize('destroy', $user);
    	session()->flash('success', "成功删除用户 - '$user->name'");
    	$user->delete();
    	return redirect()->back();
    }
}

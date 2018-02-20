<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Mail;

class UsersController extends Controller
{
    //

    public function __construct() {
    	$this->middleware('auth', [
    		'except' => ['create', 'show', 'store', 'confirmEmail'],
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
        $statuses = $user->hasManyStatuses()->orderBy('created_at', 'desc')->paginate('30');
    	return view('users.show', compact('user', 'statuses'));
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

    	session()->flash('success', '注册成功。请通过您的邮箱进行验证。');
    	$this->sendConfirmEmail($user);
    	return redirect('/');
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

    protected function sendConfirmEmail($user) {
        $view = "emails.confirm";
        $data = compact('user');
        $from = "460905539@qq.com";
        $name = 'WENHAO';
        $to = $user->email;
        $subject = "邮箱验证";

        Mail::send($view, $data, function ($message) use ($from, $to, $name, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }

    public function confirmEmail($token) {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '验证成功，开始您的旅程吧。');
        return redirect()->route('users.show', $user->id);
    }

    public function followings(User $user) {
        $users = $user->hasManyFollows()->paginate(30);
        $title = "关注";
        return view('users.show_follow', compact('title', 'users'));
    }

    public function followers(User $user) {
        $users = $user->hasManyFollowers()->paginate(30);
        $title = "粉丝";
        return view('users.show_follow', compact('title', 'users'));
    }
}

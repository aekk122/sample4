<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class SessionsController extends Controller
{
    //

    public function create() {
    	return view('sessions.create');
    }

    public function store(Request $request) {
    	$credential = $this->validate($request, [
    		'email' => 'required|email|max:255',
    		'password' => 'required',
    	]);

    	if (Auth::attempt($credential, $request->has('remember'))) {
    		//登录成功
    		session()->flash('success', '欢迎回来。');
    		return redirect()->route('users.show', Auth::user()->id);
    	} else {
    		//登录失败
    		session()->flash('danger', '用户名或者密码错误。');
    		return redirect()->back();
    	}
    }

    public function destroy() {
    	Auth::logout();
    	session()->flash('success', '退出成功');
    	return redirect()->route('login');
    }

}

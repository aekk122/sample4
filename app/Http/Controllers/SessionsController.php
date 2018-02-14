<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Mail;

class SessionsController extends Controller
{
    //
    public function __construct() {
    	$this->middleware('guest', [
    		'only' => ['create'],
    	]);
    }

    public function create() {
    	return view('sessions.create');
    }

    public function store(Request $request) {
    	$credential = $this->validate($request, [
    		'email' => 'required|email|max:255',
    		'password' => 'required',
    	]);

    	if (Auth::attempt($credential, $request->has('remember'))) {
    		//验证成功
            if(Auth::user()->activated) {
                //检测是否邮箱验证
                session()->flash('success', '欢迎回来。');
                return redirect()->intended(route('users.show', Auth::user()->id));
            } else {
                Auth::logout();
                session()->flash('info', '请通过您的邮箱进行验证');
                return redirect('/');
            }
    		
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

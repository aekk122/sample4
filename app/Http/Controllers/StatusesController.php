<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    //
    public function __construct() {
    	$this->middleware('auth');
    }

    public function store(Request $request) {
    	$this->validate($request, [
    		'content' => 'required|max:140',
    	]);

    	Auth::user()->hasManyStatuses()->create([
    		'content' => $request->content,
    	]);

    	return redirect()->back();
    }

    public function destroy(Status $status) {
    	if(Auth::user()->can('destroy', $status)) {
    		$status->delete();
    		session()->flash('success', '微博删除成功。');
    		return redirect()->back();
    	}

    	return "Don't！！！";
    }
}

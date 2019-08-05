<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class StatusesController extends Controller
{
    // 需要用户登录之后才能执行的请求需要通过中间件来过滤
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);

        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);

        session()->flash('success','发布成功^_^');
        return redirect()->back();
    }
}

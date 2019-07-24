<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;


class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        // 验证规则
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);
        
        // 数据库验证
        if (Auth::attempt($credentials,$request->has('remember'))) {
            // 消息提示
            session()->flash('success','欢迎回来');
            // 页面重定向
            return redirect()->route('users.show', [Auth::user()]);
        } else {
            session()->flash('danger','sorry! 您的邮箱与密码不匹配.');
            return redirect()->back()->withInput();
        }
    }

    public function destroy()
    { 
        // 用户登出
        Auth::logout();
        // 闪存提示
        session()->flash('success','下次见~!');
        // 重定向
        return redirect('/');
    }
}

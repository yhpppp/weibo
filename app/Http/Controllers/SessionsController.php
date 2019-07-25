<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;


class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

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
        if (Auth::attempt($credentials, $request->has('remember'))) {
            if (Auth::user()->activated) {
                // 消息提示
                session()->flash('success', '欢迎回来');
                // 页面重定向
                $fallback =  route('users.show', [Auth::user()]);
                // 友好的转向
                return redirect()->intended($fallback);
            } else {
                Auth::logout();
                session()->flash('warning','你的账号未激活,点我去激活~!');
                return redirect('/');
            }
        } else {
            session()->flash('danger', 'sorry! 您的邮箱与密码不匹配.');
            return redirect()->back()->withInput();
        }
    }

    public function destroy()
    {
        // 用户登出
        Auth::logout();
        // 闪存提示
        session()->flash('success', '下次见~!');
        // 重定向
        return redirect('/');
    }
}

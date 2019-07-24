<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
class UsersController extends Controller
{
    /**
     * 用户注册页
     */
    public function Create()
    {
        return  view('users.create');
    }

    /**
     * 用户个人页
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * 用户注册处理
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        // 自动登录
        Auth::login($user);
        
        session()->flash('success', '欢迎新人!');
        return redirect()->route('users.show', [$user]);
    }
}

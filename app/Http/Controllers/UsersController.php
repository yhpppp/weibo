<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Mail;

class UsersController extends Controller
{

    public function __construct()
    {
        // 未登录用户的限制
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index', 'confirmEmail']
        ]);

        // 只让未登录用户访问注册页面：
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }


    /**
     * 用户注册页
     */
    public function Create()
    {
        return  view('users.create');
    }

    /**
     * 用户编辑页
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    /**
     * 用户列表页
     */
    public function index()
    {
        // 分页
        $userAll = User::paginate(10);
        return view('users.index', compact('userAll'));
    }


    /**
     * 用户个人页
     */
    public function show(User $user)
    {
        // 获取用户所有微博动态 
        $statuses = $user->statuses()->orderBy('created_at', 'desc')->paginate(10);

        return view('users.show', compact('user', 'statuses'));
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
        // Auth::login($user);

        // 激活邮箱
        $this->sendEmailConfirmationTo($user);

        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收!');
        return redirect('/');
    }

    /**
     * 发送邮件给指定用户
     */
    public function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm'; // param-1 邮件消息的视图名称
        $data = compact('user'); // param-2 传递给该视图的数据数组。
        $from = 'summer@example.com';
        $name = 'Summer';
        $to = $user->email;
        $subject = '请确认你的邮箱';

        // param-3 接收邮件消息实例的闭包回调，我们可以在该回调中自定义邮件消息的发送者、接收者、邮件主题等信息。
        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }

    /**
     * 更新处理
     */
    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);

        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        session()->flash('success', '修改成功!~');

        return redirect()->route('users.show', $user->id);
    }

    /**
     * 删除处理 
     */
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '删除成功!');
        return back();
    }

    /**
     * 完成用户的激活操作
     */
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }


}

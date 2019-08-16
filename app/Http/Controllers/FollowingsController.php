<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class FollowingsController extends Controller
{
    // 方法里，都需要做授权判断。
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        $this->authorize('follow', $user);
        if(! Auth::user()->isFollowing($user->id)) {
            Auth::user()->follow($user->id);
        }
        return redirect()->route('users.show', $user->id);
    }

    public function destroy(User $user)
    {
        $this->authorize('follow', $user);

        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->unfollow($user->id);
        }

        return redirect()->route('users.show', $user->id);
    }
    
    

}

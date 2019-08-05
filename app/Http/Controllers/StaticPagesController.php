<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class StaticPagesController extends Controller
{
    public function home()
    {
        $feed_list = [];
        if(Auth::check()){
            $feed_list = Auth::user()->feed()->paginate(30);
        }
    
        
        return view('static_pages/home',compact('feed_list'));
    }

    public function help()
    {
        return view('static_pages/help');
    }
    public function about()
    {
        return view('static_pages/about');
    }
}

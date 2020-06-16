<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Post;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    //
    public function mainPage(){
        return view('client.pages.main', [
            'posts' => Post::where('published', true)->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }
    public function profile(){
        return view('client.pages.profile.index', [
            'user' => Auth::user(),
            'lastPost' => Auth::user()->posts->last(),
        ]);
    }
}

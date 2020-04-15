<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        return view('admin.dashboard',[
            'categories' => Category::all(),
            'posts' => Post::all(),
            'users' => User::all(),
        ]);
    }
}

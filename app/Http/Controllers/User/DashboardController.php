<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        return view('client.dashboard', [
            'posts' => Post::all(),
        ]);
    }
}

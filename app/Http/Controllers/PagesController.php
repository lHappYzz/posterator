<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
    public function mainPage(){
        return view('client.pages.main', [
            'posts' => Post::all(),
        ]);
    }
}

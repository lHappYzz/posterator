<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function index(){
        $todayPosts = Post::with('created_at')->where('created_at','LIKE', date("Y-m-d") . '%')->count();
        $lastWeekDayPosts = Post::with('created_at')->where('created_at','LIKE', substr(Carbon::now()->subDays(7),0,10) . '%')->count();
        $compareWithLastWeekDay = $this->getCompares($todayPosts, $lastWeekDayPosts);

        $weekPosts = $this->getWeekPosts(0);
        $lastWeekPosts = $this->getWeekPosts(7);
        $compareWithLastWeek = $this->getCompares($weekPosts, $lastWeekPosts);


        return view('admin.dashboard',[
            'totalPosts' => Post::all()->count(),
            'todayPosts' => $todayPosts,
            'compareWithLastWeekDay' => ($compareWithLastWeekDay <= 0 ? '' : '+') . $compareWithLastWeekDay . '%',
            'weekPosts' => $weekPosts,
            'compareWithLastWeek' => ($compareWithLastWeek <= 0 ? '' : '+') . $compareWithLastWeek  . '%',
        ]);
    }

    private function getWeekPosts(int $subDays){
        $now = Carbon::now()->subDays($subDays);
        $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d');

        return $weekPosts = Post::with('created_at')->whereBetween('created_at',[$weekStartDate . '%', $weekEndDate . '%'])->count();
    }

    private function getCompares(float $firstElementToCompare, float $secondElementToCompare){
        if ($secondElementToCompare == 0) return 100;

        $compare = $secondElementToCompare == 0 ? 0 : $firstElementToCompare / $secondElementToCompare * 100 - 100;

        if ($compare - floor($compare) != 0)
            $compare = number_format($compare, 2, '.', '');

        return $compare;
    }
}

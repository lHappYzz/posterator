<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    //
    public $timestamps = true;
    protected $table = 'posts';
    protected $fillable = ['title', 'slug', 'published', 'text', 'user_id', 'updated_at'];
    protected $columns = ['id','title','slug','text', 'published', 'user_id', 'created_at', 'updated_at'];

    public function creator(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function comments(){
        return $this->hasMany('App\Comment', 'post_id', 'id');
    }

    public function getRouteKeyName(){
        return 'slug';
    }

    public function shortDesc($length = null){
        $text = strip_tags($this->text);
        $text = trim(substr($text, 0, $length ?? 255));
        $text .= '...';
        return $text;
    }

    public static function getLatestPosts(int $count = 3){
        return Post::orderBy('created_at', 'desc')->limit($count)->get();
    }

    public static function getPostsByDaysAgo(int $daysAgo = 0){
        return Post::whereDate('created_at', Carbon::today()->subDays($daysAgo))->get();
    }

    public static function getPostsByWeeksAgo(int $weeksAgo = 0){
        $now = Carbon::now()->subWeeks($weeksAgo);
        $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d');

        return $weekPosts = Post::all()->whereBetween('created_at',[$weekStartDate . '%', $weekEndDate . '%']);
    }
    public function scopeExclude($query,$value = array()){
        return $query->select( array_diff($this->columns,(array) $value) );
    }
}

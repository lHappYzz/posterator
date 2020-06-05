<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    //
    public $timestamps = true;
    protected $table = 'posts';
    protected $fillable = ['title', 'slug', 'published', 'text', 'user_id', 'updated_at'];

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
}

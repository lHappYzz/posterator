<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    public $timestamps = true;
    protected $table = 'posts';
    protected $fillable = ['title','published','text','user_id', 'updated_at'];
}

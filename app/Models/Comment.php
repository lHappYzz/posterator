<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public $timestamps = true;
    protected $table = 'comments';
    protected $fillable = ['comment', 'parent_comment_id', 'post_id', 'user_id', 'updated_at'];

    public function child_comments(){
        return $this->hasMany(self::class, 'parent_comment_id', 'id');
    }
    public function creator(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}

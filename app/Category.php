<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title'];
    //
    public  function child_categories(){
//        return $this->hasMany(self::class, 'parent_id');
        return $this->hasMany('App/Child_category');
    }
}

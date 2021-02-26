<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'updated_at'];
    //
    public function child_categories(){
//        return $this->hasMany(self::class, 'parent_id');
        return $this->hasMany(Child_category::class);
    }
}

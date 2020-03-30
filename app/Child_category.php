<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Child_category extends Model
{
    public $timestamps = true;
    protected $table = 'child_categories';
    protected $fillable = ['title', 'category_id'];
}

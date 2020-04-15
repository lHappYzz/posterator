<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $table = 'roles';
    protected $fillable = ['name', 'updated_at'];

    public function users(){
        return $this->belongsToMany('App\User', 'user_roles', 'role_id', 'user_id');
    }
}

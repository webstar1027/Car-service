<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //

    
    protected $table = "roles";

    public function users()
    {
    	return $this->belongsToMany("App\User");
    }

    public function userRoles()
    {
        return $this->hasMany('App\Model\RoleUser');
    }
}

<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany("App\Model\Role");
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) //Check if is an array
        {

            foreach ($roles as $role) //Iterates through the array
            {
                if ($this->hasRole($role)) //if the current iteration has the role
                {
                    return true;
                }
            }

        } 
        else 
        {
            //if not an array
            if ($this->hasRole($roles)) 
            {
                return true;
            }
        }

        return false;
    }

    public function hasRole($role)
    {
        return $this->roles()->where('role_name', $role)->first() ? true : false;//Checks if the user has the roles specified from the parameter
    }
}

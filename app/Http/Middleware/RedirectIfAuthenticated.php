<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Model\RoleUser;
use App\Model\Role;
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    protected $roleuser;
    protected $role;
    public function __construct(RoleUser $roleuser, Role $role) {
            $this->roleuser = $roleuser;
            $this->role = $role;
    }
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            
             $user_id = Auth::user()->id;
             $role_id = $this->roleuser::where('user_id', $user_id)->first()->role_id;
             $role_name =$this->role::where('id', $role_id)->first()->role_name;

             if($role_name == 'user') {
                return redirect('/usermain');
             }
             elseif($role_name == 'shopowner'){
                return redirect('/shopowner');
             }

        }

        return $next($request);
    }
}

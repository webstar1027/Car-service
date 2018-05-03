<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       if($request->user() === null)//Check if not logged in.
        {
            return response("Access denied no permission to do the action.", 401);//Return access denied
        }
        $actions = $request->route()->getAction();//Get the roles from the routes example: ['roles' => ['admin', 'user']]
        $roles = isset($actions['roles']) ? $actions['roles'] : null;//Checks if the roles variable exist in the route
        if($request->user()->hasAnyRole($roles) || !$roles)
        {
            return $next($request);
        }        
        return response("That URL is not allowed. Please check your role.", 405);
    }
}

<?php

namespace OTIFSolutions\ACLMenu\Http\Middleware;

use Closure;

class UserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * * @param  string  $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null)
    {
        if ($permission == null) $permission = $request->path();
        if ($request->user() == null) return redirect(config('laravelacl.redirect_url'));
        if ($request->user()['group'] !== null)
            foreach($request->user()['group']['user_roles'] as $userRole){
                if(count($userRole->permissions()->where('name','LIKE','%'.$permission)->get()) != 0)
                {
                    \Session::put('current_permission', $permission);
                    return $next($request);
                }
            }
        else if(count($request->user()['user_role']->permissions()->where('name','LIKE','%'.$permission)->get()) != 0)
        {
            \Session::put('current_permission', $permission);
            return $next($request);
        }
        return redirect(config('laravelacl.redirect_url'));
    }
}

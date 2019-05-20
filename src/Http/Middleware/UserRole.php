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
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null)
    {
        if ($permission == null) $permission = $request->path();
        if ($request->user() == null) return redirect('/');
        if(sizeof($request->user()['user_role']->permissions()->where('name','LIKE','%'.$permission)->get()) != 0)
        {
            \Session::put('current_permission', $permission);
            return $next($request);
        }
        return redirect('/');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class Role
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();
        
        $roles = is_array($role)
            ? $role
            : explode('|', $role);

        foreach($roles as $role) {
            // Check if user has the role This check will depend on how your roles are set up
            if($user->role->name==($role)){
                return $next($request);
            }
        }

        return redirect('home')->with('warning','You dod not have the right privileges');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class ProfileCompleted
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if($user->profile_completed==1){
            return $next($request);
        }

        return redirect('create_role_profile')->with('warning','Please complete your profile');
    }
}

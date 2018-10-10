<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class ActivationStatus
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
        $user = Auth::user();
        if(!empty($user)){ 
            
            if($user->activation == false){ 
                session()->flash('danger','请注册从邮件处激活账号');
                return redirect()->route('users.activation',[Auth::id()]);
            }

        }else{ 
                return redirect('login');
        }
        
        return $next($request);
    }
}

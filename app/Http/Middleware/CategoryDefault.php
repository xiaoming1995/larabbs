<?php

namespace App\Http\Middleware;

use Closure;
use Facades\App\Models\Category;

class CategoryDefault
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
          Category::put();

          return $next($request);
        
    }
}

<?php

function route_class()
{  
   //替换当前路由.
   return str_replace('.','-',Route::currentRouteName()); 
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}

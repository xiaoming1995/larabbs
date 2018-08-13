<?php

function route_class()
{  
   //替换当前路由.
   return str_replace('.','-',Route::currentRouteName()); 
}


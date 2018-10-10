<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Category extends Model
{
    protected $fillable = [
    	                    'name','description',
						  ];

	protected $cache_key = 'Category_default';

	protected $cache_time = 1440;

	
	public function put()
	{ 
		$ceshi = Cache::put($this->cache_key,$this->all(),$this->cache_time);
	}


}

<?php

namespace Phpstore\Repository;

use Cache;

trait SliderRepository{


	/*
    |-------------------------------------------------------------------------------
    |
    |   从数据库获取记录
    |
    |-------------------------------------------------------------------------------
    */
    public static function getListFromDatabase(){

    	$self 			= new static;
    	return  $self->take(4)->orderBy('sort_order','asc')->get();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   从缓存中获取记录
    |
    |-------------------------------------------------------------------------------
    */
    public static function getList(){

    	$key 			= 'slider_list';
    	if(Cache::has($key)){

    		return Cache::get($key);
    	}
    	$self 		    = new static;
    	if($value  = $self->getListFromDatabase()){

    		Cache::put($key,$value,3600);

    		return Cache::get($key);
    	}

    	return false;

    }


}
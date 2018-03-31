<?php

namespace LaraStore\Cache;

use Cache;
use LaraStore\Cache\Helper;

trait CacheCommon{


	/*
    |-------------------------------------------------------------------------------
    |
    | 通用的 从缓存中获取数据的函数
    |
    |-------------------------------------------------------------------------------
    */
    public static function getCacheData(Array $arr){

    	$helper 			=  new Helper();
    	$self 				=  new static;
    	$helper->key 		=  $arr['key'];
    	$helper->funcName 	=  $arr['funcName'];
    	$helper->time 		= 3600;
    	$helper->obj 		= $self;
    	$param 				= '';

    	if(isset($arr['param'])){

    		$param 			= $arr['param'];
    	}

    	if(isset($arr['obj'])){
    		$helper->obj 	= $arr['obj'];
    	}
    	return $helper->get($param);
    }
}
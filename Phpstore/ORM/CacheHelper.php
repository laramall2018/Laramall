<?php

namespace Phpstore\ORM;
use Cache;


class CacheHelper{

	public $key;
	public $value;
	public $time;
	public $obj;
	public $funcName;
	public $model;

	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(){

    	
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 设置对象
    |
    |-------------------------------------------------------------------------------
    */
    public function put($key,$value){

         $this->$key    = $value;
         return $this;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 公共缓存
    |
    |-------------------------------------------------------------------------------
    */
    public function get(){

    	if(Cache::has($this->key)){

    		return Cache::get($this->key);
    	}

    	if($value  = call_user_func(array($this->obj,$this->funcName))){

    		Cache::put($this->key,$value,$this->time);
    		return Cache::get($this->key);
    	}

    	return false;
    }
}
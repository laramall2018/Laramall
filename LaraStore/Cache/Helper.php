<?php

namespace LaraStore\Cache;
use Cache;


class Helper{

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

    	//
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 公共缓存
    |
    |-------------------------------------------------------------------------------
    */
    public function get($param){

    	if(Cache::has($this->key)){

    		return Cache::get($this->key);
    	}

    	if($value  = call_user_func(array($this->obj,$this->funcName),$param)){

    		Cache::put($this->key,$value,$this->time);
    		return Cache::get($this->key);
    	}

    	return false;
    }
}
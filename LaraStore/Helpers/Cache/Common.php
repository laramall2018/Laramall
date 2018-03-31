<?php

namespace LaraStore\Helpers\Cache;
use Cache;

class Common{

	protected $func;
	protected $method;
	protected $time;
	protected $key;
	protected $param;
	
    /*
    |-------------------------------------------------------------------------------
    |
    | 设置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function put($key,$value){
    	$this->$key 	= $value;
    	return $this;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回函数
    |
    |-------------------------------------------------------------------------------
    */
    public function handle(){

    	return (Cache::has($this->key))? Cache::get($this->key) : $this->get();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取函数
    |
    |-------------------------------------------------------------------------------
    */
    public function get(){

    	if($value = call_user_func([$this->func,$this->method],$this->param)){
    		Cache::put($this->key,$value,$this->time);
    		return Cache::get($this->key);
    	}
    	return false;
    }
}

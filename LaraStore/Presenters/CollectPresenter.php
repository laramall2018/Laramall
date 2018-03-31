<?php

namespace LaraStore\Presenters;

use App\Models\CollectGoods;
use Auth;

class CollectPresenter{

	protected $collect;
	/*
    |-------------------------------------------------------------------------------
    |
    |  构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(CollectGoods $collect){
    	$this->collect   = $collect;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取商品名称
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_name(){

    	return ($this->collect->goods)? $this->collect->goods->goods_name : false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取商品缩略图
    |
    |-------------------------------------------------------------------------------
    */
    public function thumb(){
    	return ($this->collect->goods)? $this->collect->goods->thumb() : false;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  魔术方法 获取
    |
    |-------------------------------------------------------------------------------
    */
    public function __get($property){

    	return (method_exists($this, $property))?  call_user_func([$this,$property]) : false;
    }
}
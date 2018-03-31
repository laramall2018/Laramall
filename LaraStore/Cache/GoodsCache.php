<?php

namespace LaraStore\Cache;
use App\Models\Goods;
use Cache;

class GoodsCache{

	protected $goods;
  	/*
  	|-------------------------------------------------------------------------------
  	|
  	|  构造函数
  	|
  	|-------------------------------------------------------------------------------
  	*/
  	public function __construct(Goods $goods){
  		$this->goods 	= $goods;
  	}

     

  	/*
  	|-------------------------------------------------------------------------------
  	|
  	|  获取分类名称
  	|
  	|-------------------------------------------------------------------------------
  	*/
  	public function cat_name(){

  		$key 				= 'get_cat_name_by_goods_id_is'.$this->goods->id;
  		return (Cache::has($key))? Cache::get($key) : $this->goods->getCatName();
  	}


  	/*
  	|-------------------------------------------------------------------------------
  	|
  	|  获取品牌名称
  	|
  	|-------------------------------------------------------------------------------
  	*/
  	public function brand_name(){
  		$key 			= 'get_brand_name_by_goods_id_is'.$this->goods->id;
  		return (Cache::has($key))? Cache::get($key) : $this->goods->getBrandName();
  	}


  	/*
  	|-------------------------------------------------------------------------------
  	|
  	|  获取商品相册
  	|
  	|-------------------------------------------------------------------------------
  	*/
  	public function gallery(){
  		$key 			= 'get_goods_gallery_list_by_goods_id_is'.$this->goods->id;
  		return (Cache::has($key))? Cache::get($key) : $this->goods->gallery()->get();
  	}
    


  	/*
  	|-------------------------------------------------------------------------------
  	|
  	|  魔术方法 绑定虚拟属性到对象
  	|
  	|-------------------------------------------------------------------------------
  	*/
  	public function __get($property){

  		return (method_exists($this, $property)) ? call_user_func([$this,$property]) : false;
  	}





}
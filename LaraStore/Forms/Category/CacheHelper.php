<?php

namespace LaraStore\Forms\Category;
use LaraStore\Helpers\Cache\Common;
use LaraStore\Forms\Category\GridPresenter;

class CacheHelper extends Common{

	protected $presenter;
	/*
    |-------------------------------------------------------------------------------
    |
    |   构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(GridPresenter $presenter){

    	$this->put('presenter',$presenter)
    		 ->put('time',3600)
    		 ->put('func',$this->presenter->grid())
    		 ->put('method','toArray');
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   获取商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function toArray(){

    	return $this->put('key',$this->getCacheKey())
    		        ->handle();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   获取商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function toJSON(){

    	return $this->toArray();
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   获取商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_list(){

    	return $this->put('key',$this->getCacheKey().'-object-goods-list')
    				->put('method','handle')
    		        ->handle();
    }


    /*
	|----------------------------------------------------------------------------
	|
	|  初始化cacheKey
	|
	|----------------------------------------------------------------------------
	*/ 
	public function getCacheKey(){

     $str   =  	  'get_category_page_goods_list_from_sort_key_is'
				  .'-'.$this->presenter->get('max')
				  .'-'.$this->presenter->get('min')
		 		  .'-'.$this->presenter->get('cat_id')
		 		  .'-'.$this->presenter->get('brand_id')
		 		  .'-'.$this->presenter->get('sort_name')
		 		  .'-'.$this->presenter->get('sort_value')
		 		  .'-'.$this->presenter->page()->get('current_page')
		 		  .'-'.$this->presenter->page()->get('last_page')
		 		  .'-'.$this->presenter->page()->get('per_page')
		 		  .'-'.$this->presenter->page()->get('total')
		 		  .'-'.$this->attr()
                  .'-'.$this->field();
	  return $str;
	}


	/*
	|----------------------------------------------------------------------------
	|
	|  把属性数组 转化成字符串
	|
	|----------------------------------------------------------------------------
	*/
	public function attr(){
		$arr 		= $this->presenter->get('goods_attr_ids');
		return (count($arr) > 0)? implode(",", $arr) : '';
	}

    /*
    |----------------------------------------------------------------------------
    |
    |  把规格数组 转化成字符串
    |
    |----------------------------------------------------------------------------
    */
    public function field(){
        $arr        = $this->presenter->get('goods_field_ids');
        return (count($arr) > 0)? implode(",", $arr) : '';
    }
}
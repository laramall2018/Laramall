<?php

namespace LaraStore\Helpers\Category;
use Cache;
use App\Models\Category;
use App\Models\Goods;
use LaraStore\Helpers\Cache\Common;

class CacheHelper extends Common{

	protected $category;
	/*
    |-------------------------------------------------------------------------------
    |
    | 价格区间
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Category $category){

    	 $this->put('category',$category)
    	 	  ->put('time',3600)
    	 	  ->put('param','')
    	 	  ->put('method','handle');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 价格区间
    |
    |-------------------------------------------------------------------------------
    */
    public function price(){

    	return $this->put('key','price_grade_list_by_cat_id_is_'.$this->category->id)
             		->put('func',$this->category->presenter()->price())
             		->put('method','grade')
             		->handle();
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 品牌列表
    |
    |-------------------------------------------------------------------------------
    */
    public function brand(){

    	return $this->put('key','brand_list_by_cat_id_is_'.$this->category->id)
    			    ->put('func',$this->category->presenter()->brand())
    			    ->handle();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_list(){
    	return $this->put('key','goods_list_by_cat_id_is_'.$this->category->id)
    				->put('func',$this->category->presenter()->goods())
    				->handle();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取父亲结点名称
    |
    |-------------------------------------------------------------------------------
    */
    public function father(){
    	return  $this->put('key','cat_id_parent_name_is_by_id_is_'.$this->category->id)
    				 ->put('func',$this->category->presenter())
    				 ->put('method','father')
    				 ->handle();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取子节点
    |
    |-------------------------------------------------------------------------------
    */
    public function children(){
    	return $this->put('key','children_parent_id_is_'.$this->category->id)
    				->put('func',$this->category->presenter())
    				->put('method','children')
    				->handle();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取分类下的属性-属性值结构
    |
    |-------------------------------------------------------------------------------
    */
    public function attr(){
        return $this->put('key','get_goods_attr_list_by_cat_id_is_'.$this->category->id)
                    ->put('func',$this->category->presenter()->attr())
                    ->handle();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取分类下的规格-商品规格值数据结构
    |
    |-------------------------------------------------------------------------------
    */
    public function field(){

        return $this->put('key','get_goods_field_list_by_cat_id_is_'.$this->category->id)
                    ->put('func',$this->category->presenter()->field())
                    ->handle();
    }

}
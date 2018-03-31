<?php

namespace LaraStore\Helpers\Category;
use App\Models\Goods;
use App\Models\Category;

class PriceList{

	protected $category;
	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Category $category){
    	$this->category 		= $category;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取该分类结点和其所有子节点组成的数组
    |
    |-------------------------------------------------------------------------------
    */
    public function ids(){

    	return $this->category->child_node_and_self_list();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取查询结果
    |
    |-------------------------------------------------------------------------------
    */
    public function queryByCatId(){

    	 if(count($this->ids()) > 1){
    	 	return Goods::whereIn('cat_id',$this->ids());
    	 }
    	 return Goods::where('cat_id',$this->category->id);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取结果最大值
    |
    |-------------------------------------------------------------------------------
    */
    public function priceMax(){

    	return $this->queryByCatId()->max('shop_price');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取最小值
    |
    |-------------------------------------------------------------------------------
    */
    public function priceMin(){
    	return $this->queryByCatId()->min('shop_price');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取skip值
    |
    |-------------------------------------------------------------------------------
    */
    public function skip(){

    	if($this->category->grade > 0){
    		return ceil(($this->priceMax() - $this->priceMin())/$this->category->grade);
    	}
    	return 0;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取价格区间数组
    |
    |-------------------------------------------------------------------------------
    */
    public function grade(){

    	return ($this->category->grade > 0)? $this->gradeList() : [];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取价格区间
    |
    |-------------------------------------------------------------------------------
    */
    public function gradeList(){

    	$arr 			= [];
    	$min 		    = $this->priceMin();
    	$max 			= $this->priceMax();
    	$grade 			= $this->category->grade;
    	$skip 			= $this->skip();

    	foreach(range(0,$grade-1) as $item){

    		$start		= intval($min);
    		$end 		= $start + intval($skip);

    		if($end > $max ){
    			$end 	= $max;
    		}
    		$arr[] 		= [
    			   'min'=>$min,
    			   'max'=>$end
    		];
    		$min 		= $min + $skip +1;		
    	}
    	return $arr;
    }




}
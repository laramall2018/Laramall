<?php

namespace LaraStore\Helpers\Category;
use DB;
use App\Models\Category;
use App\Models\Attribute as AttrModel;

class GoodsAttr{

	protected $category;
	protected $attr;
	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Category $category,AttrModel $attr){
    	$this->category 		= $category;
    	$this->attr 			= $attr;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回查询结果
    |
    |-------------------------------------------------------------------------------
    */
    public function handle(){
    	return $this->query();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 是否有子节点
    |
    |-------------------------------------------------------------------------------
    */
    public function hasChild(){
    	return (count($this->category->ids()) > 1)? true:false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 基础查询
    |
    |-------------------------------------------------------------------------------
    */
    public function baseQuery(){
    	return DB::table('goods_attr as ga')->leftjoin('goods as g','g.id','=','ga.goods_id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | catQuery;
    |
    |-------------------------------------------------------------------------------
    */
    public function catQuery(){
    	return ($this->hasChild())? $this->whereInQuery() : $this->whereQuery();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | wherein查询
    |
    |-------------------------------------------------------------------------------
    */
    public function whereInQuery(){
    	return $this->baseQuery()->whereIn('g.cat_id',$this->category->ids());
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | where查询
    |
    |-------------------------------------------------------------------------------
    */
    public function whereQuery(){
    	return $this->baseQuery()->where('g.cat_id',$this->category->id);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 拼接查询
    |
    |-------------------------------------------------------------------------------
    */
    public function query(){
    	return $this->catQuery()
    				->where('ga.attr_id',$this->attr->id)
    				->select('ga.*')
    				->orderBy('ga.sort_order','asc')
    				->groupBy('ga.attr_value')
    				->get();
    }

}
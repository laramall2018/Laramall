<?php

namespace LaraStore\Helpers\Category;
use App\Models\Field as FieldModel;
use App\Models\Category;
use DB;

class GoodsField{

	protected $category;
	protected $field;
	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function  __construct(Category $category , FieldModel $field){

    	$this->category  	= $category;
    	$this->field 		= $field;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回结果
    |
    |-------------------------------------------------------------------------------
    */
    public function handle(){

    	return $this->toArray();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  基础查询
    |
    |-------------------------------------------------------------------------------
    */
    public function baseQuery(){

    	return DB::table('goods_field as gf')
    			 ->leftjoin('goods as g','g.id','=','gf.goods_id')
    			 ->leftjoin('field as f','f.id','=','gf.field_id')
    			 ->whereIn('g.cat_id',$this->category->ids())
    			 ->where('f.id',$this->field->id)
    			 ->select('gf.id','gf.field_value')
    			 ->orderBy('gf.id')
    			 ->groupBy('gf.field_value')
    			 ->get();
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  检测是否有值
    |
    |-------------------------------------------------------------------------------
    */
    public function hasFieldValue(){

    	return (count($this->baseQuery()) > 0)? true :false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  转化成数组
    |
    |-------------------------------------------------------------------------------
    */
    public function toArray(){

    	return collect($this->baseQuery());
    }


}	
<?php

namespace LaraStore\Helpers\Category;
use App\Models\Category;
use DB;
use App\Models\Field as FieldModel;
use LaraStore\Helpers\Category\GoodsField;

class Field{

	protected $category;
	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function  __construct(Category $category){

    	$this->category  	= $category;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回结果
    |
    |-------------------------------------------------------------------------------
    */
    public function handle(){

    	return $this->toArray();
    }




    /*
    |-------------------------------------------------------------------------------
    |
    | 基础查询  获取商品分类下的规格名称列表
    |
    |-------------------------------------------------------------------------------
    */
    public function baseQuery(){

    	return DB::table('field as f')
    			 ->leftjoin('goods_field as gf','gf.field_id','=','f.id')
    			 ->leftjoin('goods as g','g.id','=','gf.goods_id')
    			 ->whereIn('g.cat_id',$this->category->ids())
    			 ->select('f.id','f.field_name')
    			 ->groupBy('f.id')
    			 ->get();
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 是否拥有规格名称数组值
    |
    |-------------------------------------------------------------------------------
    */
    public function hasField(){

    	return (count($this->baseQuery) > 0 )? true:false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 把结果转化成数组形式
    |
    |-------------------------------------------------------------------------------
    */
    public function toArray(){

    	$arr 		= [];
    	foreach($this->baseQuery() as $field){

    		$arr[]	= [
    				'id'			=>$field->id,
    				'field_name'	=>$field->field_name,
    				'field_value'	=> $this->goodsField($this->getModel($field->id))->handle(),
    		];
    	}

    	return $arr;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取规格名称模型
    |
    |-------------------------------------------------------------------------------
    */
    public function getModel($id){

    	return  FieldModel::find($id);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取商品规格值帮助函数
    |
    |-------------------------------------------------------------------------------
    */
    public function goodsField($field){

    	return new GoodsField($this->category, $field);
    }


}
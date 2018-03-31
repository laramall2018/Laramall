<?php

namespace LaraStore\Repository\GoodsField;

trait BaseRepository{

	/*
    |-------------------------------------------------------------------------------
    |
    | 根据商品规格值编号数组 返回值
    |
    |-------------------------------------------------------------------------------
    */
    public static function getList($ids){

    	return  collect($ids)->map(function($item,$key){

    		return  ($model = (new static)->find($item))? $model->getRow() : '';

    	});
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回商品规格模型的数组值
    |
    |-------------------------------------------------------------------------------
    */
    public function getRow(){

    	return [
    				'field_name'	=> $this->field->field_name,
    				'field_value'	=> $this->field_value,
    				'id'			=> $this->id,
    	];
    }

}
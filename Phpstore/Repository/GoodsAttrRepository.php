<?php

namespace Phpstore\Repository;
use Cache;

trait GoodsAttrRepository{

	/*
    |-------------------------------------------------------------------------------
    |
    | 根据编号数组 获取一组属性值
    |
    |-------------------------------------------------------------------------------
    */
    public static function getListFromDatabase($ids){

    	$self 			=  new static;
    	$row			= [];
    	foreach($ids as $id){

    		$row[] 		= $self->find($id);
    	}
    	return $row;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 根据编号数组获取属性
    |
    |-------------------------------------------------------------------------------
    */
    public static function getList($ids){

    	$key 		= 'get_goods_attr_list_by_goods_attr_ids_array_is_'.implode('-',$ids);
    	$self 		= new static;

    	if(Cache::has($key)){
    		return Cache::get($key);
    	}
    	if($value = $self->getListFromDatabase($ids)){
    		Cache::put($key,$value,3600);
    		return Cache::get($key);
    	}
    	return false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取属性数组值
    |
    |-------------------------------------------------------------------------------
    */
    public static function getValueList($ids){

        /*
    	$self 			= new static;
    	$row 			= [];
    	foreach($ids as $id){
    		$model 		= $self->find($id);
    		if($model){
    			$row[]  = $model->attr_value;
    		}
    	}
    	//返回属性值数组
    	return $row;
        */

        return collect($ids)->map(function($item,$key){

                return  ($model = (new static)->find($item))? $model->attr_value :'';
        });

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取商品属性值字符串
    |
    |-------------------------------------------------------------------------------
    */
    public static function getValueString($ids){

        $self                   = new static;
        $str                    = '';
        $attrs                  = $self->getList($ids);
        if(!$attrs){
            return $str;
        }
        foreach($attrs as $attr){

            $str               .= $attr->attr_value.' ';
        }
        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取属性名称
    |
    |-------------------------------------------------------------------------------
    */
    public function getAttrNameAttribute(){

    	$key 			= $this->table.'_get_attr_name_by_id_is_'.$this->id;
    	if(Cache::has($key)){
    		return Cache::get($key);
    	}

    	if($value = $this->attribute->attr_name){
    		Cache::put($key,$value,3600);
    		return Cache::get($key);
    	}
    	return false;
    }
}
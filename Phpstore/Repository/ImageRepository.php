<?php

namespace Phpstore\Repository;
use Cache;

trait ImageRepository{

	/*
    |-------------------------------------------------------------------------------
    |
    | 根据图片的标签获取图片
    |
    |-------------------------------------------------------------------------------
    */
    public static function getValue($tag){
    	$self 		= new static;
    	$key 		= $self->table.'_'.$tag;

    	if(Cache::has($key)){

    		return Cache::get($key);
    	}

    	if($value  = $self->getValueFromDatabase($tag)){

    		Cache::put($key,$value,3600);
    		return Cache::get($key);
    	}
    	return false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 从数据库中获取记录
    |
    |-------------------------------------------------------------------------------
    */
    public static function getValueFromDatabase($tag){

    	$self 			= new static;
    	return ($value = $self->where('img_tag',$tag)->first()) ? $value : false;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  获取 imgOss属性
    |
    |-------------------------------------------------------------------------------
    */
    public function getImgOssAttribute(){

        return $this->icon();
    }
}
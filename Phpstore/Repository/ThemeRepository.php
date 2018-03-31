<?php

namespace Phpstore\Repository;
use Cache;

trait ThemeRepository{


	/*
    |-------------------------------------------------------------------------------
    |
    |  获取系统所有模板列表
    |
    |-------------------------------------------------------------------------------
    */
    public static function getList($type){

    	$key 			= 'theme_list_type_is_'.$type;
    	$self 		    = new static;
    	return  (Cache::has($key))? Cache::get($key) : $self->getFromDatabase($type);

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  从数据库中获取
    |
    |-------------------------------------------------------------------------------
    */
    public static function getFromDatabase($type){

    	$self 			= new static;
    	$key 			= 'theme_list_type_is_'.$type;
    	if($row = $self->where('type',$type)->get()){

    		 Cache::put($key,$row,3600);
    		 return Cache::get($key);
    	}
    	return false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取图片路径
    |
    |-------------------------------------------------------------------------------
    */
    public function getCover(){

    	$key 			= 'theme_cover_is_'.$this->name;
    	return (Cache::has($key))? Cache::get($key) : $this->getCoverFromDatabase();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  从数据库中获取图片路径
    |
    |-------------------------------------------------------------------------------
    */
    public function getCoverFromDatabase(){

    	$str 		= url('front/'.$this->name.'/images/cover.png');
    	$key 		= 'theme_cover_is_'.$this->name;
    	Cache::put($key,$str,3600);
    	return Cache::get($key);

    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  输入ajax数据
    |
    |-------------------------------------------------------------------------------
    */
    public static function getJSON($type){

        $self           =  new static;
        $data           = [];

        foreach($self->getList($type) as $item){

            $data[]     = [
                                'id'                =>$item->id,
                                'name'              =>$item->name,
                                'is_checked'        =>$item->is_checked,
                                'type'              =>$item->type,
                                'cover'             =>$item->getCover(),
            ];
        }

        return $data;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  取消所有pc版本模板激活状态
    |
    |-------------------------------------------------------------------------------
    */
    public static function cancelAllChecked(){

        $self               = new static;
        foreach($self->where('type','pc')->get() as $item){

            $item->is_checked = 0;
            $item->save();
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  激活当前模板
    |
    |-------------------------------------------------------------------------------
    */
    public function checked(){

        $self                   =  new static;
        $self->cancelAllChecked();
        $this->is_checked       = 1;
        $this->save();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取pc版本当前模板名称
    |
    |-------------------------------------------------------------------------------
    */
    public static function pc(){

        $self               = new static;
        $key                = 'default_pc_theme_is';
        if(Cache::has($key)){

            return Cache::get($key);
        }
        $row                = $self->where('type','pc')->where('is_checked',1)->first();
        $pc_theme_name      = ($row)? $row->name :'matrix';
        Cache::put($key,$pc_theme_name,3600);
        return Cache::get($key);
    }


}
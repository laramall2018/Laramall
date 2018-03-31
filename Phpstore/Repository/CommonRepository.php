<?php

namespace Phpstore\Repository;
use Config;
use Cache;
trait CommonRepository{


	  /*
  	|-------------------------------------------------------------------------------
  	|
  	| 使用trait 让模型User 拥有业务逻辑所需的方法
  	| 获取用户上传的头像
  	|
  	|-------------------------------------------------------------------------------
  	*/
  	public function icon(){
      	
      	$icon_field 			= $this->icon_field();
      	//没上传头像直接返回
  	  	if(empty($this->$icon_field)){

  	  	 	return false;

  	  	}
  	  	//获取filesystems的存储介质
  	  	$config 			= Config::get('filesystems.default');
  	  	//key:vlaue值
  	  	$arr 				= [
  	  						 	'oss' 		=> env('ALIOSS_BASEURL').$this->$icon_field,
  	  						 	'local'		=> url($this->$icon_field),
  	  	];
  	  	//返回相应的值
  	  	return  (in_array($config,['oss','local'])) ? $arr[$config] : false;
  	}

  

  /*
  |-------------------------------------------------------------------------------
  |
  |  使用缓存包装获取模型
  |
  |-------------------------------------------------------------------------------
  */
  public static function getModel($id){

       $self        = new static;
       $key         = 'get_model_from_table_'.$self->table.'_by_id_'.$id;
       if(Cache::has($key)){

          return Cache::get($key);
       }

       if($model    = $self->find($id)){

            Cache::put($key,$model,3600);
            return Cache::get($key);
       }
       return false;
  }


  /*
  |-------------------------------------------------------------------------------
  |
  |  返回数据表名称
  |
  |-------------------------------------------------------------------------------
  */
  public static function getTableName(){

       $self      =   new static;
       return $self->table;
  }

}
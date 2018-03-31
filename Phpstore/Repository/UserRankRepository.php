<?php

namespace Phpstore\Repository;
use Config;

trait UserRankRepository{


	/*
  	|-------------------------------------------------------------------------------
  	|
  	| 使用trait 让模型User 拥有业务逻辑所需的方法
  	| 获取用户上传的头像
  	|
  	|-------------------------------------------------------------------------------
  	*/
  	public function icon(){
      
      	//没上传头像直接返回
  	  	if(empty($this->rank_pic)){

  	  	 	return false;

  	  	}
  	  	//获取filesystems的存储介质
  	  	$config 			= Config::get('filesystems.default');
  	  	//key:vlaue值
  	  	$arr 				= [
  	  						 	'oss' 		=> env('ALIOSS_BASEURL').$this->rank_pic,
  	  						 	'local'		=> url($this->rank_pic),
  	  	];
  	  	//返回相应的值
  	  	return  (in_array($config,['oss','local'])) ? $arr[$config] : false;
  	}
}
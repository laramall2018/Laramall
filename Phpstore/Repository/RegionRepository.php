<?php 

namespace Phpstore\Repository;

trait RegionRepository{


  /*
  |-------------------------------------------------------------------------------
  |
  | 使用trait 让模型Region 拥有业务逻辑所需的方法
  | 获取地区下拉选项
  |
  |-------------------------------------------------------------------------------
  */
  public static function option_list(){

  		$str 		= '';
  		$instance 	= new static;

  		foreach($instance->where('region_type',1)->get() as $item){

  			$str .= '<option value="'.$item->region_id.'">'.$item->region_name.'</option>';
  		}

  		return $str;
  }


  /*
  |-------------------------------------------------------------------------------
  |
  | 获取第一个省的所有城市列表
  |
  |-------------------------------------------------------------------------------
  */
  public static function childList($parent_id,$region_type){

      $self         = new static;
      return  $self->where('parent_id',$parent_id)->where('region_type',$region_type)->get();
  }


}
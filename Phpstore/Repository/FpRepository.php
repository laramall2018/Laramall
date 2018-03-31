<?php

namespace Phpstore\Repository;
use Auth;

trait FpRepository{

	/*
    |-------------------------------------------------------------------------------
    |
    | 创建发票信息
    |
    |-------------------------------------------------------------------------------
    */
    public static function makeItem($arr){

    	 if(!Auth::check('user')){
    	 	return false;
    	 }

    	 $self 				= new static;
    	 $model 			= $self->create([

    	 							'fp_title'	=>$arr['fp_title'],
    	 							'fp_type'	=>$arr['fp_type'],
    	 							'order_id'	=>$arr['order_id'],
     	 ]);

    	 return (empty($model))? false : $model;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取发票内容
    |
    |-------------------------------------------------------------------------------
    */
    public function getFpGoodsContentAttribute(){

    	 $str      = '';
         foreach($this->order->order_goods()->get() as $item){
            $str   .= $item->goods_name.' ';
         }
         return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取发票的类型
    |
    |-------------------------------------------------------------------------------
    */
    public function getFpTypeNameAttribute(){
        $arr        = ['电子发票','纸质发票'];
        return (in_array($this->fp_type,[0,1]))? $arr[$this->fp_type] : $arr[0];
    }
}
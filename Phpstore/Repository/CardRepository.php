<?php

namespace Phpstore\Repository;

trait  CardRepository{

	/*
    |-------------------------------------------------------------------------------
    |
    | 礼品卡相关函数
    |
    |-------------------------------------------------------------------------------
    */
    public function timeFormat(){

    	$this->add_time 		= strtotime(request()->add_time);
    	$this->end_time 		= strtotime(request()->end_time);
    	$this->save();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 日期转化
    |
    |-------------------------------------------------------------------------------
    */
    public function add_date(){

    	return date('Y-m-d',$this->add_time);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 日期转化
    |
    |-------------------------------------------------------------------------------
    */
    public function end_date(){

    	return date('Y-m-d',$this->end_time);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 通过card_sn 获取card
    |
    |-------------------------------------------------------------------------------
    */
    public static function searchBy($card_sn){

    	$self 						= new static;
    	return ($model = $self->where('card_sn',$card_sn)->first()) ? $model : false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 设置礼品卡的状态
    |
    |-------------------------------------------------------------------------------
    */
    public static function setTag($card_id,$tag){

        if($card_id == 0){
            return false;
        }
        $self                       = new static;
        $card                       = $self->find($card_id);
        if(empty($card)){
            return false;
        }

        $card->tag                  = $tag;
        $card->save();
        return true;
    }
    
}
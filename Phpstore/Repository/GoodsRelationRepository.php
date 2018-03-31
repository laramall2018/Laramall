<?php

namespace Phpstore\Repository;
use App\Models\Goods;

trait GoodsRelationRepository{

	/*
    |-------------------------------------------------------------------------------
    |
    | 关联商品的trait类
    |
    |-------------------------------------------------------------------------------
    */
    public static function allowRelation($goods_id,$relation_goods_id){

    		$self  			= new static;

    		if($relation_goods_id == 0){

    			return false;
    		}

    		$relation_model 	= Goods::find($relation_goods_id);
    		
    		if(empty($relation_model)){

    			return false;
    		}

    		if($self->where('goods_id',$goods_id)->where('relation_goods_id',$relation_goods_id)->first()){

    			return false;
    		}

    		if($goods_id == $relation_goods_id){

    			return false;
    		}

    		return true;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取被关联商品的信息
    |
    |-------------------------------------------------------------------------------
    */
    public function toGoods(){

    	return Goods::find($this->relation_goods_id);
    }
}
<?php

namespace Phpstore\Repository;
use App\Models\Goods;
use App\Models\Article;

trait GoodsArticleRepository{


	/*
    |-------------------------------------------------------------------------------
    |
    | 是否允许插入 商品新闻关联记录
    |
    |-------------------------------------------------------------------------------
    */
    public static function allowRelation($goods_id ,$article_id){

    	  if($goods_id == 0 || $article_id == 0){

    	  	 return false;
    	  }

    	  $self 			= new static;
    	  $goods 			= Goods::find($goods_id);
    	  $article 			= Article::find($article_id);

    	  if(empty($goods) || empty($article)){

    	  	 return false;
    	  }

    	  //记录是否存在
    	  $model 			= $self->where('goods_id',$goods_id)
    	  						   ->where('article_id',$article_id)
    	  					       ->first();

    	  
    	  if($model){
				
				return false;
    	  }
    	  
    	  return true;
    }

    
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\GoodsArticleRepository;

class GoodsArticle extends Model
{
	use GoodsArticleRepository;
    protected $table  			= 'goods_article';

    //自动填充字段
    protected $fillable 		= ['goods_id','article_id'];



    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系  一个商品关联新闻记录 属于具体某个商品
    |
    |-------------------------------------------------------------------------------
    */
    public function goods(){

    	return $this->belongsTo(Goods::class,'goods_id','id');
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系  一个商品关联新闻记录 属于具体某个新闻
    |
    |-------------------------------------------------------------------------------
    */
    public function article(){

    	return $this->belongsTo(Article::class,'article_id','id');
    }
}

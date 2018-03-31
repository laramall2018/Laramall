<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\CommonRepository;
use Phpstore\Repository\ArticleRepository;

class Article extends Model{

    use CommonRepository,ArticleRepository;
	protected $table = 'article';


	/*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个新闻分类下 可以有多个新闻
    |
    |-------------------------------------------------------------------------------
    */
	public function cat(){

		// 第一个编号 为本模型对应的编号 第二个为关联的模型对应的编号
		return $this->belongsTo(ArticleCat::class,'cat_id','id');
	}


	

    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个新闻 可以有多个关联商品记录
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_article(){

        return $this->hasMany(GoodsArticle::class,'article_id','id');
    }


}
<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\CommonRepository;
use Phpstore\Repository\ArticleCatRepository;

class ArticleCat extends Model{

	use CommonRepository,ArticleCatRepository;
	protected $table = 'article_cat';


	/*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 获取新闻分类下的新闻列表
    |
    |-------------------------------------------------------------------------------
    */
    public function article(){

    	//第一个编号为关联模型对应的编号 第二个为本模型对应的编号
    	return $this->hasMany(Article::class,'cat_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取新闻分类的url
    |
    |-------------------------------------------------------------------------------
    */
    public function url(){

    	if($this->diy_url){

    		return url('article_cat/'.$this->diy_url);
    	}

    	return url('article_cat/'.$this->id);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回分类图标字段
    |
    |-------------------------------------------------------------------------------
    */
    public function icon_field(){

        return 'cat_pic';
    }

}
<?php

namespace LaraStore\Presenters;
use App\Models\Article;

class ArticlePresenter{

	use PresenterTrait;
	protected $article;

	/*
    |-------------------------------------------------------------------------------
    |
    |  构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Article $article){
    	$this->article  	= $article;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取上一篇新闻
    |
    |-------------------------------------------------------------------------------
    */
    public function pre(){
    	return Article::where('id','<',$this->article->id)->orderBy('id','asc')->first();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取下一篇新闻
    |
    |-------------------------------------------------------------------------------
    */
    public function next(){
    	return Article::where('id','>',$this->article->id)->orderBy('id','asc')->first();
    }



}
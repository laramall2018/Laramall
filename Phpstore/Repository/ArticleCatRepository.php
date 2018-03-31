<?php

namespace Phpstore\Repository;
use Cache;

trait ArticleCatRepository{

	/*
    |-------------------------------------------------------------------------------
    |
    |  获取帮助列表
    |
    |-------------------------------------------------------------------------------
    */
    public static function getHelpList(){

    	$key 				= 'article_cat_help_list';
    	$self 				= new static;
    	if(Cache::has($key)){

    		return Cache::get($key);
    	}

    	$value 				= $self->where('is_help',1)
    							   ->take(5)
    							   ->orderBy('sort_order','asc')
    							   ->get();
    	Cache::put($key,$value,3600);
    	return Cache::get($key);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取分类下的新闻
    |
    |-------------------------------------------------------------------------------
    */
    public function getArticle(){

    	$key 			= 'get_cat_article_list_by_id_is_'.$this->id;
    	if(Cache::has($key)){

    		return Cache::get($key);
    	}

    	$value 			= $this->article()->get();
    	Cache::put($key,$value,3600);
    	return Cache::get($key);
    }
}
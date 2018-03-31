<?php

namespace Phpstore\Repository;
use LaraStore\Presenters\ArticlePresenter;

trait ArticleRepository{

	/*
    |-------------------------------------------------------------------------------
    |
    | 根据新闻分类 和关键词 搜索新闻列表
    |
    |-------------------------------------------------------------------------------
    */
    public static function searchList($cat_id,$keywords){

    	$self				= new static;
    	$query 				= $self;

    	//如果有分类搜索
    	if($cat_id > 0){

    		$query 			= $query->where('cat_id',$cat_id);
    	}
    	//有关键词搜索
    	if($keywords){

    		$query 		    = $query->where('title','like','%'.$keywords.'%');
    	}

    		$query 			= $query->take(20)->get();

    	return $query;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取新闻的url
    |
    |-------------------------------------------------------------------------------
    */
    public function url(){

        if($this->diy_url){

            return url('article/'.$this->diy_url);
        }

        return url('article/'.$this->id);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取新闻的添加时间
    |
    |-------------------------------------------------------------------------------
    */
    public function time(){

        return date('Y-m-d',$this->add_time);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 上一篇新闻
    |
    |-------------------------------------------------------------------------------
    */
    public function pre(){

        $row            = Article::where('id','<',$this->id)
                                 ->orderBy('id','asc')
                                 ->first();
        return $row;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 下一篇新闻
    |
    |-------------------------------------------------------------------------------
    */
    public function next(){

        $row            = Article::where('id','>',$this->id)
                                 ->orderBy('id','asc')
                                 ->first();
        return $row;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 设置mapping
    |
    |-------------------------------------------------------------------------------
    */
    protected $mappingProperties = array(

                    'title'         => array(
                    'type'          => 'string',
                    'analyzer'      => 'standard'
                    )
    );


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回图片的字段
    |
    |-------------------------------------------------------------------------------
    */
    public function icon_field(){

        return  'thumb';
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取 option_list
    |
    |-------------------------------------------------------------------------------
    */
    public static function option_list(){

        $str            = '';
        $article_list   = (new static)::take(200)->get();
        foreach($article_list as $article){

            $str       .='<option value="'.$article->id.'">'.$article->title.'</option>';
        }
        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 设置 presenter
    |
    |-------------------------------------------------------------------------------
    */
    public function presenter(){
        return new ArticlePresenter($this);
    }


    
}
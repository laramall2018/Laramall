<?php

namespace Phpstore\Repository;
use Cache;

trait StyleModelRepository{


	/*
    |-------------------------------------------------------------------------------
    |
    |  从数据库中获取记录
    |
    |-------------------------------------------------------------------------------
    */
    public static function getListFromDatabase(){

    	$self 					= new static;
    	$res            		= $self->orderBy('sort_order','asc')->get();
        $str            		= '';

        if(empty($res)){

            return $str;
        }

        foreach($res as $item){

            $style_css_file     = url('front/matrix/'.$item->style_css_file);

            $str     		   .= '<div class="color-grid-item">'
                       		     .'<span data-style_css_file="'
                       		     .$style_css_file
                       		     .'" class="color-item-span" style="background:'.$item->style_value.'">'
                       		     .'<i class="fa fa-check"></i>'
                       		     .'</span>'
                       		     .'</div>';
        }

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  从缓存中获取记录
    |
    |-------------------------------------------------------------------------------
    */
    public static function getList(){

    	$self 				= new static;
    	$key  				= 'style_list';
    	if(Cache::has($key)){

    		return Cache::get($key);
    	}

    	if($value  = $self->getListFromDatabase()){

    		Cache::put($key,$value,3600);
    		return Cache::get($key);
    	}

    	return false;
    }
}
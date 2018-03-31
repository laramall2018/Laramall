<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\CommonRepository;
use LaraStore\Repository\Nav\BaseRepository;
use LaraStore\Crud\Nav\MakeFormTrait;
use Cache;

class Nav extends Model{

	use CommonRepository,BaseRepository,MakeFormTrait;
	protected $table = 'nav';
    protected $fillable  = [
    
        'nav_name','nav_url','link','position','sort_order','opennew','is_show','nav_type','note'
    ];


	/*
    |-------------------------------------------------------------------------------
    |
    |  获取导航栏的实际链接
    |
    |-------------------------------------------------------------------------------
    */
    public function url(){

    	if($this->link){

    		return $this->link;
    	}

    	return url($this->nav_url);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取导航栏信息
    |
    |-------------------------------------------------------------------------------
    */
    public static function nav_list($position){

    	return Nav::where('position',$position)
                  ->where('is_show',1)
    			  ->where('sort_order','desc')
    			  ->get();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  从缓存中获取
    |
    |-------------------------------------------------------------------------------
    */
    public static function getList($position){

        $key                    = 'nav_'.$position;
        if(Cache::has($key)){

            return Cache::get($key);
        }
        $self                   = new static;
        if($value   = $self->nav_list($position)){

            Cache::put($key,$value,3600);
            return Cache::get($key);
        }

        return false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回图片链接
    |
    |-------------------------------------------------------------------------------
    */
    public function icon_field(){

        return 'nav_pic';
    }

}
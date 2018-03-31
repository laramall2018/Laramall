<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LaraStore\Presenters\CollectPresenter;

class CollectGoods extends Model{

	
	protected $table 			= 'collect_goods';
	protected $fillable 		= ['user_id','goods_id','add_time'];
    protected $appends          = ['goodsName','thumb','createTime','goodsUrl'];


	/*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个商品 会有多个收藏记录
    |
    |-------------------------------------------------------------------------------
    */
    public function goods(){

    	return $this->belongsTo(Goods::class,'goods_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个用户 会有多个收藏记录
    |
    |-------------------------------------------------------------------------------
    */
    public function user(){

    	return $this->belongsTo('App\User','user_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | presenter
    |
    |-------------------------------------------------------------------------------
    */
    public function presenter(){
        return new CollectPresenter($this);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回商品名称
    |
    |-------------------------------------------------------------------------------
    */
    public function getGoodsNameAttribute(){
        return $this->presenter()->goods_name;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回商品图片
    |
    |-------------------------------------------------------------------------------
    */
    public function getThumbAttribute(){
        return $this->presenter()->thumb();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  添加的时间
    |
    |-------------------------------------------------------------------------------
    */
    public function getCreateTimeAttribute(){
        return $this->time();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取链接
    |
    |-------------------------------------------------------------------------------
    */
    public function getGoodsUrlAttribute(){
        return ($this->goods)? $this->goods->url() : false;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 返回添加的时间
    |
    |-------------------------------------------------------------------------------
    */
    public function time(){

        return date('Y-m-d',$this->add_time);
    }

}
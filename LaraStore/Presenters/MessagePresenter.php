<?php

namespace LaraStore\Presenters;
use App\Models\Message;
use Auth;
use App\User;
use LaraStore\Presenters\PresenterTrait;

class MessagePresenter{
    use PresenterTrait;
	protected $message;
	/*
    |-------------------------------------------------------------------------------
    |
    |  构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Message $message){
    	
    	$this->message 	= $message;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  是否有回复
    |
    |-------------------------------------------------------------------------------
    */
    public function hasReply(){

    	return  (empty($this->message->reply))? '没有回复' :'有回复';
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  创建时间
    |
    |-------------------------------------------------------------------------------
    */
    public function createTime(){
    	return date('Y-m-d',$this->message->add_time);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  回复时间
    |
    |-------------------------------------------------------------------------------
    */
    public function replyTime(){

    	return ($this->message->reply_time > 0)? date('Y-m-d',$this->message->reply_time) : '';
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  output rank star html dom string
    |
    |-------------------------------------------------------------------------------
    */
    public function rankStar(){

        $strx           = '<i class="fa fa-star star"></i>';
        $stry           = '<i class="fa fa-star-o star"></i>';
    	$x 			    = str_repeat($strx,$this->message->rank);
        $y              = str_repeat($stry,(5 - $this->message->rank));
    	return $x.$y;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  output i html dom with class name
    |
    |-------------------------------------------------------------------------------
    */
    public function makeHtmlWithI($class){

    	return '<i class="fa star '.$class.'"><i>';
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取用户
    |
    |-------------------------------------------------------------------------------
    */
    public function user(){
        return User::where('username',$this->message->username)->first();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  商品名称
    |
    |-------------------------------------------------------------------------------
    */
    public function goods(){

        $arr            = [];
        if($this->message->goods){

            $arr['goods_name']      = $this->message->goods->goods_name;
            $arr['url']             = $this->message->goods->url();
        }
        return $arr;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取商品信息
    |
    |-------------------------------------------------------------------------------
    */
    public function goodsInfo(){

        $goods      = $this->goods();
        if(count($goods) > 0){

            return  '<a href="'.$goods['url'].'">'.$goods['goods_name'].'</a>';
        }
        return '';
    }
}
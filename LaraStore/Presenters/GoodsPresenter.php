<?php

namespace LaraStore\Presenters;
use App\Models\Goods;
use App\Models\Message;

class GoodsPresenter{

	use PresenterTrait;
	protected $goods;
	/*
    |-------------------------------------------------------------------------------
    |
    |  构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Goods $goods){
    	$this->goods 	= $goods;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取商品的相册列表
    |
    |-------------------------------------------------------------------------------
    */
    public function gallerys(){

    	return (count($this->goods->gallery()->get()) > 0)? $this->gallerysToArray() : [];
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  相册数据转化为数组
    |
    |-------------------------------------------------------------------------------
    */
    public function gallerysToArray(){
    	$arr 		= [];
    	foreach($this->goods->gallery()->get() as $gallery){
    		$arr[]	=[

    			'thumbOss'		=>$gallery->image()->thumb,
    			'thumb'	  		=>$gallery->image()->thumb,
    			'img'	  		=>$gallery->image()->img,
    			'original'		=>$gallery->image()->originalImg,
    		];
    	}

    	return $arr;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取商品的所有属性值数组
    |
    |-------------------------------------------------------------------------------
    */
    public function attr_value(){

        $arr        = [];
        if(count($this->goods->attr()->get()) == 0){

            return $arr;
        }

        foreach($this->goods->attr()->get() as $item){

            $arr[]          = $item->attr_value;
        }

        return $arr;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  是否有评价
    |
    |-------------------------------------------------------------------------------
    */
    public function hasComment(){

        return  (count($this->goods->comment()->get()) > 0 ) ? true:false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取商品的评价列表
    |
    |-------------------------------------------------------------------------------
    */
    public function comment(){

        return ($this->hasComment())? $this->getComment() : [];

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取商品的评价列表
    |
    |-------------------------------------------------------------------------------
    */
    public function getComment(){

        $arr            = [];
        foreach($this->goods->comment()->where('status',1)->get() as $item){

            $message    = Message::find($item->id);

            $arr[]      = [
                                'id'        => $message->id,
                                'type'      => $message->type,
                                'email'     => $message->email,
                                'username'  => $message->username,
                                'content'   => $message->content,
                                'rank'      => $message->presenter()->rankStar(),
                                'createTime'=> $message->presenter()->createTime(),
                                'front_ip'  => $message->front_ip,
                                'reply'     => $message->reply,
                                'replyTime' => $message->presenter()->replyTime(),
                                'admin'     => $message->admin,
                                'userIcon'  => $message->user()->icon(),
                                'hasReply'  => $message->presenter()->hasReply(),
                                'goods'     => $message->presenter()->goods(),
            ];
        }

        return $arr;
    }

}
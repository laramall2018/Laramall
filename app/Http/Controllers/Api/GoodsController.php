<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Goods;
use App\Models\GoodsAttr;
use App\Models\Cart;
use App\User;
use Auth;
use Response;

class GoodsController extends ApiController
{
    
    public $tag;
    public $info;
    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(){

        $this->tag          = 'success';
        $this->info         = 'success';
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 返回商品详情页需要的信息
    |
    |-------------------------------------------------------------------------------
    */
    public function index($id){

        return  $this->toJSON($id);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回商品详情页需要的信息
    |
    |-------------------------------------------------------------------------------
    */
    public function toJSON($id){

        $goods                      = Goods::getModel($id);
        $tag                        = $this->tag;
        $info                       = $this->info;

        if(empty($goods)){

            $tag                    = 'error';
            $info                   = '商品模型不存在';
            return $this->respondNotFound($info);
        }

        $attr_list                 = $goods->attr_list();
        return $this->respond(['data'=>compact('tag','info','attr_list')]);
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  获取商品属性值列表
    |
    |-------------------------------------------------------------------------------
    */
    public function getGoodsAttrList(){

        $ids                        = request()->ids;
        $ids                        = json_decode($ids);   
        $tag                        = $this->tag;
        $info                       = $this->info;
        $goods_attr_values          = GoodsAttr::getList($ids);

        return $this->respond(['data'=>compact('tag','info','goods_attr_values')]);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  加入购物车
    |
    |-------------------------------------------------------------------------------
    */
    public function addToCart(){

        $param                          = request()->param;
        $param                          = json_decode($param);
        //获取参数
        $id                             = $param->goods_id;
        $goods_number                   = $param->goods_number;
        $goods_attr_ids                 = $param->goods_attr_ids;
        $tag                            = $this->tag;
        $info                           = '添加成功';

        if(!Auth::check('user')){

            $tag                        = 'error';
            $info                       = '请登录后再购物';
            return compact('tag','info');
        }

        $goods                          = Goods::find($id);
        if(empty($goods)){
            $tag                        = 'error';
            $info                       = '异常,模型不存在';
            return compact('tag','info');
        }

        //加入购物车
        $goods_attr_string              = GoodsAttr::getValueString($goods_attr_ids);
        $goods->buy($goods_attr_string,$goods_number);

        //获取购物车中的信息
        $user                           = Auth::user('user');
        $cart_list                      = $user->ajax_cart_list();
        $cart_checked_amount            = $user->amount();
        $cart_all_amount                = Cart::amountAll();
        $cart_checked_number            = $user->number();
        $cart_all_number                = $user->allNumber();
        $is_all_checked                 = $user->isAllChecked();
        //返回数据
        $arr                            = [
                                            'tag',
                                            'info',
                                            'cart_list',
                                            'cart_checked_amount',
                                            'cart_all_amount',
                                            'cart_checed_number',
                                            'cart_all_number',
                                            'is_all_checked',
        ];
        return compact($arr);
    }


}

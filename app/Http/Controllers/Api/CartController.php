<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Goods;
use App\Models\Cart;
use App\User;
use Artisan;
use Auth;
use App\Models\Image;
use Cache;

class CartController extends ApiController
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
    | 获取首页热卖商品 促销商品  新品 精品商品信息
    |
    |-------------------------------------------------------------------------------
    */
    public function getJson(){

        return  $this->toJSON();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回所有的记录
    |
    |-------------------------------------------------------------------------------
    */
    public function toJSON(){

        $tag                            = $this->tag;
        $info                           = $this->info;
        $cart_all_number                = Cart::number();
        $cart_list                      = [];
        if(!Auth::check('user')){

            $arr                        = ['tag','info','cart_all_number','cart_list'];
            $data                       = ['data'=>compact($arr)];
            return $this->respond($data);
        }

        //如果用户登录了
        $user                           = Auth::user('user');
        $cart_list                      = $user->ajax_cart_list();
        $cart_checked_amount            = $user->amount();
        $cart_all_amount                = Cart::amountAll();
        $cart_checked_number            = $user->number();
        $cart_all_number                = $user->allNumber();
        $is_all_checked                 = $user->isAllChecked();
        $card_list                      = $user->giftCardList();

        $arr                            =[ 
                                            
                                            'tag',//执行结果
                                            'info',//弹出信息
                                            'cart_list',//购物车列表
                                            'cart_checked_amount',//所有被选中商品的总金额
                                            'cart_all_amount',//购物车中所有商品总金额（选中和未被选中的）
                                            'cart_checked_number',//被选中的商品数量
                                            'cart_all_number',//购物车中所有商品数量
                                            'is_all_checked',//购物车中商品是否被全部选中
                                            'card_list',//礼品卡列表
                                         ];

        return $this->respond(['data'=>compact($arr)]);

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 删除购物车中的商品
    |
    |-------------------------------------------------------------------------------
    */
    public function cartDelete(){

        if(!Auth::check('user')){

             $this->tag                 = 'error';
             $this->info                = '请登录后删除';

             return $this->toJSON();
         }

         $id                            = request()->id;
         $cart                          = Cart::find($id);

         if(empty($cart)){

            $this->tag                  = 'error';
            $this->info                 = '异常操作';
            return $this->toJSON();
         }

         $cart->delete();
         $this->tag                     = 'success';

          //清除缓存
         Cache::flush();
         return $this->toJSON();

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 加入购物车效果
    |
    |-------------------------------------------------------------------------------
    */
    public function addToCart(){

         if(!Auth::check('user')){

             $this->tag                 = 'error';
             $this->info                = '请登录后再购物';

             return $this->toJSON();
         }
         $id                = request()->id;
         $goods             = Goods::find($id);

         //商品为空
         if(empty($goods)){

             $this->tag                 = 'error';
             $this->info                = '商品不存在，系统异常';
             return $this->toJSON();
         }

         //上加入购物车
         $goods->buy('' ,1);
         $this->tag                     = 'success';

         //清除缓存
         Cache::flush();
         return $this->toJSON();
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 选中或者取消
    |
    |-------------------------------------------------------------------------------
    */
    public function isChecked(){

        if(!Auth::check('user')){

            $this->tag              = 'error';
            $this->info             = '请登录后再操作购物车';
            return $this->toJSON();
        }
        $id                 = request()->id;
        $cart               = Cart::find($id);
        if(empty($cart)){
            $this->tag              = 'error';
            $this->info             = '购物车异常';
            return $this->toJSON();
        }

        $is_checked         = ($cart->is_checked == 1)? 0 : 1;
        $cart->is_checked   = $is_checked;
        $cart->save();

        //清除缓存
         Cache::flush();
         return $this->toJSON();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 全部选中 或者取消
    |
    |-------------------------------------------------------------------------------
    */
    public function allChecked(){

        if(!Auth::check('user')){

            $this->tag              = 'error';
            $this->info             = '请登录后再操作购物车';
            return $this->toJSON();
        }

        $user                       = Auth::user('user');

        //如果购物车中所有商品都被选中
        if($user->isAllChecked() == 1){
            //取消选中
            $user->allCartUnChecked();
        }
        else{
            //选中购物车中所有商品
            $user->allCartChecked();
        }
        //清除缓存
         Cache::flush();
         return $this->toJSON();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 购买数量减少1个
    |
    |-------------------------------------------------------------------------------
    */
    public function numSub(){
        if(!Auth::check('user')){

            $this->tag              = 'error';
            $this->info             = '请登录后再操作购物车';
            return $this->toJSON();
        }

        $id                         = request()->id;
        $cart                       = Cart::find($id);
        if(empty($cart)){
            $this->tag              = 'error';
            $this->info             = '异常操作';
            return $this->toJSON();
        }
        $cart->sub();
        //清除缓存
         Cache::flush();
         return $this->toJSON();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 购买数量加1个
    |
    |-------------------------------------------------------------------------------
    */
    public function numAdd(){
        if(!Auth::check('user')){

            $this->tag              = 'error';
            $this->info             = '请登录后再操作购物车';
            return $this->toJSON();
        }

        $id                         = request()->id;
        $cart                       = Cart::find($id);
        if(empty($cart)){
            $this->tag              = 'error';
            $this->info             = '异常操作';
            return $this->toJSON();
        }
        $cart->add();
        //清除缓存
         Cache::flush();
         return $this->toJSON();
    }
}

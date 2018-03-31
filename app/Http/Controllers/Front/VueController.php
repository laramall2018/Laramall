<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class VueController extends BaseController
{
    


    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(){

        $this->middleware('front.auth');
        $this->common       = new \Phpstore\Base\Common();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 购物车列表
    |
    |-------------------------------------------------------------------------------
    */
    public function cart_list(){

        $user               = Auth::user('user');
        $view               = $this->view('vue.cart');
        $view->cart_list    = $user->cart()->get();
        $view->breadcrumb   = $this->common->get_breadcrumb(trans('front.cart'));
        $view->user         = $user;
        $view->amount       = $user->amount();
        $view->number       = $user->number();
        $view->all_number   = $user->allNumber();

        return $view;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取购物车 json格式数据
    |
    |-------------------------------------------------------------------------------
    */
    public function cart_json(){

         $user          = Auth::user('user');
         return $user->cartJSON();

    }
}

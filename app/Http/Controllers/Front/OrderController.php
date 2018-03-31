<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Models\Goods;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\OrderGoods;
use App\Models\Payment;

class OrderController extends BaseController
{
    
    public $helper;
    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(){

        parent::__construct();
        $this->helper       = new \Phpstore\BatchOrder\Common();
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 批量下单
    |
    |-------------------------------------------------------------------------------
    */
    public function batch_order(){

        if(!Auth::user('user')){

            return redirect('auth/login');
        }

        $view                       = $this->view('batch_order');
        $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.batch_order'));
        $view->breadcrumb_mobile    = $this->breadcrumb_mobile(trans('front.batch_order'),url('auth/batch-order'));
        
        return  $view;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 批量下单 post
    |
    |-------------------------------------------------------------------------------
    */
    public function batch_order_post(Request $request){


        if(!Auth::user('user')){

            return redirect('auth/login');
        }

        $rules                          = ['order'=>'required'];
        $messages                       = ['order.required'=>'下单信息必须填写'];
        //表单验证
        $this->validate($request,$rules,$messages);

        //用分隔符#号 把不同的订单分成不同的字符串数组
        $arr                            = $this->helper->get_order_array_from_string(request()->order);

        //对字符串数组进行循环分割
        $data                           = [];
        foreach($arr as $key=>$item){

                //把商品地址字符串 转化成数组
                $temp_arr                = $this->helper->get_goods_and_address($key,$item);

                if($temp_arr['tag'] == 'error'){

                    return redirect('auth/batch-order')->withInput()->with('info',$temp_arr['info']);
                }

                $data[]                 = [

                                                'goods'     =>$temp_arr['goods'],
                                                'address'   =>$temp_arr['address'],
                ];

        }

        //对商品信息进行检索 系统符合的商品信息 加入到订单
        $view                           = $this->view('batch_order_show');
        $view->breadcrumb               = $this->common->get_breadcrumb(trans('front.batch_order'));
        $view->data                     = $data;
        $view->total                    = count($data);

        //把数据放入session中
        session()->put('data',$data);

        return $view;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 确认下单
    |
    |-------------------------------------------------------------------------------
    */
    public function batch_order_done(){

        
         //获取被选中的订单keys
         $keys              = request()->keys;
         //如果订单都未被选中 返回错误信息
         if(count($keys)< 1){

            $info           = '您未选中任何数据';
            $data           = session()->get('data');
            return  $this->errorView($data,$info);
         }
        
         $order             = [];
         //循环创建订单
         foreach($keys as $key){

             //检测购买商品的数量 是否超越了库存
             $temp_tag      = $this->helper->check_goods_number($key);

             if($temp_tag['tag'] == 'error'){

                  $data           = session()->get('data');
                  return $this->errorView($data,$temp_tag['info']);
             }

             if($item = $this->helper->create_order($key)){

                //生成的新的订单模型放入数组中
                $order[]    = $item;
             }
         }

         
         if(count($order)){
             
                //把订单转化为订单编号存入数组
                $parameter     = $this->helper->create_order_parameter($order);
                return redirect('auth/batch-order-done'.$parameter);
         }

         //弹出提示信息
         return $this->error();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 查看批量生成的订单信息
    |
    |-------------------------------------------------------------------------------
    */
    public function batch_order_done_get(){

        $order                      = $this->helper->get_order_list(request()->order_id);
        $view                       = $this->view('batch_order_done');
        $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.batch_order'));
        $view->order                = $order;
        
        return $view;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 通过选中的自定义 生成一个全新的父订单 金额为所有子订单金额之和
    |
    |-------------------------------------------------------------------------------
    */
    public function batch_order_pay(){

        if(!Auth::user('user')){

            return redirect('auth/login');
        }

        $ids                = request()->ids;

        if(count($ids) == 0){

            return $this->error();
        }


        $order                          = new Order();
        $order->order_sn                = Order::order_sn();
        $order->user_id                 = Auth::user()->id;
        $order->pay_status              = 0;
        $order->goods_amount            = Order::amounts($ids);
        $order->shipping_fee            = Order::fees($ids);
        $order->add_time                = time();
        $order->ip                      = request()->getClientIP();
        $order->order_from              = '批量下单总订单';
        $order->pay_id                  = Payment::def()->id;
        $order->pay_name                = Payment::def()->pay_name;
        $order->shipping_id             = Shipping::def()->id;
        $order->shipping_name           = Shipping::def()->shipping_name;
        $order->order_amount            = Order::totals($ids);
        $order->save();

        //设置子订单
        $order->children($ids);

        //把子订单中的订单产品 写入订单产品表中
        $order->children_goods($ids);

        return redirect('order-done?order_id='.$order->id);

    }

    
    /*
    |-------------------------------------------------------------------------------
    |
    | 系统错误提示信息
    |
    |-------------------------------------------------------------------------------
    */
    public function error(){

        $view                       = $this->view('validate');
        $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.batch_order'));
        $view->info                 = '批量下单数据格式不正确：缺少地址或者格式异常或者下单失败';
        $view->back_url             = url('auth/batch-order');
        return $view;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 当第二步骤 商品信息不合格的时候 返回错误提示信息
    |
    |-------------------------------------------------------------------------------
    */
    public function errorView($data,$info){

        //对商品信息进行检索 系统符合的商品信息 加入到订单
        $view                           = $this->view('batch_order_show');
        $view->breadcrumb               = $this->common->get_breadcrumb(trans('front.batch_order'));
        $view->data                     = $data;
        $view->total                    = count($data);
        session()->put('info',$info);
        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 系统错误提示信息
    |
    |-------------------------------------------------------------------------------
    */
    public function errorInfo($info){

        $view                       = $this->view('validate');
        $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.batch_order'));
        $view->info                 = $info;
        $view->back_url             = url('auth/batch-order');
        return $view;

    }
}

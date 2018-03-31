<?php

namespace App\Http\Controllers\Front;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Goods;
use App\Models\Category;
use App\Models\Brand;
use Phpstore\Base\Common;
use DB;
use LaravelCaptcha\Integration\BotDetectCaptcha;
use Request;
use Hash;
use Auth;
use Phpstore\Front\CartCommon;
use App\Models\Cart;
use App\Models\UserAddress;
use App\Models\Shipping;
use App\Models\Payment;
use App\Models\Order;
use App\Models\OrderGoods;
use HTML;


class CartController extends BaseController
{
    

    
    public $common;
    public $helper;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('front.auth');
        
        $this->common       = new Common();
        $this->helper       = new CartCommon();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 生成验证码的函数
    |
    |-------------------------------------------------------------------------------
    */
    public function cart_post(){

        //如果前台用户未登录
        if(!$this->helper->is_front()){

            return redirect('auth/login');
        }

        $goods_number       = Request::input('goods_number');
        $goods_attr_ids     = Request::input('goods_attr_ids');
        $goods_id           = Request::input('goods_id');

        //把商品加入购物车
        $this->helper->add_to_cart($goods_id,$goods_attr_ids,$goods_number);


        return redirect('cart');

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  查看购物车
    |
    |-------------------------------------------------------------------------------
    */
    public function cart_list(){

    
        $user                               = Auth::user('user');
        $view                               = $this->view('cart');
        $view->breadcrumb                   = $this->common->get_breadcrumb(trans('front.cart'));
        $view->breadcrumb_mobile            = $this->breadcrumb_mobile(trans('front.cart'),url('cart'));
        $view->cart_list                    = $user->cart_list();
        $view->amount                       = $user->amount();
        $view->number                       = $user->number();
        $view->all_number                   = $user->allNumber();
        $view->user                         = $user;

        return $view;

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  ajax更新购物车中商品数量 并返回总记录数
    |
    |-------------------------------------------------------------------------------
    */
    public function cart_number_update(){

        //如果前台用户未登录
        if(!$this->helper->is_front()){

            return 'error';
        }


        $id                         = Request::input('id');
        $tag                        = Request::input('tag');
        $user                       = Auth::user('user');

        $cart                       = Cart::find($id);

        if(empty($cart)){

            return 'error';

        }

        $goods_number              = intval($cart->goods_number);

        if($tag == 'add'){

            $cart->add();
        }
        else{

           if($goods_number <= 1){

              return 'error';
              exit;
           }

           $cart->sub();
        }

        return $user->cartJSON();

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  ajax更新购物车中商品的状态 并返回总记录数
    |
    |-------------------------------------------------------------------------------
    */
    public function checked(){

         if(!Auth::check('user')){

                return 'error';
         }

         $id                = request()->id;
         $is_checked        = request()->is_checked;

         $cart              = Cart::find($id);
         $user              = Auth::user('user');

         if(empty($cart)){

             return 'error';
         }

         $cart->is_checked  = $is_checked;
         $cart->save();

         return $user->cartJSON();

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  ajax更新购物车中商品的状态 并返回总记录数
    |
    |-------------------------------------------------------------------------------
    */
    public function checked_all(){

         if(!Auth::check('user')){

             return 'error';
         }

         $user                  = Auth::user('user');
         $is_checked            = request()->is_checked;

         foreach($user->cart()->get() as $cart){

             $cart->is_checked   = $is_checked;
             $cart->save();
         }

         return $user->cartJSON();
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  wap版本购物车ajax操作
    |
    |-------------------------------------------------------------------------
    */
    public function cart_ajax_mobile(){

        $info                   = request()->info;
        $info                   = json_decode($info);
        $type                   = $info->type;
        $code                   = $info->code;
        //定义操作的类型和操作代码数组
        $type_arr               = ['single','batch','all'];
        $code_arr               = ['checked','add','delete','sub'];

        if(!in_array($type,$type_arr) || !in_array($code,$code_arr)){

            return false;
        }   

        //获取函数名称
        $func_name        = 'cart_mobile_'.$type.'_'.$code;
        //执行回调函数
        call_user_func(array($this->helper,$func_name), $info);
       
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  获取购物车中所有
    |
    |-------------------------------------------------------------------------
    */
    public function getCartJson(){

        if(!$this->helper->is_front()){

            return 'error';
        }

        $user       = Auth::user('user');
        return $user->cartJSON();

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  ajax删除购物车信息
    |
    |-------------------------------------------------------------------------------
    */
    public function delete(){

        //如果前台用户未登录
        if(!$this->helper->is_front()){

            return 'error';

        }

        $id             = Request::input('id');
        $user           = Auth::user('user');
        $cart           = Cart::find($id);

        if(empty($cart)){

            return 'error';
        }

        $cart->delete();

        return $user->cartJSON();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  处理结算 checkout
    |
    |-------------------------------------------------------------------------------
    */
    public function checkout(){

        //如果前台用户未登录
        if(!$this->helper->is_front()){

            return redirect('auth/login');
        }

        $user                           = Auth::user('user');
        $view                           = $this->view('checkout');
        $view->breadcrumb               = $this->common->get_breadcrumb(trans('front.checkout'));
        $view->breadcrumb_mobile        = $this->breadcrumb_mobile(trans('front.checkout'),url('checkout'));
        $view->cart_list                = $this->helper->get_cart_list();
        $view->province_list            = $this->helper->get_region(1);
        $view->address_list             = $this->helper->get_address_list();
        $view->payment_list             = $this->helper->get_payment_list();
        $view->shipping_list            = $this->helper->get_shipping_list();
        $view->cart_list                = $user->cart()->where('is_checked',1)->get();
        $view->cart_total               = $user->amount();

        return $view;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  地址三级联查ajax处理action
    |
    |-------------------------------------------------------------------------------
    */
    public function pcd(){

        $info           = Request::input('info');
        $info           = json_decode($info);

        $region_id      = $info->region_id;
        $region_type    = $info->region_type;
        $tag            = $info->tag;


        $res            = DB::table('region')->where('parent_id',$region_id)->where('region_type',$region_type)->get();

        $row            = ['data'=>$res,'tag'=>$tag];

        return $this->toJSON($row);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  添加地址到数据库
    |
    |-------------------------------------------------------------------------------
    */
    public function add_address(){

        $info           = Request::input('info');
        $info           = json_decode($info);
        $str            = 'error';

        $province       = intval($info->province);
        $city           = intval($info->city);
        $district       = intval($info->district);
        $consignee      = $info->consignee;
        $email          = $info->email;
        $phone          = $info->phone;
        $address        = $info->address;


        if($province == 0 || $city == 0 || $district == 0 ||empty($consignee)||empty($email)||empty($phone)||empty($address)){

             return $this->toJSON(['info'=>$str]);

        }

        $data           = [
                                'country'   =>1,
                                'province'  =>$province,
                                'city'      =>$city,
                                'district'  =>$district,
                                'consignee' =>$consignee,
                                'email'     =>$email,
                                'phone'     =>$phone,
                                'address'   =>$address,
                                'user_id'   =>Auth::user()->id
        ];

        if($address_id = DB::table('user_address')->insertGetId($data)){

                $user               = User::find(Auth::user()->id);
                $user->address_id   = $address_id;

                if($user->save()){

                    $str            = 'ok';
                }
        }
        

        return $this->toJSON(['info'=>$str]);
        
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  更新地址信息
    |
    |-------------------------------------------------------------------------------
    */
    public function update_address(){


        $id             = Request::input('id');

        $address        = UserAddress::find($id);

        if(empty($address)){

            return redirect('checkout');
        }


        $province       = $this->R('province');
        $city           = $this->R('city');
        $district       = $this->R('district');
        $consignee      = $this->R('consignee');
        $email          = $this->R('email');
        $phone          = $this->R('phone');
        $address        = $this->R('address');

        $rules          = [

                                'province'          =>'required|min:1',
                                'city'              =>'required|min:1',
                                'district'          =>'required|min:1',
                                'consignee'         =>'required',
                                'email'             =>'required|email',
                                'phone'             =>'required',
                                'address'           =>'required',     

        ];

        $validator      = Validator::make(Request::all(),$rules);

        if($validator->fails()){

            return redirect('checkout');
        }

        $data           = compact('province','city','district','consignee','email','phone','address');

        //更新数据
        DB::table('user_address')->where('id',$id)->update($data);

        return redirect('checkout');

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  ajax删除地址信息
    |
    |-------------------------------------------------------------------------------
    */
    public function del_address(){

        $id         = $this->R('id');

        $address    = UserAddress::find($id);

        $info       = 'error';

        if(empty($address)){

            return $this->toJSON(['info'=>$info]);
        }

        if($address->delete()){

            $info   = 'ok';
        }

        //如果有用户的默认地址是这个地址 也需要清理
        $model        = User::where('address_id',$id)->first();

        if($model){

            $model->address_id      = 0;
            $model->save();
        }

        return $this->toJSON(['info'=>$info]);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  ajax 设置默认地址
    |
    |-------------------------------------------------------------------------------
    */
    public function def_address(){

         $id                    = Request::input('id');
         $address               = UserAddress::find($id);

         $info                  = 'error';

         //如果前台用户未登录
        if(!$this->helper->is_front()){

            return $this->toJSON(['info'=>$info]);
        }

        if(empty($address)){

                return $this->toJSON(['info'=>$info]);
        }

         $user                  = User::find(Auth::user()->id);

         $user->address_id      = $id;

         if($user->save()){

            $info               = 'ok';
         }

         return $this->toJSON(['info'=>$info]);
         
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  ajax计算运费
    |
    |-------------------------------------------------------------------------------
    */
    public function shipping_fee(){

         $shipping_id       = Request::input('shipping_id');
         $shipping          = Shipping::find($shipping_id);
         $fee               = 0;
         $address_id        = intval(request()->address_id);

         if($address_id == 0){

             return $this->toJSON(['tag'=>'error','info'=>'请选择地址']);
         }
        
         if($shipping){

            $fee            = $shipping->getFee($address_id);
         }

         $cart_total        = Cart::amount();

         $total             = $cart_total + $fee;

         return $this->toJSON(['fee'=>$fee,'total'=>$total,'tag'=>'ok']);


    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   ajax下订单
    |
    |-------------------------------------------------------------------------------
    */
    public function order(){

         //如果前台用户未登录
        if(!Auth::check('user')){

            return $this->toJSON(['info'=>'error']);
            exit;
        }
        $info               = Request::input('info');
        $info               = json_decode($info);

        $address_id         = intval($info->address_id);
        $shipping_id        = intval($info->shipping_id);
        $pay_id             = intval($info->pay_id);

        $user               = Auth::user('user');
        $cart_number        = $user->number();

        if($cart_number == 0){

            return $this->toJSON(['info'=>'cart_empty']);
            exit;
        }

        //写入订单信息
        $order_id = $this->helper->create_order($address_id,$shipping_id,$pay_id);

        if($order_id == 0){

            return $this->toJSON(['info'=>'order_error']);
            exit;
        }

        //把购物车中产品写入到订单产品表
        $this->helper->cart_to_order_goods($order_id);

        //返回订单的信息

        $order      = Order::find($order_id);
        

        $row        = [
                            'info'=>'success',
                            'order_id'=>$order_id
                      ];

        return $this->toJSON($row);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   下订单成功后 显示支付界面
    |
    |-------------------------------------------------------------------------------
    */
    public function done(){

        $order_id               = Request::input('order_id');

        if(empty($order_id)||$order_id == 0){

             return $this->view('404');
        }

        $order                  = Order::find($order_id);

        if(empty($order)){

            return $this->view('404');
        }

        $view                       = $this->view('done');
        $view->order                = $order;
        $view->pay_btn              = $this->helper->get_pay_btn($order);  

        $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.order_done'));
        $view->breadcrumb_mobile    = $this->breadcrumb_mobile(trans('front.order_done'),url('order-done?order_id='.$order_id));

        return $view;

    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   移动端下单
    |
    |-------------------------------------------------------------------------------
    */
    public function mobile_order(){

        if(!Auth::check('user')){

            return false;
        }

        $info           = json_decode(request()->info);
        $_token         = request()->_token;

        $address_id     = intval($info->address_id);
        $pay_id         = intval($info->pay_id);
        $shipping_id    = intval($info->shipping_id);

        $address        = UserAddress::find($address_id);
        $payment        = Payment::find($pay_id);
        $shipping       = Shipping::find($shipping_id);

        //购物车空
        if(Cart::checked_number() == 0){

            return $this->toJSON(['info'=>'cart_empty']);
        }

        //非法操作
        if(empty($address) || empty($payment) || empty($shipping) ){

            return $this->toJSON(['info'=>'error']);
        }

        //生成订单的操作要完成
        //新创建一个订单信息模型
        //利用一对多的关系 把购物车中选中的商品写入订单产品模型中
        //清空当前登录用户的购物车中选中的产品 

        $data   = [

                    'order_sn'          => Order::order_sn(),
                    'user_id'           => Auth::user('user')->id,
                    'order_status'      => 0,
                    'shipping_status'   => 0,
                    'pay_status'        => 0,
                    'consignee'         => $address->consignee,
                    'country'           => $address->country,
                    'province'          => $address->province,
                    'city'              => $address->city,
                    'district'          => $address->district,
                    'address'           => $address->address,
                    'phone'             => $address->phone,
                    'email'             => $address->email,
                    'shipping_id'       => $shipping_id,
                    'shipping_name'     => $shipping->shipping_name,
                    'pay_id'            => $pay_id,
                    'pay_name'          => $payment->pay_name,
                    'goods_amount'      => Cart::amount(),
                    'shipping_fee'      => $shipping->fee,
                    'order_amount'      => ( Cart::amount() + $shipping->shipping_fee ) ,
                    'add_time'          => time(),
                    'ip'                => request()->getClientIp(),
                    'order_from'        => '手机下单',
        ];

        //创建订单信息
        $order      = Order::create($data);
        //创建订单产品

        $user_id    = Auth::user('user')->id;
        $user       = User::find($user_id);
        $goods      = [];

        foreach($user->cart()->where('is_checked',1)->get() as $cart){

            $goods        = [
                                    'goods_id'      => $cart->goods_id,
                                    'goods_sn'      => $cart->goods_sn,
                                    'goods_name'    => $cart->goods_name,
                                    'market_price'  => $cart->market_price,
                                    'shop_price'    => $cart->shop_price,
                                    'goods_number'  => $cart->goods_number,
                                    'goods_attr'    => $cart->goods_attr,
                                    'order_id'      => $order->id,

            ];

            OrderGoods::create($goods);
        }

       

        //清空购物车
        $user->cart()->where('is_checked',1)->delete();

        
        if($order && Cart::checked_number() == 0){

            return $this->toJSON(['info'=>'ok','url'=>url('order-done?order_id='.$order->id)]);
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   下订单成功后 显示支付界面
    |
    |-------------------------------------------------------------------------------
    */
    public function payment($id){

    
        if(empty($id)||$id == 0){

             return $this->view('404');
        }

        $order                  = Order::find($id);

        if(empty($order)){

            return $this->view('404');
        }

        $view                       = $this->view('payment');
        $view->order                = $order;
        $view->pay_btn              = $this->helper->get_pay_btn($order);
        $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.order_done'));

        return $view;

    }


    
}
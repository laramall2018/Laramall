<?php namespace Phpstore\Mobile;

use App\Http\Controllers\Front\BaseController;
use Auth;
use Validator;
use App\User;
use App\Models\Order;
use App\Models\CollectGoods;
use App\Models\OrderReturn;
use Phpstore\Front\CartCommon;
use App\Models\Payment;
use App\Models\Tag;
use App\Models\Message;
use App\Models\Sms;
use App\Models\Account;

/*
|-------------------------------------------------------------------------------
|
|   商品控制器里面的grid相应操作函数
|
|-------------------------------------------------------------------------------
|
|   tableDataInit  	    --------------- 初始化tableData实例 并赋值给grid实例
|   setTableDataCol		--------------- 设置tabledata实例需要显示的数据库字段
|   getData 		    --------------- 根据指定的字段 获取表格所需要显示的所有数据
|   getTableData($info) --------------- 根据返回的json格式数据 初始化新的tableData实例
|   searchData          --------------- grid模板页面 需要的搜索表单配置数组
|   searchInfo 			--------------- grid模板页面 ajax操作函数 需要的json格式参数
|                                       ps.ui.grid(ajax_url,_token ,json)
|   FormData            --------------- 生成添加商品时候的表单数据信息
|   EditData            --------------- 编辑商品时候生成表单的数组信息
|   delete_goods_image  --------------- 删除商品图片
|   softdelAction       --------------- 批量回收站操作
|   deleteAction        --------------- 批量删除操作
|
|-------------------------------------------------------------------------------
*/
class Common{

	

    public $ctl;
    public $helper;

	/*
	|----------------------------------------------------------------------------
	|
	|  构造函数
	|
	|----------------------------------------------------------------------------
	*/
	function __construct(){

		//定义基础控制器
        $this->ctl           = new BaseController();
        $this->helper        = new CartCommon();
	}


    /*
    |----------------------------------------------------------------------------
    |
    |  用户中心资料相关
    |
    |----------------------------------------------------------------------------
    */
    public function profileIndex(){

        $view                          = $this->ctl->view('user_profile');
        $view->user                    = Auth::user('user');
        $view->back_url                = url('auth/center');
        return $view;
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  用户资料编辑
    |
    |----------------------------------------------------------------------------
    */
    public function profileEdit($id){


        $view                       = $this->ctl->view('user_profile_edit');
        $url                        = url('auth/mobile/profile/'.$id.'/edit');
        $view->breadcrumb_mobile    = $this->ctl->breadcrumb_mobile(trans('mobile.auth.profile.edit'),$url);
        $view->user                 = Auth::user('user');
        $view->back_url             = url('auth/mobile/profile');

        return $view;
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  用户资料更新
    |
    |----------------------------------------------------------------------------
    */
    public function profileUpdate(){

        $user               = Auth::user('user');
        $rules              = [
                                'email'        =>'required|email|unique:users,email,'.$user->id,
                                'phone'        =>'required',
        ];

        $validator          = Validator::make(request()->all(),$rules);

        //验证失败
        if($validator->fails()){

            $view                           = $this->ctl->view('error');
            $url                            = url('auth/mobile/profile/'.$user->id.'/edit');
            $view->breadcrumb_mobile        = $this->ctl->breadcrumb_mobile(trans('mobile.auth.profile.edit'),$url);
            $view->back_url                 = $url;
            $view->messages                 = $validator->messages();

            return $view;
        }

        if($user->update(request()->all())){

            //更新密码
            $user->password();
            //处理会员图片上传
            $user->img();       
        }

            return redirect('auth/mobile/profile');
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  显示订单列表
    |
    |----------------------------------------------------------------------------
    */
    public function orderIndex(){

        $view                           = $this->ctl->view('user_order');
        $view->user                     = Auth::user('user');
        $view->breadcrumb_mobile        = $this->ctl->breadcrumb_mobile(trans('mobile.auth.order'),url('auth/mobile/order'));
        $view->back_url                 = url('auth/center');

        return $view;
    }

    /*
    |----------------------------------------------------------------------------
    |
    |  显示单条订单详细信息
    |
    |----------------------------------------------------------------------------
    */
    public function orderShow($id){

        $model      = Order::find($id);

        if(empty($model)){

             return $this->ctl->view('404');
        }

        $view                           = $this->ctl->view('user_order_detail');
        $url                            = url('auth/mobile/order/'.$id);
        $view->breadcrumb_mobile        = $this->ctl->breadcrumb_mobile(trans('mobile.auth.order_detail'),$url);
        $view->order                    = $model;
        $view->back_url                 = url('auth/mobile/order');

        return $view;


    }

    /*
    |----------------------------------------------------------------------------
    |
    |  取消订单
    |
    |----------------------------------------------------------------------------
    */
    public function orderDelete($id){

        $model      = Order::find($id);

        if(empty($model)){

             return $this->ctl->view('404');
        }

        $model->cancel_status  = 1;
        $model->save();
        return redirect('auth/mobile/order/'.$id);

    }


    /*
    |----------------------------------------------------------------------------
    |
    |  订单支付
    |
    |----------------------------------------------------------------------------
    */
    public function payShow($id){

        $model                          = Order::find($id);

        if(empty($model)){

             return $this->ctl->view('404');
        }

        $view                           = $this->ctl->view('order_pay');
        $url                            = url('auth/mobile/pay/'.$id);
        $view->breadcrumb_mobile        = $this->ctl->breadcrumb_mobile(trans('mobile.auth.order.pay'),$url);
        $view->order                    = $model;
        $view->back_url                 = url('auth/mobile/order/'.$id);

        return $view;   

    }

    /*
    |----------------------------------------------------------------------------
    |
    |  订单更新
    |  类型：put
    |  隐藏传递参数: id  _method= PUT (模拟put请求)
    |
    |----------------------------------------------------------------------------
    */
    public function orderUpdate(){

        $id                     = intval(request()->id);
        $order                  = Order::find($id);

        if(empty($order)){

            return $this->ctl->view('404');
        }

        $pay_id                 = request()->pay_id;
        $payment                = Payment::find($pay_id);

        if(empty($payment)){

            return $this->ctl->view('404');
        }

        $order->pay_id          = $pay_id;
        $order->pay_name        = $payment->pay_name;
        $order->save();
        //去支付页面
        $view                       = $this->ctl->view('done');
        $view->order                = $order;
        $view->pay_btn              = $this->helper->get_pay_btn($order);
        $view->breadcrumb_mobile    = $this->ctl->breadcrumb_mobile(trans('front.order_done'),url('order-done?order_id='.$id));

        return $view;
    }



    /*
    |----------------------------------------------------------------------------
    |
    |  退货单列表
    |
    |----------------------------------------------------------------------------
    */
    public function returnIndex(){

        $view                       = $this->ctl->view('return_list');
        $url                        = url('auth/mobile/return/');
        $view->breadcrumb_mobile    = $this->ctl->breadcrumb_mobile(trans('mobile.auth.return'),$url);
        $view->user                 = Auth::user('user');
        $view->back_url             = url('auth/center');

        return $view;
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  获取退货单详情信息
    |
    |----------------------------------------------------------------------------
    */
    public function returnShow($id){

        $model      = OrderReturn::find($id);

        if(empty($model)){

             return $this->ctl->view('404');
        }

        $view                           = $this->ctl->view('return_detail');
        $url                            = url('auth/mobile/return/'.$id);
        $view->breadcrumb_mobile        = $this->ctl->breadcrumb_mobile(trans('mobile.auth.return'),$url);
        $view->model                    = $model;
        $view->back_url                 = url('auth/mobile/return');

        return $view;

    }


    /*
    |----------------------------------------------------------------------------
    |
    |  删除退货单
    |
    |----------------------------------------------------------------------------
    */
    public function returnDelete($id){


        $model                          = OrderReturn::find($id);
        if(empty($model)){

            return $this->view('404');
        }

        //更新订单的退货状态
        $order                          = Order::find($model->order_id);
        $order->return_status           = 0;
        $order->save();

        $model->delete();

        return redirect('auth/mobile/return');
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  添加退货单
    |
    |----------------------------------------------------------------------------
    */
    public function returnCreate(){

        $view                               = $this->ctl->view('add_return');
        $url                                = url('auth/mobile/return/create');
        $view->breadcrumb_mobile            = $this->ctl->breadcrumb_mobile(trans('mobile.auth.return'),$url);
        $view->back_url                     = url('auth/mobile/return');
        $view->user                         = Auth::user('user');

        return $view;
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  存储退货单数据
    |
    |----------------------------------------------------------------------------
    */
    public function returnStore(){

        $rules                              = [
                                                    'order_id'  =>'required|unique:order_return,order_id',
                                                    'username'  =>'required',
                                                    'type'      =>'required'  
        ];

        $validator                          = Validator::make(request()->all(),$rules);

        if($validator->fails()){

            $view                           = $this->ctl->view('error');
            $url                            = url('auth/mobile/return/create');
            $view->breadcrumb_mobile        = $this->ctl->breadcrumb_mobile(trans('front.mobile.return'),$url);
            $view->back_url                 = $url;
            $view->messages                 = $validator->messages();

            return $view;
        }

        if($model = OrderReturn::create(request()->all())){

            $model->add_time                = time();
            $model->ip                      = request()->getClientIp();
            $model->return_status           = 1;
            //存储
            $model->save();
            //修改相应订单的数据
            $order                          = Order::find(request()->order_id);
            $order->return_status           = 1;
            $order->save();
        }

        return redirect('auth/mobile/return');
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  显示用户的所有收藏商品
    |
    |----------------------------------------------------------------------------
    */
    public function collectIndex(){

        $view                               = $this->ctl->view('collect');
        $url                                = url('auth/mobile/collect');
        $view->breadcrumb_mobile            = $this->ctl->breadcrumb_mobile(trans('mobile.auth.collect'),$url);
        $view->user                         = Auth::user('user');
        $view->back_url                     = url('auth/center');

        return $view;
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  删除收藏的商品
    |
    |----------------------------------------------------------------------------
    */
    public function collectDelete($id){

        $model                              = CollectGoods::find($id);

        if(empty($model)){

            return $this->view('404');
        }

        $model->delete();

        return redirect('auth/mobile/collect');
    }



    /*
    |----------------------------------------------------------------------------
    |
    |  查看系统所有的标签
    |
    |----------------------------------------------------------------------------
    */
    public function tagIndex(){

        $config_arr     = [
                            'template_name'     => 'tag',
                            'name'              => trans('mobile.auth.tag'),
                            'url'               => url('auth/mobile/tag'),
                            'back_url'          => url('auth/center'),
        ];

        return $this->commonIndex($config_arr);
    }

    /*
    |----------------------------------------------------------------------------
    |
    |  添加标签
    |
    |----------------------------------------------------------------------------
    */
    public function tagCreate(){

        $config_arr     = [
                            'template_name'     => 'tag_add',
                            'name'              => trans('mobile.auth.tag'),
                            'url'               => url('auth/mobile/tag/create'),
                            'back_url'          => url('auth/center'),
        ];

        return $this->commonCreate($config_arr);
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  存储标签
    |
    |----------------------------------------------------------------------------
    */
    public function tagStore(){

        $rules                              = [
                                                    'goods_id'  =>'required',
                                                    'username'  =>'required',
                                                    'tag_name'  =>'required|unique:tag,tag_name',  
        ];

        $validator                          = Validator::make(request()->all(),$rules);

        if($validator->fails()){

            $view                           = $this->ctl->view('error');
            $url                            = url('auth/mobile/tag/create');
            $view->breadcrumb_mobile        = $this->ctl->breadcrumb_mobile(trans('mobile.auth.tag'),$url);
            $view->back_url                 = $url;
            $view->messages                 = $validator->messages();

            return $view;
        }

        if($model = Tag::create(request()->all())){

            $model->add_time                = time();
            $model->ip                      = request()->getClientIp();
            //存储
            $model->save();
           
        }

        return redirect('auth/mobile/tag');
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  删除系统标签
    |
    |----------------------------------------------------------------------------
    */
    public function tagDelete($id){

        $model                  = Tag::find($id);

        if(empty($model)){

            return $this->view('404');
        }

        $model->delete();

        return redirect('auth/mobile/tag');

    }


    /*
    |----------------------------------------------------------------------------
    |
    |  查看会员的留言列表
    |
    |----------------------------------------------------------------------------
    */
    public function messageIndex(){

        $config_arr     = [
                            'template_name'     => 'message',
                            'name'              => trans('mobile.auth.message'),
                            'url'               => url('auth/mobile/message'),
                            'back_url'          => url('auth/center'),
        ];

        return $this->commonIndex($config_arr);
    }

    /*
    |----------------------------------------------------------------------------
    |
    |  查看会员的留言列表
    |
    |----------------------------------------------------------------------------
    */
    public function messageShow($id){

        $model          = Message::find($id);

        if(empty($model)){

            return $this->view('404');
        }

        $config_arr     = [
                            'template_name'     => 'message_detail',
                            'name'              => trans('mobile.auth.message'),
                            'url'               => url('auth/mobile/message/'.$id),
                            'back_url'          => url('auth/mobile/message'),
                            'model'             => $model,
        ];

        return $this->commonShow($config_arr);
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  添加留言
    |
    |----------------------------------------------------------------------------
    */
    public function messageCreate(){

        $config_arr     = [
                            'template_name'     => 'message_add',
                            'name'              => trans('mobile.auth.message'),
                            'url'               => url('auth/mobile/message/create'),
                            'back_url'          => url('auth/mobile/message'),
        ];

        return $this->commonCreate($config_arr);
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  删除留言
    |
    |----------------------------------------------------------------------------
    */
    public function messageDelete($id){

        $model          = Message::find($id);

        if(empty($model)){

            return $this->view('404');
        }

        $model->delete();
        return redirect('auth/mobile/message');
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  存储留言信息进数据库
    |
    |----------------------------------------------------------------------------
    */
    public function messageStore(){

        $rules                              = [
                                                    'username'  =>'required',
                                                    'content'   =>'required',
                                                    'type'      =>'required',
                                                    'email'     =>'required',
        ];

        $validator                          = Validator::make(request()->all(),$rules);

        if($validator->fails()){

            $view                           = $this->ctl->view('error');
            $url                            = url('auth/mobile/message/create');
            $view->breadcrumb_mobile        = $this->ctl->breadcrumb_mobile(trans('mobile.auth.message'),$url);
            $view->back_url                 = $url;
            $view->messages                 = $validator->messages();

            return $view;
        }

        if($model = Message::create(request()->all())){

            $model->add_time                = time();
            $model->front_ip                = request()->getClientIp();
            //存储
            $model->save();
           
        }

        return redirect('auth/mobile/message');
    }



    /*
    |----------------------------------------------------------------------------
    |
    |  查看系统短消息
    |
    |----------------------------------------------------------------------------
    */
    public function smsIndex(){

        $config_arr     = [
                            'template_name'     => 'sms',
                            'name'              => trans('mobile.auth.sms'),
                            'url'               => url('auth/mobile/sms'),
                            'back_url'          => url('auth/center'),
        ];

        return $this->commonIndex($config_arr);
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  查看会员的留言列表
    |
    |----------------------------------------------------------------------------
    */
    public function smsShow($id){

        $model          = Sms::find($id);

        if(empty($model)){

            return $this->view('404');
        }

        $config_arr     = [
                            'template_name'     => 'sms_detail',
                            'name'              => trans('mobile.auth.sms'),
                            'url'               => url('auth/mobile/sms/'.$id),
                            'back_url'          => url('auth/mobile/sms'),
                            'model'             => $model,
        ];

        return $this->commonShow($config_arr);
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  删除消息
    |
    |----------------------------------------------------------------------------
    */
    public function smsDelete($id){

        $model          = Sms::find($id);

        if(empty($model)){

            return $this->view('404');
        }

        $model->delete();
        return redirect('auth/mobile/sms');
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  添加消息
    |
    |----------------------------------------------------------------------------
    */
    public function smsCreate(){

        $config_arr     = [
                            'template_name'     => 'sms_add',
                            'name'              => trans('mobile.auth.sms'),
                            'url'               => url('auth/mobile/sms/create'),
                            'back_url'          => url('auth/mobile/sms'),
        ];

        return $this->commonCreate($config_arr);
    }

    /*
    |----------------------------------------------------------------------------
    |
    |  存储留言信息进数据库
    |
    |----------------------------------------------------------------------------
    */
    public function smsStore(){

        $rules                              = [
                                                    'user_id'       =>'required',
                                                    'sms_content'   =>'required',
                                                   
        ];

        $validator                          = Validator::make(request()->all(),$rules);

        if($validator->fails()){

            $view                           = $this->ctl->view('error');
            $url                            = url('auth/mobile/sms/create');
            $view->breadcrumb_mobile        = $this->ctl->breadcrumb_mobile(trans('mobile.auth.sms'),$url);
            $view->back_url                 = $url;
            $view->messages                 = $validator->messages();

            return $view;
        }

        if($model = Sms::create(request()->all())){

            $model->post_time                = time();
            $model->ip                       = request()->getClientIp();
            //存储
            $model->save();
           
        }

        return redirect('auth/mobile/sms');
    }





    /*
    |----------------------------------------------------------------------------
    |
    |  查看系统资金变化
    |
    |----------------------------------------------------------------------------
    */
    public function moneyIndex(){

        $config_arr     = [
                            'template_name'     => 'money',
                            'name'              => trans('mobile.auth.money'),
                            'url'               => url('auth/mobile/money'),
                            'back_url'          => url('auth/center'),
        ];

        return $this->commonIndex($config_arr);
    }

    /*
    |----------------------------------------------------------------------------
    |
    |  查看会员的留言列表
    |
    |----------------------------------------------------------------------------
    */
    public function moneyShow($id){

        $model          = Account::find($id);

        if(empty($model)){

            return $this->view('404');
        }

        $config_arr     = [
                            'template_name'     => 'money_detail',
                            'name'              => trans('mobile.auth.money'),
                            'url'               => url('auth/mobile/money/'.$id),
                            'back_url'          => url('auth/mobile/money'),
                            'model'             => $model,
        ];

        return $this->commonShow($config_arr);
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  删除消息
    |
    |----------------------------------------------------------------------------
    */
    public function moneyDelete($id){

        $model          = Account::find($id);

        if(empty($model)){

            return $this->view('404');
        }

        $model->delete();
        return redirect('auth/mobile/money');
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  添加消息
    |
    |----------------------------------------------------------------------------
    */
    public function moneyCreate(){

        $config_arr     = [
                            'template_name'     => 'money_add',
                            'name'              => trans('mobile.auth.money'),
                            'url'               => url('auth/mobile/money/create'),
                            'back_url'          => url('auth/mobile/money'),
        ];

        return $this->commonCreate($config_arr);
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  存储留言信息进数据库
    |
    |----------------------------------------------------------------------------
    */
    public function moneyStore(){

        $rules                              = [
                                                    'username'          =>'required',
                                                    'amount'            =>'required',
                                                    'payment'           =>'required',
                                                    'type'              =>'required',
                                                   
        ];

        $validator                          = Validator::make(request()->all(),$rules);

        if($validator->fails()){

            $view                           = $this->ctl->view('error');
            $url                            = url('auth/mobile/money/create');
            $view->breadcrumb_mobile        = $this->ctl->breadcrumb_mobile(trans('mobile.auth.money'),$url);
            $view->back_url                 = $url;
            $view->messages                 = $validator->messages();

            return $view;
        }

        if($model = Account::create(request()->all())){

            $model->add_time                = time();
            $model->ip                      = request()->getClientIp();
            //存储
            $model->save();
           
        }

        return redirect('auth/mobile/money');
    }













    /* ===============================通用控制器 ================================== */


    /*
    |----------------------------------------------------------------------------
    |
    |  系统通用的index
    |
    |----------------------------------------------------------------------------
    */
    public function commonIndex($config_arr){

        $view                           = $this->ctl->view($config_arr['template_name']);
        $view->breadcrumb_mobile        = $this->ctl->breadcrumb_mobile($config_arr['name'],$config_arr['url']);
        $view->user                     = Auth::user('user');
        $view->back_url                 = $config_arr['back_url'];

        return $view;
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  通用添加操作
    |
    |----------------------------------------------------------------------------
    */
    public function commonCreate($config_arr){

        $view                               = $this->ctl->view($config_arr['template_name']);
        $view->breadcrumb_mobile            = $this->ctl->breadcrumb_mobile($config_arr['name'],$config_arr['url']);
        $view->back_url                     = $config_arr['back_url'];
        $view->user                         = Auth::user('user');

        return $view;
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  通用显示单条记录操作
    |
    |----------------------------------------------------------------------------
    */
    public function commonShow($config_arr){

        $view                           = $this->ctl->view($config_arr['template_name']);
        $view->breadcrumb_mobile        = $this->ctl->breadcrumb_mobile($config_arr['name'],$config_arr['url']);
        $view->model                    = $config_arr['model'];
        $view->back_url                 = $config_arr['back_url'];

        return $view;

    }

}
<?php namespace App\Http\Controllers\Admin;
/**
 * Created by PhpStorm.
 * User: swh
 * Date: 15/9/11
 * Time: 上午9:52
 */


use App\Models\Express;
use App\Models\Order;
use Auth;
use Cache;
use DB;
use File;
use HTML;
use Input;
use Phpstore\Base\Goodslib;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormToModel;
use Phpstore\Grid\Common;
use Phpstore\Grid\Grid;
use Phpstore\Order\CommonHelper;
use Phpstore\Order\OrderLog as OrderLog;
use Request;
use Route;
use Validator;

class OrderController extends BaseController{



    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */


    public $page;
    public $tag;
    public $view;
    public $layout;
    public $form;
    public $crud;
    public $row;
    public $form_to_model;

    public $list_url;
    public $add_url;
    public $edit_url;
    public $del_url;
    public $update_url;
    public $preview_url;


    function __construct(){

        parent::__construct();
        $this->page                 = 'order';
        $this->tag                  = 'admin.order.index';
        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        //初始化
        $this->list_url             = 'admin/order';
        $this->add_url              = 'admin/order/create';
        $this->update_url           = 'admin/order/update';
        $this->edit_url             = 'admin/order/edit/';
        $this->del_url              = 'admin/order/del/';
        $this->ajax_url             = 'admin/order/grid';
        $this->preview_url          = '';
        $this->batch_url            = 'admin/order/batch';

        $this->sysinfo              = new Sysinfo();
        $this->sysinfo->put('url',url($this->list_url));
        $this->sysinfo->put('page',$this->page);
        $this->sysinfo->put('tag',$this->tag);
        $this->help                 = new CommonHelper();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  显示系统所有新闻信息
    |  路由：admin/article
    |  路由名称：admin.article.index
    |  路由类型: get
    |
    |-------------------------------------------------------------------------------
    |
    |  列表页使用通用模板  crud/gird.blade.php
    |  grid模板页面需要的dom元素包括
    |  1.page 和 tag 标签 用于指定左侧菜单的当前一级菜单和当前二级菜单
    |  2.path_url  显示面包屑导航菜单
    |  3.action_name  显示当前操作名称
    |  4.add_btn    显示添加新商品的按钮
    |  5.系统搜索表单  用crud的form类生成
    |  6.grid页面的ajax函数为  ps.ui.grid(ajax_url,_token,json)
    |    这里指定ajax_url 同时生成json格式的搜索条件参数
    |  7 生成列表页的所有记录显示table  同时包含一个portlet box  可以自定义颜色
    |  8 把初始化好的grid对象实例赋值给模板
    |  9 模板 通过 $grid->portlet() 获取带style的响应式表格
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){


        $view                       = $this->view('crud.grid');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->list_url,trans('common.order_list'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = trans('common.order_list');

        //生成添加按钮
        $view->add_btn              = Common::get_add_btn($this->add_url,trans('common.add_order'));

        //生成搜索表单
        $this->crud->put('row',$this->help->searchData());
        $this->crud->put('url',url($this->list_url));
        $view->search               = $this->crud->render();

        //生成ps.ui.grid(ajax_url,_token,json)
        //指定ajax_url, json格式的搜索参数
        $view->ajax_url             = url($this->ajax_url);
        $view->searchInfo           = $this->help->searchInfo();

        //设置grid
        $tableData                  = $this->help->tableDataInit();
        $grid                       = new Grid($tableData);


        //指定portlet的颜色和配置文件
        //生成带配置文件的protletbox 响应式table
        //$grid->portlet()
        $grid->put('color','blue');
        $grid->put('action_name',trans('common.order_list'));
        $view->grid                 = $grid;


        //设置批量删除操作的batch_url
        $view->batch_url            = $this->batch_url;
        //批量删除按钮
        $view->batch_btn            = Common::batch_del_btn();

        //返回视图模板
        return $view;
    } 


    /*
    |-------------------------------------------------------------------------------
    |
    |  添加角色
    |  路由链接 : admin/article/create
    |  路由类型 : get
    |  路由名称 : admin.article.create
    |
    |-------------------------------------------------------------------------------
    */
    public function create(){


        $view                               = $this->view('order.crud');
        $view->page                         = $this->page;
        $view->tag                          = 'admin.order.create';
        $view->path_url                     = $this->get_path_url(HTML::link($this->add_url,trans('common.add_order')));
        $view->action_name                  = trans('common.add_order');
        //会员下拉列表
        $view->user_list_option             = $this->help->get_user_list_option();
        $view->cat_option_list              = Goodslib::cat_list(0,0,true,0,true);
        $view->brand_option_list            = Common::get_brand_option_list();
        $view->goods_type_option_list       = Common::get_goods_type_option_list(0);
        $view->province_list                = Common::get_region_list(1);
        //获取支付方式列表
        $view->payment_option_list          = Common::get_payment_option_list();
        $view->shipping_option_list         = Common::get_shipping_option_list();
        return $view;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  添加角色
    |  路由链接 : admin/article/{id}/edit
    |  路由类型 : get
    |  路由名称 : admin.article.edit
    |
    |-------------------------------------------------------------------------------
    */
    public function edit($id){


        $model                      = Order::find($id);


        if(empty($model)){

            return $this->sysinfo->forbidden();
        }


        $user_common                = new \Phpstore\Front\UserCommon();

        $view                       = $this->View('order.edit');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $view->path_url             = $this->get_path_url(HTML::link($this->edit_url.$id,trans('admin.edit_order')));
        $view->action_name          = trans('admin.edit_order');
        $view->order                = $model;
        $view->username             = $this->help->get_user_name($model->user_id);
        $view->order_status         = $user_common->get_order_status($id);
        $view->address              = $this->help->get_order_address($id);
        $view->shipping_status      = $this->help->get_shipping_status($id);
        $view->goods_list           = $model->order_goods()->get();
        $view->order_log            = DB::table('order_log')
                                        ->where('order_sn',$model->order_sn)
                                        ->get();
        $view->express_sn           = $this->get_order_express($id);

        return $view;

    } 









    /*
    |-------------------------------------------------------------------------------
    |
    |  insert 表单数据写入数据表中
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){

        $rules             = [

            'consignee'     =>'required',
            'email'         =>'required',
            'phone'         =>'required',
            'address'       =>'required',
        ];


        $validator         = Validator::make(Request::all(),$rules);

        if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            $this->sysinfo->put('url',url($this->add_url));
            return $this->sysinfo->error();
        }

        $model                      = new Order();

        $user_id                    = Request::input('user_id');
        $user_id                    = intval($user_id);
        $pay_id                     = intval(Request::input('pay_id'));
        $shipping_id                = intval(Request::input('shipping_id'));

        $model->user_id             = $user_id;
        $model->add_time            = time();
        $model->order_sn            = $this->help->create_order_sn();
        $model->referer             = trans('admin.admin_add_order');
        $model->pay_name            = $this->help->get_pay_name($pay_id);
        $model->shipping_name       = $this->help->get_shipping_name($shipping_id);
        $model->shipping_fee        = $this->help->get_shipping_fee($shipping_id);
        
        $row               = [
                                'province',
                                'city',
                                'district',
                                'consignee',
                                'email',
                                'address',
                                'phone',
                                'pay_id',
                                'shipping_id',
        ];

        foreach($row as $item){

            $model->$item   = Request::input($item);
        }

        $ids                = Request::input('ids');

        //生成订单
        if($model->save()){

            $order_id       = $model->id;
            //把产品写入订单产品表中
            $this->help->insert_order_goods($ids,$order_id);
        }

        return redirect($this->list_url); 
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  update 更新数据信息
    |
    |-------------------------------------------------------------------------------
    */
    public function update(){


        $id             = Request::input('id');

        $model          = Order::find($id);

        if(empty($model)){

            $this->sysinfo->put('info','非法操作');
            return $this->sysinfo->info();
        }


        $rules          = [

            'title'             => 'required|unique:article,title,'.$id,
            'content'           => 'required',
            'cat_id'            => 'required'

        ];


        $validator      = Validator::make(Request::all(),$rules);

        if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            $this->sysinfo->put('url',url('admin/article/'.$id.'/edit'));
            return $this->sysinfo->error();
        }


        $this->form_to_model->put('model',$model);
        $this->form_to_model->put('row',$this->help->EditData($model));

        if($this->form_to_model->insert()){

            return redirect($this->list_url);
        }
        else{

            return $this->sysinfo->fails();
        }



    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  删除操作
    |
    |-------------------------------------------------------------------------------
    */
    public function delete($id){

        $model              = Order::find($id);

        if(empty($model)){

            $this->sysinfo->put('info','非法操作');
            return $this->sysinfo->info();
        }

        if($model->delete()){

            return redirect($this->list_url);
        }

        else{

            return $this->sysinfo->fails();
        }
    }


    


    /*
    |-------------------------------------------------------------------------------
    |
    |  批量操作
    |
    |-------------------------------------------------------------------------------
    */
    public function batch(){

        $ids            = Request::input('ids');

        if(empty($ids)){

            $this->sysinfo->put('info','您未选择任何选项');
            return $this->sysinfo->info();
        }


        foreach($ids as $id){

            $model          = Order::find($id);

            if($model){

                $model->delete();
            }
        }

        return redirect($this->list_url);

    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   执行ajax grid操作
    |   输出json格式的商品列表数据 phpstore.grid.js组件根据json格式 重新生成table 并刷新列表
    |   对应路由  admin/role/grid
    |   路由名称  admin.role.grid
    |
    |-------------------------------------------------------------------------------
    */
    public function grid(){

        $info           = Request::input('info');
        $info           = json_decode($info);
        $tableData      = $this->help->getTableData($info);
        $grid           = new Grid($tableData);

        echo $grid->render();

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  处理订单相关信息
    |
    |-------------------------------------------------------------------------------
    */
    public function done(){

        $act        = Request::input('act');
        $id         = intval(Request::input('id'));

        if(in_array($act,['cancel','submit','express','pay','payno','all','shipping','shippingno'])){

             $func  = $act.'Func';

             return $this->$func($id);
        }


        return redirect($this->list_url);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  取消订单相关
    |
    |-------------------------------------------------------------------------------
    */
    public function cancelFunc($id){


        $model              = Order::find($id);

        if(empty($model)){

            $this->sysinfo->put('info','非法操作');
            return $this->sysinfo->info();

        }

        if($model->cancel_status == 1){

            $this->sysinfo->put('info','订单已经取消 禁止重复操作');
            $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
            return $this->sysinfo->info();

        }
        else{

            $model->cancel_status       = 1;
            if($model->save()){

                //写入订单操作日志
                $order_log              = new OrderLog();
                $order_log->username    = Auth::user('admin')->username;
                $order_log->order_sn    = $model->order_sn;
                $order_log->log         = '取消了订单';
                $order_log->log();

                $this->sysinfo->put('info','订单已经成功取消');
                $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
                return $this->sysinfo->info();
            }
        }
        return redirect('admin/order/'.$id.'/edit');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  确认订单
    |
    |-------------------------------------------------------------------------------
    */
    public function submitFunc($id){

        $model               = Order::find($id);

        if(empty($model)){

            $this->sysinfo->put('info','非法操作');
            return $this->sysinfo->info();
        }

            $model->order_status  = 1;
            $model->cancel_status = 0;

        if($model->save()){

            //写入订单操作日志
            $order_log              = new OrderLog();
            $order_log->username    = Auth::user('admin')->username;
            $order_log->order_sn    = $model->order_sn;
            $order_log->log         = '确认了订单'; 
            $order_log->log();

            $this->sysinfo->put('info','订单被确认');
            $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
            return $this->sysinfo->info();

        }

        return redirect('admin/order/'.$id.'/edit');
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  进入发货表单界面
    |
    |-------------------------------------------------------------------------------
    */
    public function expressFunc($id){


        $model              = Order::find($id);
        if(empty($model)){

            $this->sysinfo->put('info','非法操作');
            $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
            return $this->sysinfo->info();
        }


        if($model->cancel_status == 1){

            $this->sysinfo->put('info','订单已取消 禁止再操作');
            $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
            return $this->sysinfo->info();
        }

        $view              = $this->view('order.express');
        $view->page        = $this->page;
        $view->tag         = $this->tag;
        $current_url       = HTML::link('admin/order/done?act=express&id='.$id,trans('admin.express'));
        $view->path_url    = $this->get_path_url($current_url);
        $view->model       = $model;
        $view->address     = $this->get_order_address($id);
        $view->express_sn  = $this->get_order_express($id);

        return $view;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  发货单store操作
    |
    |-------------------------------------------------------------------------------
    */
    public function express(){

        $order_id          = Request::input('order_id');

        $order             = Order::find($order_id);

        if(empty($order)){

            $this->sysinfo->put('info','非法操作');
            $this->sysinfo->put('url',url('admin/order'));
            return $this->sysinfo->info();
        }

        $consignee         = Request::input('consignee');
        $address           = Request::input('address');
        $express_name      = Request::input('express_name');
        $express_sn        = Request::input('express_sn');
        $phone             = Request::input('phone');
        $order_sn          = Request::input('order_sn');

        $res               = DB::table('order_express')
                               ->where('order_sn',$order_sn)
                               ->first();

        $data              =[
                                'consignee'     =>$consignee,
                                'address'       =>$address,
                                'express_name'  =>$express_name,
                                'express_sn'    =>$express_sn,
                                'phone'         =>$phone,
                                'add_time'      =>time(),
        ];

        //修改订单发货状态
        $order->shipping_status     = 1;
        $order->save();

        if($res){

            DB::table('order_express')
              ->where('order_sn',$order_sn)
              ->update($data);


            //把订单操作写入日志
                $order_log              = new OrderLog();
                $order_log->username    = Auth::user('admin')->username;
                $order_log->order_sn    = $order_sn;
                $order_log->log         = '修改发货单：快递公司名称:'.$express_name.' 单号：'.$express_sn; 
                $order_log->log();
        }
        else{

            $data['order_sn']           = $order_sn;


            //把发货单插入发货单数据表中
            DB::table('order_express')
              ->insert($data);

            //把订单操作写入日志
                $order_log              = new OrderLog();
                $order_log->username    = Auth::user('admin')->username;
                $order_log->order_sn    = $order_sn;
                $order_log->log         = '添加发货单：快递公司名称:'.$express_name.' 单号：'.$express_sn; 
                $order_log->log();       
        }

         return redirect('admin/order/'.$order_id.'/edit');


    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  确认支付状态
    |
    |-------------------------------------------------------------------------------
    */
    public function payFunc($id){

        $model              = Order::find($id);

        if(empty($model)){

            $this->sysinfo->put('info','非法操作');
            $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
            return $this->sysinfo->info();
        }

        if($model->cancel_status == 1){

            $this->sysinfo->put('info','订单已取消 禁止再操作');
            $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
            return $this->sysinfo->info();
        }
        else{

            //如果订单已支付 无需再操作
            if($model->pay_status == 1){

                $this->sysinfo->put('info','订单已支付 禁止再操作');
                $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
                return $this->sysinfo->info();
            }
            else{

                $model->pay_status  =1;
                
                if($model->save()){
                    
                    //把对订单的操作写入订单日志
                    $order_log              = new OrderLog();
                    $order_log->username    = Auth::user('admin')->username;
                    $order_log->order_sn    = $model->order_sn;
                    $order_log->log         = '设置订单已支付：单号：'.$model->order_sn; 
                    $order_log->log();

                    $this->sysinfo->put('info','订单设置支付成功');
                    $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
                    return $this->sysinfo->info();
                }

            }
        }

        return redirect('admin/order/'.$id.'/edit');
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  取消支付
    |
    |-------------------------------------------------------------------------------
    */
    public function paynoFunc($id){

        $model              = Order::find($id);

        if(empty($model)){

            $this->sysinfo->put('info','非法操作');
            $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
            return $this->sysinfo->info();
        }

        if($model->cancel_status == 1){

            $this->sysinfo->put('info','订单已取消 禁止再操作');
            $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
            return $this->sysinfo->info();
        }
        else{

            //如果订单已支付 无需再操作
            if($model->pay_status == 0){

                $this->sysinfo->put('info','订单未支付 禁止再操作');
                $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
                return $this->sysinfo->info();
            }
            else{

                $model->pay_status  =0;
                
                if($model->save()){
                    
                    //把对订单的操作写入订单日志
                    $order_log              = new OrderLog();
                    $order_log->username    = Auth::user('admin')->username;
                    $order_log->order_sn    = $model->order_sn;
                    $order_log->log         = '设置订单已支付：单号：'.$model->order_sn; 
                    $order_log->log();

                    $this->sysinfo->put('info','订单成功取消支付状态');
                    $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
                    return $this->sysinfo->info();
                }

            }
        }

        return redirect('admin/order/'.$id.'/edit');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  取消支付
    |
    |-------------------------------------------------------------------------------
    */
    public function allFunc($id){

        $model              = Order::find($id);

        if(empty($model)){

            $this->sysinfo->put('info','非法操作');
            $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
            return $this->sysinfo->info();
        }

            //设置已支付
            $model->pay_status              = 1;
            //设置已确认
            $model->cancel_status           = 0;
            $model->order_status            = 1;
            //订单已发货
            $model->shipping_status         = 1;
                
            if($model->save()){
                    
                    //把对订单的操作写入订单日志
                    $order_log              = new OrderLog();
                    $order_log->username    = Auth::user('admin')->username;
                    $order_log->order_sn    = $model->order_sn;
                    $order_log->log         = '批量设置订单所有状态为确认：单号：'.$model->order_sn; 
                    $order_log->log();

                    $this->sysinfo->put('info','已经一键设置订单所有状态为确认');
                    $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
                    return $this->sysinfo->info();
            }

        return redirect('admin/order/'.$id.'/edit');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  确认发货
    |
    |-------------------------------------------------------------------------------
    */
    public function shippingFunc($id){

        $model              = Order::find($id);

        if(empty($model)){

            $this->sysinfo->put('info','非法操作');
            $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
            return $this->sysinfo->info();
        }

        if($model->cancel_status == 1){

            $this->sysinfo->put('info','订单已取消 禁止再操作');
            $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
            return $this->sysinfo->info();
        }
        else{

            //如果订单已支付 无需再操作
            if($model->shipping_status == 1){

                $this->sysinfo->put('info','订单已发货 禁止重复操作');
                $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
                return $this->sysinfo->info();
            }
            else{

                $model->shipping_status  =1;
                
                if($model->save()){
                    
                    //把对订单的操作写入订单日志
                    $order_log              = new OrderLog();
                    $order_log->username    = Auth::user('admin')->username;
                    $order_log->order_sn    = $model->order_sn;
                    $order_log->log         = '设置订单已发货：单号：'.$model->order_sn; 
                    $order_log->log();

                    $this->sysinfo->put('info','成功设置订单状态为：已发货');
                    $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
                    return $this->sysinfo->info();
                }

            }
        }

        return redirect('admin/order/'.$id.'/edit');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  取消发货
    |
    |-------------------------------------------------------------------------------
    */
    public function shippingnoFunc($id){

        $model              = Order::find($id);

        if(empty($model)){

            $this->sysinfo->put('info','非法操作');
            $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
            return $this->sysinfo->info();
        }

        if($model->cancel_status == 1){

            $this->sysinfo->put('info','订单已取消 禁止再操作');
            $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
            return $this->sysinfo->info();
        }
        else{

            //如果订单已支付 无需再操作
            if($model->shipping_status == 0){

                $this->sysinfo->put('info','订单未发货 禁止重复操作');
                $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
                return $this->sysinfo->info();
            }
            else{

                $model->shipping_status  =0;
                
                if($model->save()){
                    
                    //把对订单的操作写入订单日志
                    $order_log              = new OrderLog();
                    $order_log->username    = Auth::user('admin')->username;
                    $order_log->order_sn    = $model->order_sn;
                    $order_log->log         = '取消订单发货：单号：'.$model->order_sn; 
                    $order_log->log();

                    $this->sysinfo->put('info','成功设置订单状态为：未发货');
                    $this->sysinfo->put('url',url('admin/order/'.$id.'/edit'));
                    return $this->sysinfo->info();
                }

            }
        }

        return redirect('admin/order/'.$id.'/edit');
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  订单日志
    |
    |-------------------------------------------------------------------------------
    */
    public function log(){

         $view              = $this->view('order.log');
         $view->page        = $this->page;
         $view->tag         = 'admin.order.log';
         $current_url       = HTML::link('admin/order/log',trans('admin.log'));
         $view->path_url    = $this->get_path_url($current_url);

         $view->log_list    = DB::table('order_log')->paginate(20);

         return $view;

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  订单日志删除操作
    |
    |-------------------------------------------------------------------------------
    */
    public function log_delete($id){

        $id                 = intval($id);
        $model              = DB::table('order_log')->where('id',$id)->first();

        if(empty($model)){

            $this->sysinfo->put('info','非法操作');
            $this->sysinfo->put('url',url('admin/order/log'));

            return $this->sysinfo->info();
        }

        DB::table('order_log')->where('id',$id)->delete();

        return redirect('admin/order/log');

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  订单日志批量删除操作
    |
    |-------------------------------------------------------------------------------
    */
    public function log_batch(){

        $ids            = Request::input('ids');

        if(empty($ids)){

            $this->sysinfo->put('info','您未选择任何项');
            $this->sysinfo->put('url',url('admin/order/log'));

            return $this->sysinfo->info();
        }


        foreach($ids as $id){

            DB::table('order_log')
              ->where('id',$id)
              ->delete();
        }

        return redirect('admin/order/log');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  订单打印
    |
    |-------------------------------------------------------------------------------
    */
    public function order_print(){

        $view                       = $this->view('order.print');
        $view->page                 = $this->page;
        $view->tag                  = 'admin.order.print';
        $current_url                = HTML::link('admin/order/print',trans('admin.order_print'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->order_list           = DB::table('order_info')->get();

        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  订单打印post
    |
    |-------------------------------------------------------------------------------
    */
    public function print_post(){

        $order_sn           = Request::input('order_sn');

        $rules              = ['order_sn'=>'required'];

        $validator          = Validator::make(Request::all(),$rules);

        if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            $this->sysinfo->put('url',url('admin/order/print'));
            return $this->sysinfo->error();

        }

        $order              = Order::where('order_sn',$order_sn)->first();

        //订单为空则需要做跳转
        if(empty($order)){

            $this->sysinfo->put('info','非法操作');
            $this->sysinfo->put('url',url('admin/order/print'));
            return $this->sysinfo->info();
        }

        $view                   = view('simple.order.print_template');
        $view->order            = $order;
        $view->title            = '订单打印';
        $view->express          = Express::where('order_sn',$order_sn)->first();

        //获取订单状态
        $user_common            = new \Phpstore\Front\UserCommon();
        $view->order_status     = $user_common->get_order_status($order->id);

        //获取订单产品
        $view->goods_list       = DB::table('order_goods')
                                     ->where('order_id',$order->id)
                                     ->get();


        return $view;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取收货地址
    |
    |-------------------------------------------------------------------------------
    */
    public function get_order_address($order_id){

        $model          = Order::find($order_id);
        if(empty($model)){

            return false;
        }

        $country       = $this->get_region_name($model->country);
        $province      = $this->get_region_name($model->province);
        $city          = $this->get_region_name($model->city);
        $district      = $this->get_region_name($model->district);
        $address       = $model->address;

        return $country.$province.$city.$district.$address;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取地区名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_region_name($region_id){

        $res           = DB::table('region')->where('region_id',$region_id)->first();

        if($res){

            return $res->region_name;
        }

        return '';
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取订单的发货单号
    |
    |-------------------------------------------------------------------------------
    */
    public function get_order_express($order_id){

        $model              = Order::find($order_id);

        if(empty($model)){

            return '';
        }

        $res                = DB::table('order_express')
                                ->where('order_sn',$model->order_sn)
                                ->first();
        if($res){

            return $res->express_sn;
        }

        return '';
    }

}

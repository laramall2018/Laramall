<?php namespace App\Http\Controllers\Admin;

use App\Models\Express;
use App\Models\Order;
use Auth;
use File;
use HTML;
use Input;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormToModel;
use Phpstore\Express\CommonHelper;
use Phpstore\Grid\Common;
use Phpstore\Grid\Grid;
use Phpstore\Order\OrderLog as OrderLog;
use Request;
use Validator;

/*
|----------------------------------------------------------------------------------------
|
| 路由类型         路由                        对应处理函数             路由名称
|
| route get      admin/category              function index()       admin.category.index
| route get      admin/category/create       function create()      admin.category.create
| route post     admin/category              function store()       admin.category.store
| route get      admin/category/{id}/edit    function edit()        admin.category.edit
| route put      admin/category/{id}         function update()      admin.category.update
|---------------------------------------------------------------------------------------
| route get      admin/category/del/{id}     function destroy()     admin.category.destroy
| route post     admin/category/batch        function batch()       admin.category.batch
| route post     admin/category/grid         function grid()        admin.category.grid
|---------------------------------------------------------------------------------------
*/
class ExpressController extends BaseController{



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

    function __construct(){

    	parent::__construct();
        $this->page                 = 'order';
        $this->tag                  = 'admin.express.index';
        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        //定义商品的常用操作链接
        $this->list_url             = 'admin/express';
        $this->edit_url             = 'admin/express/edit';
        $this->add_url              = 'admin/express/create';
        $this->update_url           = 'admin/express/update';
        $this->del_url              = 'admin/express/delete/';
        $this->batch_url            = 'admin/express/batch';
        $this->preview_url          = '';
        $this->ajax_url             = 'admin/express/grid';


        //初始化帮助对象
        $this->help                 = new CommonHelper();

        //其他设置
        $this->sysinfo              = new Sysinfo();
        $this->sysinfo->put('url',url($this->list_url));
        $this->sysinfo->put('page',$this->page);
        $this->sysinfo->put('tag',$this->tag);




    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  显示所有商品列表信息
    |  路由：admin/cateogry
    |  路由名称：admin.goods.index
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
        $current_url                = HTML::link($this->list_url,trans('admin.express_list'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = trans('admin.express_list');

        //生成添加按钮
        $view->add_btn              = Common::get_add_btn($this->add_url,trans('admin.add_express'));

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
        $grid->put('action_name',trans('admin.express_list'));
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
    |   执行ajax grid操作
    |   输出json格式的商品列表数据 phpstore.grid.js组件根据json格式 重新生成table 并刷新列表
    |   对应路由  admin/goods/grid
    |   路由名称  admin.goods.grid
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
    |   执行添加商品的操作
    |   调用crud通用模板 crud/crud.blade.php
    |   对应路由  admin/goods/create
    |   路由名称  admin.goods.create
    |
    |-------------------------------------------------------------------------------
    */
    public function create(){

        $view               = $this->view('crud_add');
        $view->page         = $this->page;
        $view->tag          = $this->tag;
        $current_url        = HTML::link($this->add_url,trans('admin.add_express'));
        $view->path_url     = $this->get_path_url($current_url);

        $view->action_name  = trans('admin.add_express');

        //设置参数 通过crud组件生成输入界面表单
        $this->crud->put('row',$this->help->FormData());
        $this->crud->put('url',url($this->list_url));
        $view->form         = $this->crud->render();

        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行添加商品的操作 post
    |   路由名称：admin.category.store
    |   对应路由  admin/category
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){

         $rules         = [

                                'order_sn'      =>'required',
                                'express_sn'    =>'required',
                                'express_name'  =>'required',
                                'address'       =>'required',
                                'consignee'     =>'required',
                                'phone'         =>'required',

                          ];

         $validator     = Validator::make(Request::all(),$rules);

         if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
         }

         $model             = new Express();
         $this->form_to_model->put('model',$model);
         $this->form_to_model->put('row',$this->help->FormData());

         if($this->form_to_model->insert()){

              //订单发货状态修改
              $order                    = Order::where('order_sn',$model->order_sn)->first();
              $order->shipping_status   = 1;
              $order->save();
              //订单操作日志写入订单日志表中
              $order_log                = new OrderLog();
              $order_log->username      = Auth::user('admin')->username;
              $order_log->order_sn      = $model->order_sn;
              $order_log->log           = '发货：快递公司名称:'.$model->express_name.' 单号：'.$model->express_sn; 
              $order_log->log();


              return redirect($this->list_url);
         }
         else{

            return $this->sysinfo->fails();
         }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行添加商品的操作 get
    |   对应路由  admin/{id}/edit
    |   路由名称：admin.goods.edit
    |
    |-------------------------------------------------------------------------------
    */
    public function edit($id){

        $model                     = Express::find($id);

         if(empty($model)){

            return $this->sysinfo->forbidden();
         }

        $view                       = $this->view('crud_add');
        $view->action_name          = trans('admin.edit_express');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->edit_url.$id,trans('admin.edit_express'));
        $view->path_url             = $this->get_path_url($current_url);

        //设置参数 通过crud组件生成输入界面表单
        $this->crud->put('row',$this->help->EditData($model));
        $this->crud->put('url',url($this->list_url.'/'.$id));
        $view->form                 = $this->crud->form();

        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行更新商品操作 put 这里需要伪装路由为 put
    |   路由名称：admin.category.update
    |   对应路由  admin/category/{id}
    |
    |-------------------------------------------------------------------------------
    */
    public function update(){


        $id             = Request::input('id');
        $id             = intval($id);

        $model          = Express::find($id);

        if(empty($model)){

           return $this->sysinfo->forbidden();
        }

        $rules         = [

                                'order_sn'      =>'required',
                                'express_sn'    =>'required',
                                'express_name'  =>'required',
                                'address'       =>'required',
                                'consignee'     =>'required',
                                'phone'         =>'required',

                          ];

        $validator      = Validator::make(Input::all(),$rules);

        if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
        }


        $this->form_to_model->put('model',$model);
        $this->form_to_model->put('row',$this->help->EditData($model));



        if($this->form_to_model->insert()){

           //订单发货状态修改
              $order                    = Order::where('order_sn',$model->order_sn)->first();
              $order->shipping_status   = 1;
              $order->save();
              //订单操作日志写入订单日志表中
              $order_log                = new OrderLog();
              $order_log->username      = Auth::user('admin')->username;
              $order_log->order_sn      = $model->order_sn;
              $order_log->log           = '修改发货：快递公司名称:'.$model->express_name.' 单号：'.$model->express_sn; 
              $order_log->log(); 
             
              return redirect($this->list_url);
        }
        else{

           return $this->sysinfo->fails();
        }

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行删除商品操作 delete
    |   对应路由  admin/goods/{id}
    |   路由名称  admin.goods.destroy
    |
    |-------------------------------------------------------------------------------
    */
    public function delete($id){

        $model          = Express::find($id);

        if(empty($model)){

            return $this->sysinfo->forbidden();
        }


        if($model->delete()){

            return redirect($this->list_url);
        }

        return $this->sysinfo->fails();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行批量操作 post
    |   对应路由  admin/category/batch
    |   路由名称为 admin.category.batch
    |
    |-------------------------------------------------------------------------------
    */
    public function batch(){

        $ids                = Request::input('ids');

        if(empty($ids)){

            return $this->sysinfo->batchEmpty();
        }

        foreach($ids as $id){

            $model          = Express::find($id);
            $model->delete();
        }

        return redirect($this->list_url);
    }

}

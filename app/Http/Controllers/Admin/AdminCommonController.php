<?php namespace App\Http\Controllers\Admin;

use DB;
use File;
use HTML;
use Input;
use Phpstore\Grid\Common;
use Phpstore\Grid\Grid;
use Request;
use Validator;


/*
|----------------------------------------------------------------------------------------
|               
| 路由类型        路由                        对应处理函数             路由名称
|----------------------------------------------------------------------------------------
| route get      admin/{model}               function index()       admin.{model}.index
| route get      admin/{model}/create        function create()      admin.{model}.create
| route post     admin/{model}               function store()       admin.{model}.store
| route get      admin/{model}/{id}/edit     function edit()        admin.{model}.edit
| route put      admin/{model}/{id}          function update()      admin.{model}.update
|---------------------------------------------------------------------------------------
| route get      admin/{model}/delete/{id}   function delete()      admin.{model}.delete
| route post     admin/{model}/batch         function batch()       admin.{model}.batch
| route post     admin/{model}/grid          function grid()        admin.{model}.grid
|---------------------------------------------------------------------------------------
*/
class AdminCommonController extends BaseController{



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
    public $list_name;
    public $add_name;
    public $edit_name;
    public $store_rules;//存储验证规则
    public $update_rules;//更新表单验证规则
    public $model;
    public $help;
    public $table;

    function __construct(){

    	parent::__construct();

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
        $current_url                = HTML::link($this->list_url,$this->list_name);
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = $this->list_name;

        //生成添加按钮
        $view->add_btn              = Common::get_add_btn($this->add_url,$this->add_name);

        //生成搜索表单
        $this->crud->put('row',$this->help->searchData);
        $this->crud->put('url',url($this->list_url));
        $view->search               = $this->crud->render();

        //生成ps.ui.grid(ajax_url,_token,json)
        //指定ajax_url, json格式的搜索参数
        $view->ajax_url             = url($this->ajax_url);
        $view->searchInfo           = $this->help->searchInfo;

        //设置grid
        $tableData                  = $this->help->tableData;
        $grid                       = new Grid($tableData);


        //指定portlet的颜色和配置文件
        //生成带配置文件的protletbox 响应式table
        //$grid->portlet()
        $grid->put('color','blue');
        $grid->put('action_name',$this->list_name);
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
        $current_url        = HTML::link($this->add_url,$this->add_name);
        $view->path_url     = $this->get_path_url($current_url);

        $view->action_name  = $this->add_name;

        //设置参数 通过crud组件生成输入界面表单
        $this->crud->put('row',$this->help->FormData);
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
    public function store($model){

         
         $validator     = Validator::make(Request::all(),$this->store_rules);

         if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
         }

         
         
         $this->form_to_model->put('model',$model);
         $this->form_to_model->put('row',$this->help->FormData);

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
    |   执行添加商品的操作 get
    |   对应路由  admin/{id}/edit
    |   路由名称：admin.goods.edit
    |
    |-------------------------------------------------------------------------------
    */
    public function edit($model){

        
        if(empty($model)){

            return $this->sysinfo->forbidden();
        }

        $view                       = $this->view('crud_add');
        $view->action_name          = $this->edit_name;
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->list_url.'/'.$model->id.'/edit',$this->edit_name);
        $view->path_url             = $this->get_path_url($current_url);

        //设置参数 通过crud组件生成输入界面表单
        $this->crud->put('row',$this->help->EditData);
        $this->crud->put('url',url($this->list_url.'/'.$model->id));
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
    public function update($model){


        if(empty($model)){

           return $this->sysinfo->forbidden();
        }

         


        $validator      = Validator::make(Input::all(),$this->update_rules);

        if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
        }

        $this->form_to_model->put('model',$model);
        $this->form_to_model->put('row',$this->help->EditData);



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
    |   执行删除商品操作 delete
    |   对应路由  admin/goods/{id}
    |   路由名称  admin.goods.destroy
    |
    |-------------------------------------------------------------------------------
    */
    public function delete($id){

        $model                      = DB::table($this->table)
                                        ->where('id',$id)
                                        ->first();

        if(empty($model)){

            return $this->sysinfo->forbidden();
        }


        if(DB::table($this->table)->where('id',$id)->delete()){

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

        $del_type           = Request::input('del_type');
        $ids                = Request::input('ids');

        if(empty($ids)){

            return $this->sysinfo->batchEmpty();
        }

        foreach($ids as $id){

            $model          = DB::table($this->table)
                                ->where('id',$id)
                                ->first();

            if($model){

                DB::table($this->table)->where('id',$id)->delete();
            }
        }

        return redirect($this->list_url);
    }

}

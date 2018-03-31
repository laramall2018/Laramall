<?php namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use File;
use HTML;
use Input;
use Phpstore\Base\Lang;
use Phpstore\Base\Sysinfo;
use Phpstore\Brand\CommonHelper;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormToModel;
use Phpstore\Grid\Common;
use Phpstore\Grid\Grid;
use Request;
use Validator;


/*
|-------------------------------------------------------------------------------
|
|    route get      :admin/brand                function index();
|    route post     :admin/brand/grid           function grid();
|    route get      :admin/brand/add            function add();
|    route post     :admin/brand/add(post)      function insert();
|    route get      :admin/brand/edit/{id}      function edit();  as=>brand_edit
|    route get      :admin/brand/del/{id}       function delete();as=>brand_delete
|    route post     :admin/brand/batch          function batch()
|
|-------------------------------------------------------------------------------
*/
class BrandController extends BaseController{



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
        $this->page                 = 'goods';
        $this->tag                  = 'admin.brand.index';
        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        //定义商品的常用操作链接
        $this->list_url             = 'admin/brand';
        $this->edit_url             = 'admin/brand/edit/';
        $this->add_url              = 'admin/brand/create';
        $this->update_url           = 'admin/brand/update';
        $this->del_url              = 'admin/brand/del/';
        $this->batch_url            = 'admin/brand/batch';
        $this->preview_url          = 'brand/preview/';
        $this->ajax_url             = 'admin/brand/grid';


        //初始化帮助对象
        $this->help                 = new CommonHelper();

        //其他设置
        $this->sysinfo              = new Sysinfo();
        $this->sysinfo->put('url',HTML::link($this->list_url,Lang::get('back_brand_list')));
        $this->sysinfo->put('page',$this->page);
        $this->sysinfo->put('tag',$this->tag);




    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  显示所有品牌列表
    |  路由：admin/brand
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

        $view                       = $this->View('crud.grid');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->list_url,Lang::get('brand_list'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = Lang::get('brand_list');

        //生成添加按钮
        $view->add_btn              = Common::get_add_btn($this->add_url,Lang::get('add_brand'));

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
        $grid->put('action_name',Lang::get('brand_list'));
        $view->grid                 = $grid;

        //设置批量删除操作的batch_url
        $view->batch_url            = $this->batch_url;
        $view->batch_btn            = $this->help->batch_del_btn();

        //返回视图模板
        return $view;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   执行ajax grid操作
    |   输出json格式的商品列表数据 phpstore.grid.js组件根据json格式 重新生成table 并刷新列表
    |   对应路由  admin/brand/grid
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
    |   调用crud通用模板 crud_add.blade.php
    |   对应路由  admin/goods/add
    |
    |-------------------------------------------------------------------------------
    */
    public function create(){

        $view               = $this->view('crud_add_ueditor');
        $view->page         = $this->page;
        $view->tag          = 'brand';
        $current_url        = HTML::link($this->add_url,Lang::get('add_brand'));
        $view->path_url     = $this->get_path_url($current_url);

        $view->action_name  = Lang::get('add_brand');

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
    |   对应路由  admin/brand/add
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){

         $rules         = [

                                'brand_name'=>'required|unique:brand,brand_name'

                          ];

         $validator     = Validator::make(Request::all(),$rules);

         if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
         }

         $model             = new Brand();
         $this->form_to_model->put('model',$model);
         $this->form_to_model->put('row',$this->help->FormData());

         if($this->form_to_model->insert()){

              return redirect(url($this->list_url));
         }
         else{

            return $this->sysinfo->fails();
         }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行添加商品的操作 get
    |   对应路由  admin/brand/edit
    |
    |-------------------------------------------------------------------------------
    */
    public function edit($id){

        $model                     = Brand::find($id);

         if(empty($model)){

            return $this->sysinfo->forbidden();
         }

        $view                       = $this->view('crud_add_ueditor');
        $view->action_name          = Lang::get('edit_brand');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->edit_url.$id,Lang::get('edit_brand'));
        $view->path_url             = $this->get_path_url($current_url);

        //设置参数 通过crud组件生成输入界面表单
        $this->crud->put('row',$this->help->EditData($model));
        $this->crud->put('url',url('admin/brand/'.$id));
        $view->form                 = $this->crud->form();

        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行更新商品操作 put
    |   对应路由  admin/brand/{id}
    |
    |-------------------------------------------------------------------------------
    */
    public function update(){


        $id             = Request::input('id');

        $model          = Brand::find($id);

        if(empty($model)){

           return $this->sysinfo->forbidden();
        }


        $ruels          = [
                                'brand_name'=>'required|unique:brand,brand_name,'.$id,
                                'diy_url'   =>'unique:brand,diy_url,'.$id
                          ];

        $validator      = Validator::make(Input::all(),$ruels);

        if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
        }

        $this->form_to_model->put('model',$model);
        $this->form_to_model->put('row',$this->help->EditData($model));



        if($this->form_to_model->insert()){

           return redirect(url($this->list_url));
        }
        else{

           return $this->sysinfo->fails();
        }

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行删除商品操作 get
    |   对应路由  admin/brand/del/{id}
    |
    |-------------------------------------------------------------------------------
    */
    public function delete($id){


        $model          = Brand::find($id);

        if(empty($model)){

            return $this->sysinfo->forbidden();
        }

        $this->help->delete_brand_image($id);

        if($model->delete()){

            return redirect($this->list_url);
        }

        return $this->sysinfo->fails();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行批量操作 post
    |   对应路由  admin/brand/batch
    |
    |-------------------------------------------------------------------------------
    */
    public function batch(){

        $del_type           = Request::input('del_type');
        $ids                = Request::input('ids');

        if(empty($ids)){

            return $this->sysinfo->batchEmpty();
        }

        if(in_array($del_type,['softdel','delete'])){

            $func           = $del_type.'Action';

            $this->help->$func($ids);
        }

        return redirect($this->list_url);
    }




}

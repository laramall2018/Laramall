<?php namespace App\Http\Controllers\Admin;

use DB;
use File;
use HTML;
use Input;
use Phpstore\AdminCommon\CommonHelper as CommonHelper;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormToModel;
use Phpstore\Grid\Grid;
use Request;

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
| route get      admin/{model}/delete/{id}   function delete()      admin.{model}.destroy
| route post     admin/{model}/batch         function batch()       admin.{model}.batch
| route post     admin/{model}/grid          function grid()        admin.{model}.grid
|---------------------------------------------------------------------------------------
*/
class SuperController extends BaseController{


    public $ctl;
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
    public $DataModel;
    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    function __construct(){

        parent::__construct();

        
       
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  设置连接
    |
    |-------------------------------------------------------------------------------
    */
    public function urlInit(){

        $this->tag                     = 'admin.'.$this->model.'.index';
        //定义商品的常用操作链接
        $this->list_url                = 'admin/'.$this->model;
        $this->edit_url                = 'admin/'.$this->model.'/edit';
        $this->add_url                 = 'admin/'.$this->model.'/create';
        $this->update_url              = 'admin/'.$this->model.'/update';
        $this->del_url                 = 'admin/'.$this->model.'/delete/';
        $this->batch_url               = 'admin/'.$this->model.'/batch';
        $this->preview_url             = 'admin/'.$this->model.'/preview/';
        $this->ajax_url                = 'admin/'.$this->model.'/grid';

        //名称
        $this->list_name               = trans('admin.'.$this->model.'_list');
        $this->add_name                = trans('admin.add_'.$this->model);
        $this->edit_name               = trans('admin.edit_'.$this->model);

    } 


    /*
    |-------------------------------------------------------------------------------
    |
    | 生成数据模型
    |
    |-------------------------------------------------------------------------------
    */
    public function get_model($id){

        return [];
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 设置搜索关键词
    |
    |-------------------------------------------------------------------------------
    */
    public function keywords(){

        return [];
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 设置需要显示的数据库字段
    |
    |-------------------------------------------------------------------------------
    */
    public function set_data_col(){

        return [

      
        ];
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  把获取的数据 再进一步格式化
    |
    |-------------------------------------------------------------------------------
    */
    public function getData($data){

        return $data;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 生成grid页面 搜索表单的配置数组
    |
    |-------------------------------------------------------------------------------
    */
    public function searchData(){

        return [

                   
        ];

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  把执行ajax的搜索参数 用json格式化后 传递给grid页面
    |
    |-------------------------------------------------------------------------------
    */
    public function searchInfo(){

        $row    = [

                    'keywords'=>[
                                    
                    ],

                    'fieldRow'=>[


                    ],

                    'whereIn'=>[],
        ];


        return  json_encode($row,JSON_UNESCAPED_UNICODE);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 添加商品 生成form表单的配置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function FormData(){

        return []; 

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 编辑商品 生成form表单的配置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function EditData($model){

         return [];

    }

    

   

    






    /*
    |-------------------------------------------------------------------------------
    |
    | 从这里开始 下面的函数 不需要做任何修改
    |
    |-------------------------------------------------------------------------------
    */


    /*
    |-------------------------------------------------------------------------------
    |
    | 初始化工厂控制器
    |
    |-------------------------------------------------------------------------------
    */
    public function CtlInit(){

        //生成工厂控制器
        $this->ctl                          = new AdminCommonController();
        //设置参数
        $this->ctl->page                    = $this->page;
        $this->ctl->tag                     = $this->tag;
        $this->ctl->crud                    = new Crud();
        $this->ctl->form_to_model           = new FormToModel();

        //定义商品的常用操作链接
        $this->ctl->list_url                = $this->list_url;
        $this->ctl->edit_url                = $this->edit_url;
        $this->ctl->add_url                 = $this->add_url;
        $this->ctl->update_url              = $this->update_url;
        $this->ctl->del_url                 = $this->del_url;
        $this->ctl->batch_url               = $this->batch_url;
        $this->ctl->preview_url             = $this->preview_url;
        $this->ctl->ajax_url                = $this->ajax_url;

        //名称
        $this->ctl->list_name               = $this->list_name;
        $this->ctl->add_name                = $this->add_name;
        $this->ctl->edit_name               = $this->edit_name;
        
        //初始化数据表
        $this->ctl->table                   = $this->table;
        //添加验证规则
        $this->ctl->store_rules             = $this->store_rules;
        $this->ctl->update_rules            = $this->update_rules;

        //初始化帮助对象
        $this->ctl->help                    = $this->help;

        //其他设置
        $this->ctl->sysinfo                 = new Sysinfo();
        $this->ctl->sysinfo->put('url',url($this->list_url));
        $this->ctl->sysinfo->put('page',$this->page);
        $this->ctl->sysinfo->put('tag',$this->tag);

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 初始化帮助函数
    |
    |-------------------------------------------------------------------------------
    */
    public function HelpInit(){

        $this->help                          = new CommonHelper();
        

        //设置操作的数据表
        $this->help->table                   = $this->table;
        //设置搜索关键词
        $this->help->keywords                = $this->keywords();
        //设置TableData需要显示的数据库的字段
        $this->help->field_row               = $this->set_data_col();
        //设置生成搜索表单的参数（json格式数据 给js)
        $this->help->searchInfo              = $this->searchInfo();
        //设置生成搜索表单的参数
        $this->help->searchData              = $this->searchData();

        //生成help对象的属性tableData;
        $this->help->tableData               = $this->help->tableDataInit();
        //设置help对象的属性对象tableData的值
        $this->help->data                    = $this->getData($this->help->tableData->toArray());
        //用格式化的data值重新复制给对象tableData
        $this->help->tableData->put('data',$this->help->data);

        //设置添加表单的参数
        $this->help->FormData                = $this->FormData();

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  显示所有列表 index
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){

        return $this->ctl->index();
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
        $tableData->put('data',$this->getData($tableData->toArray()));

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

       return $this->ctl->create();
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

        $model              = $this->DataModel;
        return $this->ctl->store($model);

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

        $model                           = $this->get_model($id);
        $this->ctl->help->EditData       = $this->EditData($model);
        return $this->ctl->edit($model);
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

        $model                      = $this->get_model(Request::input('id'));
        $this->ctl->help->EditData  = $this->EditData($model);    

        return $this->ctl->update($model);

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

        return $this->ctl->delete($id);
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


        return $this->ctl->batch();

    }


}
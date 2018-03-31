<?php namespace App\Http\Controllers\Admin;

use App\Models\Log;
use Cache;
use File;
use HTML;
use Input;
use Phpstore\Base\Lang;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormToModel;
use Phpstore\Grid\Common;
use Phpstore\Grid\Grid;
use Phpstore\Log\CommonHelper;
use Request;
use Route;
use Validator;

class LogController extends BaseController{



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
        $this->page                 = 'privi';
        $this->tag                  = 'admin.log.index';
        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        //初始化
        $this->list_url             = 'admin/log';
        $this->add_url              = 'admin/log/create';
        $this->del_url              = 'admin/log/del/';
        $this->ajax_url             = 'admin/log/grid';
        $this->batch_url            = 'admin/log/batch';

        $this->sysinfo              = new Sysinfo();
        $this->sysinfo->put('url',url($this->list_url));
        $this->sysinfo->put('page',$this->page);
        $this->sysinfo->put('tag',$this->tag);
        $this->help                = new CommonHelper();
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
        $current_url                = HTML::link($this->list_url,Lang::get('log_list'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = Lang::get('log_list');

        //生成添加按钮
        $view->add_btn              = '';

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
        $grid->put('action_name',Lang::get('log_list'));
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
    |  删除操作
    |
    |-------------------------------------------------------------------------------
    */
    public function delete($id){

        $model              = Log::find($id);

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

            $model          = Log::find($id);

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

}

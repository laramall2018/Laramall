<?php namespace App\Http\Controllers\Admin;

use App\Models\ArticleCat;
use File;
use HTML;
use Input;
use Phpstore\ArticleCat\CommonHelper;
use Phpstore\Base\Lang;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormToModel;
use Phpstore\Grid\Common;
use Phpstore\Grid\Grid;
use Request;
use Route;
use Validator;

class ArticleCatController extends BaseController{



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
    public $sysinfo;

    function __construct(){

    	parent::__construct();
        $this->page                 = 'article';
        $this->tag                  = 'admin.article_cat.index';
        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        //初始化
        $this->list_url             = 'admin/article_cat';
        $this->add_url              = 'admin/article_cat/create';
        $this->update_url           = 'admin/article_cat/update';
        $this->edit_url             = 'admin/article_cat/edit/';
        $this->del_url              = 'admin/article_cat/del/';
        $this->ajax_url             = 'admin/article_cat/grid';
        $this->batch_url            = 'admin/article_cat/batch';

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
        $current_url                = HTML::link($this->list_url,Lang::get('article_cat_list'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = Lang::get('article_cat_list');

        //生成添加按钮
        $view->add_btn              = Common::get_add_btn($this->add_url,Lang::get('add_article_cat'));

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
        $grid->put('action_name',Lang::get('article_cat_list'));
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
    |  添加新闻分类
    |  路由链接 : admin/article_cat/create
    |  路由类型 : get
    |  路由名称 : admin.article_cat.create
    |
    |-------------------------------------------------------------------------------
    */
    public function create(){

        $view                       = $this->view('crud_add');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $view->action_name          = '添加新闻分类';
        $view->path_url             = $this->get_path_url(HTML::link($this->add_url,'添加新闻分类'));

        //设置参数 通过crud组件生成输入界面表单
        $this->crud->put('row',$this->help->FormData());
        $this->crud->put('url',url($this->list_url));
        $view->form                 = $this->crud->form();


        return $view;

    }





    /*
    |-------------------------------------------------------------------------------
    |
    |  添加新闻分类
    |  路由链接 : admin/article_cat
    |  路由类型 : get
    |  路由名称 : admin.article_cat.store
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){

         $rules             = [

                            'cat_name'  =>'required|unique:article_cat,cat_name',
                            'parent_id' =>'required'
         ];


         $validator         = Validator::make(Input::all(),$rules);

         if($validator->fails()){

                $this->sysinfo->put('validator',$validator);
                $this->sysinfo->put('url',url($this->add_url));
                return $this->sysinfo->error();
         }

         $model             = new ArticleCat();
         $this->form_to_model->put('model',$model);
         $this->form_to_model->put('row',$this->help->FormData());

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
    |  添加新闻分类
    |  路由链接 : admin/article_cat
    |  路由类型 : get
    |  路由名称 : admin.article_cat.edit
    |
    |-------------------------------------------------------------------------------
    */
    public function edit($id){


         $model                     = ArticleCat::find($id);

         if(empty($model)){

             return $this->sysinfo->forbidden();
         }

        $view                       = $this->view('crud_add');
        $view->action_name          = Lang::get('edit_article_cat');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $view->path_url             = $this->get_path_url(HTML::link($this->edit_url.$id,Lang::get('edit_article_cat')));

        //设置参数 通过crud组件生成输入界面表单
        $this->crud->put('row',$this->help->EditData($model));
        $this->crud->put('url',url('admin/article_cat/'.$id));
        $view->form                 = $this->crud->form();

        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  添加新闻分类
    |  路由链接 : admin/article_cat/{id}
    |  路由类型 : put
    |  路由名称 : admin.article_cat.update
    |
    |-------------------------------------------------------------------------------
    */
    public function update(){


        $id             = Request::input('id');

        $model          = ArticleCat::find($id);

        if(empty($model)){

            $this->sysinfo->put('info','非法操作');
            return $this->sysinfo->info();
        }


        $ruels          = ['cat_name'=>'required|unique:article_cat,cat_name,'.$id];

        $validator      = Validator::make(Input::all(),$ruels);

        if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
        }

        if($this->unique_edit('article_cat','cat_name' ,'id' , $id)){

            $this->sysinfo->put('info','已经存在相同数据:'.Request::input('cat_name'));
            return $this->sysinfo->info();
        }

        //自己不能是自己的父亲结点
        $parent_id      = Request::input('parent_id');

        if($parent_id == $id){

            $this->sysinfo->put('info','自己不能是自己的父亲结点');
            return $this->sysinfo->info();
        }


        $this->form_to_model->put('model',$model);
        $this->form_to_model->put('row',$this->help->EditData($model));



        if($this->form_to_model->insert()){

           return redirect($this->list_url);
        }
        else{

            $this->sysinfo->put('info','编辑失败');
            $this->sysinfo->put('url',HTML::link($this->edit_url.$id,'返回重新编辑'));
            return $this->sysinfo->info();
        }

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  添加新闻分类
    |  路由链接 : admin/article_cat/del/{id}
    |  路由类型 : put
    |  路由名称 : admin.article_cat.delete
    |
    |-------------------------------------------------------------------------------
    */
    public function delete($id){

        $model              = ArticleCat::find($id);

        if(empty($model)){

            return $this->sysinfo->forbidden();
        }

        $cat_pic            = $model->cat_pic;

        if($model->delete()){

            //如果存在分类图标
            if($cat_pic){

                @unlink(public_path().'/'.$cat_pic);
            }

            return redirect($this->list_url);
        }
        else{

            return $this->sysinfo->fails();
        }


    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  批量删除操作
    |
    |-------------------------------------------------------------------------------
    */
    public function batch(){

        $ids                = Request::input('ids');
        $del_type           = Request::input('del_type');

        if(empty($ids)){

            $this->sysinfo->put('info','您未选择任何项目');
            return $this->sysinfo->info();
        }

        //如果是批量删除
        if($del_type == 'delete'){


            foreach($ids as $id){

                $this->delete_article_cat($id);
            }

            return redirect($this->list_url);
        }

        elseif($del_type == 'softdel'){

            $this->sysinfo->put('info','您选择了把分类放入回收站中');
            return $this->sysinfo->info();
        }

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  删除操作
    |
    |-------------------------------------------------------------------------------
    */
    public function delete_article_cat($id){

        $model              = ArticleCat::find($id);

        if(empty($model)){

            return '';
        }


        $cat_pic            = $model->cat_pic;

        if($model->delete()){

            if($cat_pic){

                File::Delete(public_path().'/'.$cat_pic);
            }
        }
    }




    /*
    |-------------------------------------------------------------------------------
    |
    |   执行ajax grid操作
    |   输出json格式的商品列表数据 phpstore.grid.js组件根据json格式 重新生成table 并刷新列表
    |   对应路由  admin/article_cat/grid
    |   路由名称  admin.article_cat.grid
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

<?php namespace App\Http\Controllers\Admin;

use App\Models\Category;
use File;
use HTML;
use Input;
use Phpstore\Base\Lang;
use Phpstore\Base\Sysinfo;
use Phpstore\Category\CommonHelper;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormToModel;
use Phpstore\Grid\Common;
use Phpstore\Grid\Grid;
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
class CategoryController extends BaseController{



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
        $this->tag                  = 'admin.category.index';
        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        //定义商品的常用操作链接
        $this->list_url             = 'admin/category';
        $this->edit_url             = 'admin/category/edit';
        $this->add_url              = 'admin/category/create';
        $this->update_url           = 'admin/category/update';
        $this->del_url              = 'admin/category/del/';
        $this->batch_url            = 'admin/category/batch';
        $this->preview_url          = 'category/preview/';
        $this->ajax_url             = 'admin/category/grid';


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
        $current_url                = HTML::link($this->list_url,Lang::get('cat_list'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = Lang::get('goods_list');

        //生成添加按钮
        $view->add_btn              = Common::get_add_btn($this->add_url,Lang::get('add_cat'));

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
        $grid->put('action_name',Lang::get('cat_list'));
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
        $view->tag          = 'admin.category.index';
        $current_url        = HTML::link($this->add_url,Lang::get('add_cat'));
        $view->path_url     = $this->get_path_url($current_url);

        $view->action_name  = Lang::get('add_cat');

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

                                'cat_name'=>'required|unique:category,cat_name',
                                'diy_url' =>'unique:category,diy_url'

                          ];

         $validator     = Validator::make(Request::all(),$rules);

         if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
         }

         
         if($node = Category::create(request()->all())){
            
            //插入分类图片信息
            $node->img();
            //设置结点的套嵌属性
            $node->node();
            //返回到商品分类列表
            return redirect($this->list_url);
         }

         return $this->sysinfo->fails();
         
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

        $model                     = Category::find($id);

        if(empty($model)){

            return $this->sysinfo->forbidden();
        }

        $view                       = $this->view('crud_add');
        $view->action_name          = Lang::get('edit_cat');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->edit_url.$id,Lang::get('edit_cat'));
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


        $id             = request()->id;
        $id             = intval($id);

        $node           = Category::find($id);

        if(empty($node)){

           return $this->sysinfo->forbidden();
        }

        $rules          = [
                                'cat_name'=>'required|unique:category,cat_name,'.$id,
                                'diy_url'   =>'unique:category,diy_url,'.$id
                          ];

        $validator      = Validator::make(request()->all(),$rules);

        if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
        }

        //套嵌关系异常
        if($node->chain_error()){

            $this->sysinfo->put('info','非法的套嵌关系');
            return $this->sysinfo->info();
        }


        if($node->update(request()->all())){

            //处理上传的商品分类图标
            $node->img();
            //处理模型套嵌关系
            $node->node();
            //返回到分类列表页面
            return redirect($this->list_url);

        }
            return $this->sysinfo->fails();

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

        $node          = Category::find($id);

        if(empty($node)){

            return $this->sysinfo->forbidden();
        }

        //删除商品分类图片
        $node->delete_img();

        //只有叶子结点才可以删除
        if($node->isLeaf()){

            $node->delete();
            return redirect($this->list_url);
        }
        
        $this->sysinfo->put('info','仅叶子结点可以被删除或者异常');
        return $this->sysinfo->info();
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

            $node   = Category::find($id);

            if($node->isLeaf()){

                $node->delete_img();
                $node->delete();
            }
        }

        return redirect($this->list_url);
    }

}

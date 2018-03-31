<?php namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\GoodsAttr;
use DB;
use File;
use HTML;
use Input;
use Phpstore\Base\Sysinfo;
use Phpstore\Color\CommonHelper;
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
class ColorController extends BaseController{



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
    public $var_tag;

    function __construct(){

    	parent::__construct();
        $this->page                 = 'goods';
        $this->var_tag              = 'color';
        $this->tag                  = 'admin.'.$this->var_tag.'.index';
        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        //定义商品的常用操作链接
        $this->list_url             = 'admin/'.$this->var_tag;
        $this->edit_url             = 'admin/'.$this->var_tag.'/edit';
        $this->add_url              = 'admin/'.$this->var_tag.'/create';
        $this->update_url           = 'admin/'.$this->var_tag.'/update';
        $this->del_url              = 'admin/'.$this->var_tag.'/del/';
        $this->batch_url            = 'admin/'.$this->var_tag.'/batch';
        $this->preview_url          = '';
        $this->ajax_url             = 'admin/'.$this->var_tag.'/grid';


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

        $view                       = $this->view('color.grid');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->list_url,trans('admin.attr_color'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = trans('admin.attr_color');

        //生成搜索表单
        $this->crud->put('row',$this->help->searchData());
        $this->crud->put('url',url($this->list_url));
        $view->search               = $this->crud->render();

        //获取颜色属性的记录对象数组
        $view->grid                 = $this->get_color_attr_list();
        
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
        $current_url        = HTML::link($this->add_url,trans('admin.add_color_attr'));
        $view->path_url     = $this->get_path_url($current_url);

        $view->action_name  = trans('admin.add_color_attr');

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

         $model             = new Category();
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
    |   执行添加商品的操作 get
    |   对应路由  admin/{id}/edit
    |   路由名称：admin.goods.edit
    |
    |-------------------------------------------------------------------------------
    */
    public function edit($id){

        $model                     = GoodsAttr::find($id);

         if(empty($model)){

            return $this->sysinfo->forbidden();
         }

        $view                       = $this->view('color.crud');
        $view->action_name          = trans('admin.add_attr_color');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->edit_url.$id,trans('admin.add_attr_color'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->row                  = DB::table('goods_attr as ga')
                                        ->leftjoin('attribute as a','a.id','=','ga.attr_id')
                                        ->leftjoin('goods as g','g.id','=','ga.goods_id')
                                        ->leftjoin('goods_type as gt','gt.id','=','a.type_id')
                                        ->where('ga.id','=',$id)
                                        ->select('ga.*','gt.type_name','a.attr_name','g.goods_name')
                                        ->first();
        

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


        $id                         = Request::input('id');
        $id                         = intval($id);

        $model                      = GoodsAttr::find($id);

        if(empty($model)){

           return $this->sysinfo->forbidden();
        }

        $color_value                = Request::input('color_value');
 
        $model->color_value         = $color_value;
        //如果上传了属性图片
        if(Request::hasFile('color_img')){

            $img                    = new \Phpstore\Crud\ImageLib();
            $img->put('file_name','color_img');
            $upload_img             = $img->upload_image();

            //如果存在旧图片则直接删除
            if($old_color_img  = $model->color_img){

                @unlink(public_path().'/'.$old_color_img);
            }

            $model->color_img       = $upload_img;

        }

        if($model->save()){

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

        $model          = GoodsAttr::find($id);

        if(empty($model)){

            return $this->sysinfo->forbidden();
        }

        
        if($model->color_img){

            @unlink(public_path().'/'.$model->color_img);
        }

        $model->color_value  = '';
        $model->color_img    = '';

        if($model->save()){

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

        if(in_array($del_type,['softdel','delete'])){

            $func           = $del_type.'Action';

            $this->help->$func($ids);
        }

        return redirect($this->list_url);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   执行ajax删除属性图片
    |   路由名称：admin.color.img.delete
    |   对应路由  admin/color/img-del
    |
    |-------------------------------------------------------------------------------
    */
    public function img_del(){

        $id         = Request::input('id');
        $id         = intval($id);
        $model      = GoodsAttr::find($id);

        if(empty($model)){

            $row    = ['info'=>'off','message'=>'非法操作'];

            return $this->toJSON($row);
        }

        if($model->color_img){

            $color_img          = $model->color_img;
            $model->color_img   = '';

            if($model->save()){

                @unlink(public_path().'/'.$color_img);
                $row  = ['info'=>'ok','message'=>'图片删除成功'];
                return $this->toJSON($row);
            }
        }

        //如果属性图片不存在 则删除
        $row    = ['info'=>'off','message'=>'属性图片不存在'];
        return $this->toJSON($row);

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   获取颜色属性记录总数
    |
    |-------------------------------------------------------------------------------
    */
    public function get_color_attr_list(){


        $res            = DB::table('goods_attr as ga')
                            ->leftjoin('attribute as a','a.id','=','ga.attr_id')
                            ->leftjoin('goods as g','g.id','=','ga.goods_id')
                            ->leftjoin('goods_type as gt','gt.id','=','a.type_id')
                            ->select('ga.*','g.goods_name','a.attr_name','gt.type_name')
                            ->where('a.color_tag','=',1)
                            ->paginate(20);
        return $res;
    }

}

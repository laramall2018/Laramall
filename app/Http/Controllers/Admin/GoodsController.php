<?php namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Goods;
use App\Models\GoodsAttr;
use App\Models\GoodsGallery;
use App\Models\GoodsRelation;
use App\Models\Type;
use DB;
use File;
use HTML;
use Image;
use Input;
use Phpstore\Base\Lang;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormToModel;
use Phpstore\Goods\CommonHelper;
use Phpstore\Grid\Common;
use Phpstore\Grid\Grid;
use Phpstore\Oss\ImageOss;
use Request;
use Session;
use Storage;
use Validator;


/*
|----------------------------------------------------------------------------------------
|
| 路由类型         路由                        对应处理函数             路由名称
|
| route get      admin/goods                 function index()       admin.goods.index
| route get      admin/goods/create          function create()      admin.goods.create
| route post     admin/goods                 function store()       admin.goods.store
| route get      admin/goods/{id}/edit       function edit()        admin.goods.edit
| route put      admin/goods/{id}            function update()      admin.goods.update
|---------------------------------------------------------------------------------------
| route get      admin/goods/del/{id}        function destroy()     admin.goods.destroy
| route post     admin/goods/batch           function batch()       admin.goods.batch
| route post     admin/goods/grid            function grid()        admin.goods.grid
|---------------------------------------------------------------------------------------
*/
class GoodsController extends BaseController{



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
        $this->tag                  = 'admin.goods.index';
        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        //定义商品的常用操作链接
        $this->list_url             = 'admin/goods';
        $this->edit_url             = 'admin/goods/edit';
        $this->add_url              = 'admin/goods/create';
        $this->update_url           = 'admin/goods/update';
        $this->del_url              = 'admin/goods/del/';
        $this->batch_url            = 'admin/goods/batch';
        $this->preview_url          = 'goods/preview/';
        $this->ajax_url             = 'admin/goods/grid';
        $this->swf_url              = 'static/uploadify/uploadify.swf';
        $this->uploadify_url        = 'static/uploadify/uploadify.php';
        $this->uploadify_del_url    = 'admin/uploadify/delete';
        $this->timestamp            = time();



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
    |  路由：admin/goods
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
        $current_url                = HTML::link($this->list_url,Lang::get('goods_list'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = Lang::get('goods_list');

        //生成添加按钮
        $view->add_btn              = Common::get_add_btn($this->add_url,Lang::get('add_goods'));

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
        $grid->put('action_name',Lang::get('goods_list'));
        $view->grid                 = $grid;

        //设置批量删除操作的batch_url
        $view->batch_url            = $this->batch_url;
        //批量删除按钮
        $view->batch_btn            = Common::batch_all_btn();

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



        $view                           = $this->view('goods.crud');
        $view->page                     = $this->page;
        $view->tag                      = $this->tag;
        $current_url                    = HTML::link($this->add_url,Lang::get('add_goods'));
        $view->path_url                 = $this->get_path_url($current_url);
        $view->cat_option_list          = Category::cat_select();
        $view->brand_option_list        = Brand::brand_option();
        $view->goods_type_option_list   = Common::get_goods_type_option_list(0);
        $view->article_option_list      = Common::get_article_cat_option_list();
        $view->action_name              = Lang::get('add_goods');
        $view->goods_sn                 = Goods::create_goods_sn();


        return $view;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   执行添加商品的操作 post
    |   路由名称：admin.goods.store
    |   对应路由  admin/goods
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){

         $rules         = [

                                'goods_name'=>'required|unique:goods,goods_name',
                                'cat_id'    =>'required',
                                'diy_url'   =>'unique:goods,diy_url',

                          ];

         $img           = new ImageOss();
         $rules         = $img->rules($rules);

         $validator     = Validator::make(Request::all(),$rules);

         if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            $this->sysinfo->put('url',url('admin/goods/create'));
            return $this->sysinfo->error();
         }

         $cat_id        = Request::input('cat_id');
         $cat_id        = intval($cat_id);
         
         
         //检测商品分类编号
         if($cat_id <= 0){

            $info       = '分类编号必须大于0';
            $this->sysinfo->put('info',$info);
            $this->sysinfo->put('url',url($this->add_url));
            return $this->sysinfo->info();

         }

         //批量插入表单递交过来的数据
         if($model = Goods::create(request()->all())){

              //处理促销商品日期
              $model->promote_date();

              //处理商品相册
              $img->goods_gallery($model); 
              //处理商品属性
              $this->help->goods_attr($model);
              //处理唯一属性
              $this->help->goods_field($model->id);
              //处理关联商品
              $this->help->goods($model->id);
              //处理关联新闻
              $this->help->article($model->id);

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

        $model                         = Goods::find($id);

         if(empty($model)){

            return $this->sysinfo->forbidden();
         }

        $view                           = $this->view('goods.edit');
        $view->action_name              = Lang::get('edit_goods');
        $view->page                     = $this->page;
        $view->tag                      = $this->tag;
        $current_url                    = HTML::link($this->edit_url.$id,Lang::get('edit_goods'));
        $view->path_url                 = $this->get_path_url($current_url);
        $view->model                    = $model;
        $view->cat_option_list          = Category::cat_select();
        $view->brand_option_list        = Brand::brand_option();
        $view->goods_type_option_list   = Common::get_goods_type_option_list($id);
        $view->article_option_list      = Common::get_article_cat_option_list();
        $view->goods_gallery            = $model->gallery()->get();
        $view->goods_attr_list          = $model->admin_attr();
        $view->goods_field_list         = Common::get_goods_field_list_edit($id);
        $view->goods_relations_list     = $model->goods_relation()->get();
        $view->goods_article_list       = $model->goods_article()->get();


        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行更新商品操作 put 这里需要伪装路由为 put
    |   路由名称：admin.goods.update
    |   对应路由  admin/goods/{id}
    |
    |-------------------------------------------------------------------------------
    */
    public function update(){

        $id             = Request::input('id');
        $model          = Goods::find($id);
        if(empty($model)){

           return $this->sysinfo->forbidden();
        }

        $rules          = [
                                'goods_name'=>'required|unique:goods,goods_name,'.$id,
                                'diy_url'   =>'unique:goods,diy_url,'.$id
                          ];
        //初始化图片组件
        $img            = new ImageOss();
        //扩展rules规则
        $rules          = $img->rules($rules);        

        $validator      = Validator::make(Input::all(),$rules);
        if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
        }

        $cat_id        = Request::input('cat_id');
        $cat_id        = intval($cat_id);

        //检测商品分类编号
        if($cat_id <= 0){

            $info       = '分类编号必须大于0';
            $this->sysinfo->put('info',$info);
            $this->sysinfo->put('url',url($this->add_url));
            return $this->sysinfo->info();

        }

          //插入基本信息
          $model->update(request()->all());
          //处理促销日期
          $model->promote_date();
          //处理商品相册
          $img->goods_gallery($model);
          //处理商品属性
          $this->help->goods_attr($model);
          //处理唯一属性
          $this->help->goods_field($id);
          //处理关联商品
          $this->help->goods($id);
          //处理关联新闻
          $this->help->article($id);

          return redirect($this->list_url);

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

        $model          = Goods::find($id);

        if(empty($model)){

            return $this->sysinfo->forbidden();
        }

        //删除商品图片和商品相册图片
        $model->ImageDelete();
        //删除商品相册记录
        $model->gallery()->delete();

        if($model->delete()){

            return redirect($this->list_url);
        }

        return $this->sysinfo->fails();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行批量操作 post
    |   对应路由  admin/goods/batch
    |   路由名称为 admin.goods.batch
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
    |   执行商品属性ajax操作 post
    |   对应路由  admin/attribute/ajax
    |   路由名称为 admin.goods.attribute
    |
    |-------------------------------------------------------------------------------
    */
    public function ajax(){

         $type_id           = intval(Request::input('type_id'));
         $_token            = Request::input('_token');
         $data              = [];

         if($type_id == 0){

             return Common::toJson($data);
         }

         $model             = Type::find($type_id);

         if(empty($model)){

            return Common::toJson($data);
         }

         $res               = $model->attribute()->get();

        return Common::toJson(['data'=>$res]);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行商品属性ajax操作 post
    |   对应路由  admin/field/ajax
    |   路由名称为 admin.goods.field
    |
    |-------------------------------------------------------------------------------
    */
    public function FieldAjax(){

         $type_id           = intval(Request::input('type_id'));
         $_token            = Request::input('_token');
         $data              = [];

         if($type_id == 0){

             return Common::toJson($data);
         }


         $field_list         = DB::table('goods_type as gt')
                                ->leftjoin('field as f','gt.id','=','f.type_id')
                                ->select('f.id','f.field_name','f.type_id','f.sort_order','gt.type_name')
                                ->where('f.type_id',$type_id)
                                ->get();


        return Common::toJson(['data'=>$field_list]);
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   执行批量操作 get
    |   对应路由  goods/{id}
    |   路由名称为 front.goods.preview
    |
    |-------------------------------------------------------------------------------
    */
    public function preview($id){

         $data             = [];
         if(session()->has('histroy')){

            $data          = session()->get('histroy');

         }


         $data[]        = $id;

         session()->put('histroy',$data);

         dd(session()->get('histroy'));

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   执行商品属性ajax操作 post
    |   对应路由  admin/goods/search
    |   路由名称为 admin.goods.search
    |
    |-------------------------------------------------------------------------------
    */
    public function search(){

        $info           = Request::input('info');
        $_token         = Request::input('_token');

        $info           = json_decode($info);
        $cat_id         = $info->cat_id;
        $brand_id       = $info->brand_id;
        $keywords       = $info->keywords;

        $goods_list     = $this->help->search_goods_list($cat_id,$brand_id,$keywords);

        Common::toJson(['data'=>$goods_list]);
        exit;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行商品属性ajax操作 post
    |   对应路由  admin/goods/article
    |   路由名称为 admin.goods.article
    |
    |-------------------------------------------------------------------------------
    */
    public function article(){

        $info           = Request::input('info');
        $_token         = Request::input('_token');

        $info           = json_decode($info);
        $cat_id         = $info->cat_id;
        $keywords       = $info->keywords;

        $article_list     = Article::searchList($cat_id,$keywords);

        Common::toJson(['data'=>$article_list]);
        exit;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   删除商品的相册ajax操作
    |   对应路由  admin/goods/gallery/delete
    |   路由名称为 admin.gallery.delete
    |
    |-------------------------------------------------------------------------------
    */
    public function GalleryDelete(){

       $id          = Request::input('id');
       $_token      = Request::input('_token');

       $gallery     = GoodsGallery::find($id);
       $row         = [];

       if(empty($gallery)){
            echo Common::toJSON($row);
            exit;
       }

       //商品编号
       $goods_id    = $gallery->goods_id;
       $goods       = Goods::find($goods_id);

       //删除商品图片
       $gallery->ImageDelete();

       //删除数据中记录
       $gallery->delete(); 

       foreach($goods->gallery()->get() as $item){

          $row[]    = [

                          'thumb'   => $item->thumb(),
                          'img'     => $item->img(),
                          'original'=> $item->_original(),
                          'id'      =>$item->id
          ];
       }

       echo Common::toJson(['data'=>$row]);
       exit;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   删除商品的相册ajax操作
    |   对应路由  admin/goods/gallery/delete
    |   路由名称为 admin.gallery.delete
    |
    |-------------------------------------------------------------------------------
    */
    public function relationGoodsDelete($id){

        $model      = GoodsRelation::find($id);

        if(empty($model)){

            return $this->toJSON(['tag'=>'error','info'=>'非法操作']);
        }

        $goods     = $model->goods;
        $model->delete();
        //重新生成商品的关联商品列表
        $data      = [];
        foreach($goods->goods_relation()->get() as $item){

                $data[]         = [

                                        'id'          =>$item->id,
                                        'goods_name'  =>$item->toGoods()->goods_name,
                                        'thumb'       =>$item->toGoods()->thumb(),
                                        'url'         =>url('admin/goods/relation/delete/'.$item->id),    

                ];
        }

        return $this->toJSON(['tag'=>'success','list'=>$data]);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   删除商品的属性ajax操作
    |   对应路由  admin/goods-attr-delete
    |   路由名称为 admin.goods.attr.delete
    |
    |-------------------------------------------------------------------------------
    */
    public function goodsAttrDelete(){

         $goods_attr_id         =  request()->goods_attr_id;
         $model                 = GoodsAttr::find($goods_attr_id);
         if(empty($model)){

             return $this->toJSON(['tag'=>'error','info'=>'异常']);
         }

         if($model->delete()){

             return $this->toJSON(['tag'=>'success']);
         }
    }

}

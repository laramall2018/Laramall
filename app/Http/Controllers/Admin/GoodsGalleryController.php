<?php namespace App\Http\Controllers\Admin;

use App\Models\GoodsGallery;
use DB;
use File;
use HTML;
use Image;
use Input;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormToModel;
use Phpstore\Oss\ImageOss;
use Request;
use Validator;


/*
|----------------------------------------------------------------------------------------
|                                                                                        
| 路由类型         路由                        对应处理函数             路由名称              
|
| route get      admin/attribute              function index()       admin.attribute.index   
| route get      admin/attribute/create       function create()      admin.attribute.create
| route post     admin/attribute              function store()       admin.attribute.store
| route get      admin/attribute/{id}/edit    function edit()        admin.attribute.edit
| route put      admin/attribute/{id}         function update()      admin.attribute.update
|---------------------------------------------------------------------------------------
| route get      admin/attribute/del/{id}     function destroy()     admin.attribute.destroy
| route post     admin/attribute/batch        function batch()       admin.attribute.batch
| route post     admin/attribute/grid         function grid()        admin.attribute.grid
|---------------------------------------------------------------------------------------
*/
class GoodsGalleryController extends BaseController{



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
    public $cols;

    function __construct(){

    	parent::__construct();
        $this->page                 = 'goods';
        $this->tag                  = 'admin.goods.image';
        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        //定义商品的常用操作链接
        $this->list_url             = 'admin/goods/image';
        $this->batch_url            = 'admin/goods/image-batch';


        //其他设置
        $this->sysinfo              = new Sysinfo();
        $this->sysinfo->put('url',url($this->list_url));
        $this->sysinfo->put('page',$this->page);
        $this->sysinfo->put('tag',$this->tag);

        //设置商品图片需要配置的参数
        $this->cols                 = ['thumb_width','thumb_height','img_width','img_height'];

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 显示所有商品图片列表
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){

        $view                       = $this->view('crud.goods_images');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->list_url,trans('admin.goods_images'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = trans('admin.goods_images');
        $view->grid                 = GoodsGallery::paginate(20);
        $page                       = $this->get_page_info();

        $view->current_page         = $page['current_page'];
        $view->last_page            = $page['last_page'];
        $view->per_page             = $page['per_page'];
        $view->total                = $page['total'];

        
        foreach($this->cols as $item){

            $view->$item            = $this->get_config_value($item);
        }
        


        //设置批量删除操作的batch_url
        $view->batch_url            = $this->batch_url;
       

        //返回视图模板
        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 处理商品图片的设置信息
    |
    |-------------------------------------------------------------------------------
    */
    public function config(){

        foreach($this->cols as $item){

            $this->set_config_value($item ,Request::input($item));
        }

        return redirect($this->list_url);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 重新生成商品图片尺寸 
    | 类型：ajax
    |
    |-------------------------------------------------------------------------------
    */
    public function redo(){

        $info                  = json_decode(Request::input('info'));

        $current_page          = intval($info->current_page);
        $per_page              = intval($info->per_page);
        $last_page             = intval($info->last_page);
        $total                 = intval($info->total);

        //如果当前页小于等于最后一页
        if($current_page <= $last_page ){

                $skip_num       = ($current_page - 1)* $per_page ;
        }
        else{

                $skip_num       = 0;
                $current_page   = 1;
        }

        if($skip_num == 0){

                $data           =  GoodsGallery::take($per_page)->get();
                $count          =  count($data);

        }

        else{

                $data          = GoodsGallery::take($per_page)->skip($skip_num)->get();
                $count         = count($data);
        }

        $img                   = new ImageOss();

        foreach($data as $value){

                //重新生成新的商品相册图片 并删除旧的图片信息
                $img->create_new_goods_image($value->id);
        }


        $row  = [

                        'count'=>$count,
                        'current_page'=>$current_page,
                        'last_page'=>$last_page,
                        'per_page' =>$per_page,
                        'total'    =>$total,
                ];

        echo json_encode($row,JSON_UNESCAPED_UNICODE);
        exit;
        


    }

    

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取商品列表信息
    |
    |-------------------------------------------------------------------------------
    */
    public function get_goods_image_list(){

            $res        = DB::table('goods_gallery as gg')
                            ->leftjoin('goods as g','g.id','=','gg.goods_id')
                            ->select('gg.*','g.goods_name')
                            ->paginate(20);
            return $res;
        
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取配置文件中的参数
    |
    |-------------------------------------------------------------------------------
    */
    public function get_config_value($code){

        $row            = DB::table('sys_config')->where('code',$code)->first();

        if($row){

            return $row->value;
        }

        return '';
    } 


    /*
    |-------------------------------------------------------------------------------
    |
    | 设置商品图片相关的配置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function set_config_value($code,$value){

         $row                       = DB::table('sys_config')->where('code',$code)->first();

         if($row){

             DB::table('sys_config')
                ->where('code',$code)
                ->update(['value'=>$value]);
         }
         else{

             DB::table('sys_config')->insert(['code'=>$code,'value'=>$value]);
         }

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 生成分页的json格式数据
    |
    |-------------------------------------------------------------------------------
    */
    public function get_page_info(){

        $total                  = DB::table('goods_gallery')->count();
        $per_page               = 10;
        $last_page              = ceil($total/$per_page);         

        $row        = [

                        'current_page'=>1,
                        'per_page'    =>$per_page,
                        'last_page'   =>$last_page,
                        'total'       =>$total,
        ];

        return $row;
    }
}   
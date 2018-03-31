<?php namespace App\Http\Controllers\Admin;

use DB;
use Excel;
use File;
use HTML;
use Image;
use Input;
use Phpstore\Base\Lang;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormToModel;
use Request;
use Session;
use Validator;


/*
|----------------------------------------------------------------------------------------
|
|  Excel导入导出商品数据信息 
|
|---------------------------------------------------------------------------------------
*/
class ExcelController extends BaseController{



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
        $this->tag                  = 'admin.excel.index';
        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        //定义商品的常用操作链接
        $this->list_url             = 'admin/excel';
        $this->batch_url            = 'admin/excel/batch';
        $this->excel_in             = 'admin/excel/in';
        

        //其他设置
        $this->sysinfo              = new Sysinfo();
        $this->sysinfo->put('url',url($this->list_url));
        $this->sysinfo->put('page',$this->page);
        $this->sysinfo->put('tag',$this->tag);

        //设置excel导入导出的参数
        $this->cols     = [

                                '商品编号',
                                '商品名称',
                                '商品分类',
                                '商品品牌',
                                '商品图片',
                                '商品库存',
                                '新品',
                                '精品',
                                '热卖',
                                '促销',
                                '上架',                  

        ];

        $this->cols_width = [

                                'A'=>15,
                                'B'=>15,
                                'C'=>15,
                                'D'=>15,
                                'E'=>15,
                                'F'=>15,
                                'G'=>15,
                                'H'=>15,
                                'I'=>15,
                                'J'=>15,
                                'L'=>15,
        ];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  显示所有所有商品列表信息
    |  路由：admin/excel
    |  路由名称：admin.excel.index
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){



        $view                       = $this->view('crud.excel');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->list_url,trans('admin.excel_list'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = Lang::get('goods_list');
        $view->grid                 = $this->get_goods_list(20);
        


        //设置批量删除操作的batch_url
        $view->batch_url            = $this->batch_url;
       

        //返回视图模板
        return $view;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  excel批量操作相关
    |  admin.excel.batch
    |
    |-------------------------------------------------------------------------------
    */
    public function batch(){

        $ids            = Request::input('ids');

        if(empty($ids)){

            return $this->sysinfo->batchEmpty();
        }

        
        $excel_name     = date('Y-m-d').'-'.time().md5(uniqid());

        Excel::create($excel_name, function($excel) {

            $excel->sheet('goods-list', function($sheet) {

                

                // Font family
                $sheet->setFontFamily('Arial');

                // Font size
                $sheet->setFontSize(20);
               

                // Font bold
                //$sheet->setFontBold(true);

                // Set width for multiple cells
                $sheet->setWidth($this->cols_width);

                $sheet->row(1,$this->cols);

                $sheet->row(1, function($row) {

                    // call cell manipulation methods
                    $row->setBackground('#0c7cd5');
                    $row->setFontColor('#ffffff');

                });

                $goods_list     = $this->get_goods_list_by_ids(Request::input('ids'));
                if($goods_list){

                    foreach($goods_list as $key=>$value){

                        $sheet->row($key+2,[

                                $value->id,
                                $value->goods_name,
                                $value->cat_name,
                                $value->brand_name,
                                $value->thumb,
                                $value->goods_number,
                                $value->is_new,
                                $value->is_hot,
                                $value->is_best,
                                $value->is_promote,
                                $value->is_on_sale,
                        ]);
                    }
                }

               
            });

        })->store('xls', public_path('excel/exports'))
          ->export('xls');


    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  excel批量操作相关
    |  admin.excel.all
    |
    |-------------------------------------------------------------------------------
    */
    public function all(){


        $excel_name             = date('Y-m-d').'-'.time().md5(uniqid());
        
        $goods_list             = $this->get_goods_list(0);


        return $this->toExcel($excel_name);
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  导出excel表格函数
    |
    |-------------------------------------------------------------------------------
    */
    public function  toExcel($excel_name){



        Excel::create($excel_name, function($excel) {

            $excel->sheet('goods-list', function($sheet) {

                

                // Font family
                $sheet->setFontFamily('Arial');

                // Font size
                $sheet->setFontSize(20);
               

                // Font bold
                //$sheet->setFontBold(true);

                // Set width for multiple cells
                $sheet->setWidth($this->cols_width);

                $sheet->row(1,$this->cols);

                $sheet->row(1, function($row) {

                    // call cell manipulation methods
                    $row->setBackground('#0c7cd5');
                    $row->setFontColor('#ffffff');

                });

                $goods_list         = $this->get_goods_list(0);

                if($goods_list){

                    foreach($goods_list as $key=>$value){

                        $sheet->row($key+2,[

                                $value->id,
                                $value->goods_name,
                                $value->cat_name,
                                $value->brand_name,
                                $value->thumb,
                                $value->goods_number,
                                $value->is_new,
                                $value->is_hot,
                                $value->is_best,
                                $value->is_promote,
                                $value->is_on_sale,
                        ]);
                    }
                }

               
            });

        })->store('xls', public_path('excel/exports'))
          ->export('xls');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  excel导入相关操作
    |  admin.excel.in.get
    |
    |-------------------------------------------------------------------------------
    */
    public function get_in(){

        $view               = $this->view('crud_add');
        $view->page         = $this->page;
        $view->tag          = $this->tag;
        $current_url        = HTML::link($this->excel_in,trans('admin.excel_in'));
        $view->path_url     = $this->get_path_url($current_url);

        $view->action_name  = trans('admin.excel_in');

        //设置参数 通过crud组件生成输入界面表单
        $this->crud->put('row',$this->FormData());
        $this->crud->put('url',url($this->excel_in));
        $view->form         = $this->crud->render();

        return $view;

    } 

    /*
    |-------------------------------------------------------------------------------
    |
    |  excel导入相关操作 post
    |  admin.excel.in.post
    |
    |-------------------------------------------------------------------------------
    */
    public function post_in(){

        if(!Request::hasFile('excel_file')){

            $this->sysinfo->put('info','您未上传文件');
            $this->sysinfo->put('url',url('admin/excel/in'));
            return $this->sysinfo->info();

        }

        $excel_path             = public_path().'/excel';
        $file_name              = date('Y-m-d').md5(uniqid()).'.xls';
        $file                   = Request::file('excel_file');
        $file->move($excel_path, $file_name);

        Excel::load($excel_path.'/'.$file_name, function($reader){

            // Getting all results
            $results = $reader->get();
            // ->all() is a wrapper for ->get() and will work the same
            //$results = $reader->all();

            $reader->dd();

        },'UTF-8');
    }


 
    /*
    |-------------------------------------------------------------------------------
    |
    |  获取所有商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function get_goods_list($page){

        $page           = intval($page);
        $res            = DB::table('goods as g')
                            ->leftjoin('category as c','c.id','=','g.cat_id')
                            ->leftjoin('brand as b','b.id','=','g.brand_id')
                            ->leftjoin('goods_gallery as gg','gg.goods_id','=','g.id')
                            ->select('g.*','c.cat_name','b.brand_name','gg.thumb','gg.img');
        
        
        if($page > 0){

            $res        = $res->paginate($page);
        }
        else{

            $res        = $res->get();
        }

        return $res;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  根据ids获取商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function get_goods_list_by_ids($ids){


        if(empty($ids)){

            return $this->get_goods_list(0);
        }

        $res            = DB::table('goods as g')
                            ->leftjoin('category as c','c.id','=','g.cat_id')
                            ->leftjoin('brand as b','b.id','=','g.brand_id')
                            ->leftjoin('goods_gallery as gg','gg.goods_id','=','g.id')
                            ->select('g.*','c.cat_name','b.brand_name','gg.thumb','gg.img');

        if(count($ids) == 1){

            $res        = $res->where('g.id',$ids[0])
                              ->get();

        }
        else{

            $res       = $res->whereIn('g.id',$ids)
                             ->get();
        }

        return $res;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 添加商品 生成form表单的配置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function FormData(){

        return [

                

                    [
                        'type'          => 'file',
                        'field'         => 'excel_file',
                        'name'          => 'Excel文件',
                        'file_info'     => '',
                        'id'            => 'excel_file',
                        'upload_img'    => ''
                    ],

                    [
                        'type'          => 'submit',
                        'value'         => '确认添加',
                        'id'            => 'cat-submit',
                        'back_url'      => url($this->list_url),
                    ],
        ];

    }

}

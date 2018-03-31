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

include(app_path().'/phpexcel/PHPExcel.php');


/*
|----------------------------------------------------------------------------------------
|
|  Excel导入导出商品数据信息 
|
|---------------------------------------------------------------------------------------
*/
class PhpExcelController extends BaseController{



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
    |  导出所有商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function all(){


            $objPHPExcel = new \PHPExcel();
            $objPHPExcel->getProperties()->setCreator("phpstore")
                                        ->setLastModifiedBy("www.prorigine.com")
                                        ->setTitle("商品数据")
                                        ->setSubject("phpstore商品数据")
                                        ->setDescription("phpstore商品数据")
                                        ->setKeywords("phpstore商品数据")
                                        ->setCategory("");



            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', '商品编号')
                        ->setCellValue('B1', '商品货号')
                        ->setCellValue('C1', '商品名称')
                        ->setCellValue('D1', '商品图片')
                        ->setCellValue('E1', '商品分类')
                        ->setCellValue('F1', '商品品牌')
                        ->setCellValue('G1', '市场价格')
                        ->setCellValue('H1', '销售价格')
                        ->setCellValue('I1', '库存')
                        ->setCellValue('J1','自定义链接')
                        ->setCellValue('K1','新品')
                        ->setCellValue('L1','精品')
                        ->setCellValue('M1','热卖')
                        ->setCellValue('N1','促销')
                        ->setCellValue('O1','上架');

            //获取所有商品列表
            $goods_list     = $this->get_goods_list(0);
            foreach($goods_list as $key=>$goods){

                 $key       = $key + 2;

                  $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$key, $goods->id)
                        ->setCellValue('B'.$key, $goods->goods_sn)
                        ->setCellValue('C'.$key, $goods->goods_name)
                        ->setCellValue('D'.$key, $goods->thumb)
                        ->setCellValue('E'.$key, $goods->cat_name)
                        ->setCellValue('F'.$key, $goods->brand_name)
                        ->setCellValue('G'.$key, $goods->market_price)
                        ->setCellValue('H'.$key, $goods->shop_price)
                        ->setCellValue('I'.$key, $goods->goods_number)
                        ->setCellValue('J'.$key, $goods->diy_url)
                        ->setCellValue('K'.$key, $goods->is_new)
                        ->setCellValue('L'.$key, $goods->is_best)
                        ->setCellValue('M'.$key, $goods->is_hot)
                        ->setCellValue('N'.$key, $goods->is_promote)
                        ->setCellValue('O'.$key, $goods->is_on_sale);




            }

            $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('微软雅黑')->setSize(16);


            $objPHPExcel->getActiveSheet()->setTitle('商品数据表');
            $objWriter          = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

            $file_name          = date('Y-m-d').'-'.time().uniqid();

            $objWriter->save(public_path().'/excel/'.$file_name.'.xls');

            $excel_name         = 'excel/'.$file_name.'.xls';

            $view               = $this->view('crud.excel_info');
            $view->page         = $this->page;
            $view->tag          = $this->tag;
            $view->excel_name   = $excel_name;
            $current_url        = HTML::link($this->list_url,trans('admin.excel_list'));
            $view->path_url     = $this->get_path_url($current_url);

            return $view;


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
    |  excel导入相关操作
    |  admin.excel.in.post
    |
    |-------------------------------------------------------------------------------
    */
    public function post_in(){

        //检测是否上传成功
        if(!Request::hasFile('excel_file')){

            $this->sysinfo->put('info','您未上传文件');
            $this->sysinfo->put('url',url('admin/excel/in'));
            return $this->sysinfo->info();

        }


        if(!Request::file('excel_file')->isValid()){

            $this->sysinfo->put('info','上传文件失败');
            $this->sysinfo->put('url',url('admin/excel/in'));
            return $this->sysinfo->info();

        }

        $file                   = Request::file('excel_file');
        $ext                    = $file->getClientOriginalExtension();
        $ext                    = strtolower($ext);

        if($ext !='xls'){

            $this->sysinfo->put('info','请上传xls格式文件');
            return $this->sysinfo->info();
        }

        $excel_path             = public_path().'/excel';
        $file_name              = date('Y-m-d').md5(uniqid()).'.xls';
        $file->move($excel_path, $file_name);




            //创建excel读取
            $objReader      = \PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel    = \PHPExcel_IOFactory::load($excel_path.'/'.$file_name);




            $sheet          = $objPHPExcel->getSheet(0); 
            //总行数   
            $highestRow     = $sheet->getHighestRow();
            //总列数 
            $highestColumn  = $sheet->getHighestColumn();

            $data           = [];

            
            
            for($row = 2 ; $row <= $highestRow ; $row ++ ){

                
               
                $data[$row-2]['goods_sn']           = $objPHPExcel->getActiveSheet()->getCell("A$row")->getValue();
                $data[$row-2]['goods_name']         = $objPHPExcel->getActiveSheet()->getCell("B$row")->getValue();
                $data[$row-2]['goods_thumb']        = $objPHPExcel->getActiveSheet()->getCell("C$row")->getValue();
                $data[$row-2]['cat_id']             = $objPHPExcel->getActiveSheet()->getCell("D$row")->getValue();
                $data[$row-2]['brand_id']           = $objPHPExcel->getActiveSheet()->getCell("E$row")->getValue();
                $data[$row-2]['market_price']       = $objPHPExcel->getActiveSheet()->getCell("F$row")->getValue();
                $data[$row-2]['shop_price']         = $objPHPExcel->getActiveSheet()->getCell("G$row")->getValue();
                $data[$row-2]['goods_number']       = $objPHPExcel->getActiveSheet()->getCell("H$row")->getValue();
                $data[$row-2]['diy_url']            = $objPHPExcel->getActiveSheet()->getCell("I$row")->getValue();
                $data[$row-2]['is_new']             = $objPHPExcel->getActiveSheet()->getCell("J$row")->getValue();
                $data[$row-2]['is_best']            = $objPHPExcel->getActiveSheet()->getCell("K$row")->getValue();
                $data[$row-2]['is_hot']             = $objPHPExcel->getActiveSheet()->getCell("L$row")->getValue();
                $data[$row-2]['is_promote']         = $objPHPExcel->getActiveSheet()->getCell("M$row")->getValue();
                $data[$row-2]['is_on_sale']         = $objPHPExcel->getActiveSheet()->getCell("N$row")->getValue();
                
                
                 
            }

             if(DB::table('goods')->insert($data)){

                  $info         = '成功导入商品数据到数据库，共计：'.count($data);
                  $this->sysinfo->put('info',$info);
                  $this->sysinfo->put('url',url('admin/excel'));
                  return $this->sysinfo->info();
             }

                 $this->sysinfo->put('info','导入失败');
                 return $this->sysinfo->info();

            

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
                        'type'          =>'text_disabled',
                        'field'         =>'test_name',
                        'name'          =>'示例excel文件',
                        'value'         =>url('excel/example/test.xls'),
                        'id'            =>'test_name',
                    ],
                    [
                        'type'          => 'submit',
                        'value'         => '确认添加',
                        'id'            => 'cat-submit',
                        'back_url'      => url($this->list_url),
                    ],
        ];

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

}
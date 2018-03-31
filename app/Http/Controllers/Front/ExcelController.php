<?php
/*
|-------------------------------------------------------------------------------
|
|  新闻前端控制器
|
|-------------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Front;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Session;
use Phpstore\Base\Common;
use App\Models\Article;
use Excel;
use DB;

class ExcelController extends BaseController
{

    public $cols;
    public $cols_width;
    public $cols_height;
    /*
    |-------------------------------------------------------------------------------
    |
    |  构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct()
    {

        parent::__construct();

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
    |  excel 测试函数
    |
    |-------------------------------------------------------------------------------
    */
    public function excel(){


        Excel::create('testname', function($excel) {

            $excel->sheet('Sheetname', function($sheet) {

                $sheet->setOrientation('landscape');

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

                $goods_list         = $this->get_goods_list();

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

        })->store('xls', public_path('excel/exports'));
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取商品信息
    |
    |-------------------------------------------------------------------------------
    */
    public function get_goods_list(){

        $res            = DB::table('goods as g')
                            ->leftjoin('category as c','c.id','=','g.cat_id')
                            ->leftjoin('brand as b','b.id','=','g.brand_id')
                            ->leftjoin('goods_gallery as gg','gg.goods_id','=','g.id')
                            ->select('g.*','gg.thumb','c.cat_name','b.brand_name')
                            ->get();
        return $res;
    }

}

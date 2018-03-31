<?php

namespace App\Http\Controllers;

use DB;
use App\Services\OSS;

class IndexController extends Controller
{



	public function index(){

		$row                        = DB::table('goods')->get();
        $arr                        = [];

        foreach($row as $item){

            $arr[]          = [

                                'id'=>$item->id,
                                'goods_name'=>$item->goods_name,
                                'shop_price'=>$item->shop_price,
                              ];
        }



        $data   			= [];

        $data['slider']     = ['img_src'=>'...','img_url'=>'http://www.prorigine.com'];
        $data['new_goods']  = [];
        $data['goods'] = $arr;


        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function oss(){

        OSS::upload('swhabctest',public_path().'/images/201601/04f561883dbad365574909d216b29a5d.JPG');
        echo OSS::getUrl('swhabctest'); // 打印出某个文件的外网链接;
    }

	


}
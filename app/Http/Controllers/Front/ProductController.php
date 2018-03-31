<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Models\GoodsAttr;
use App\Models\Product;

class ProductController extends BaseController
{
    



    /*
    |-------------------------------------------------------------------------------
    |
    | 处理ajax的函数
    |
    |-------------------------------------------------------------------------------
    */
    public function ajax(){

        $info                   = request()->info;
        $info                   = json_decode($info);

        $goods_id               = intval($info->goods_id);
        $id                     = intval($info->id);
        $id2                    = intval($info->id2);
        $tag                    = intval($info->tag);
        $arr                    = [];

        //如果是第一组属性
        if($tag == 1){

            $arr                = $this->get_attr_linked_list($goods_id ,$id);
        }

       


        $data                   = DB::table('product')
                                    ->where('goods_id',$goods_id)
                                    ->where('goods_attr',$id.'-'.$id2)
                                    ->first();

        if($data){

            return $this->toJSON([
                                        'arr'           =>$arr,
                                        'product_sn'    =>$data->product_sn,
                                        'product_number'=>$data->product_number,
                                        'tag'           =>$tag,
                                    ]);
        }
        else{

                return $this->toJSON(['arr'=>$arr,'tag'=>$tag]);
        }



    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取第一个属性相关联的所有属性数组
    | 
    |  goods_attr  = '67-71','67-81','67-12'
    |  现在要获取[71,81,12]这个数组
    |
    |-------------------------------------------------------------------------------
    */
    public function get_attr_linked_list($goods_id ,$id){

        $res                = DB::table('product')
                                ->where('goods_id',$goods_id)
                                ->where('goods_attr','like',$id.'-%')
                                ->get();

        $arr                = [];
        //如果是空 则直接返回
        if(empty($res)){

            return $arr;
        }

        foreach($res as $item){

            //获取属性字符串 类似'67-12'的形式
            $goods_attr     = $item->goods_attr;
            //转化成数组 把'67-12' 转成 [67,12]
            $temp_arr       = explode('-',$goods_attr);

            //合并数组
            $arr            = array_merge($arr , $temp_arr);
        }

            //去除数组中 重复的元素
            $arr            = array_unique($arr);

            //去掉数组中主元素 $id
            if(($key = array_search($id, $arr)) !== false) {
                
                unset($arr[$key]);
            }

            return $arr;
    }

}

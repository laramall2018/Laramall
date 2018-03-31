<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Shipping;

class ShippingController extends ApiController
{
   

    public $tag;
    public $info;
    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(){

        $this->tag          = 'success';
        $this->info         = 'success';
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取所有激活的配送方式列表
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){

        $shipping_list      = Shipping::where('tag',1)->get();
        $tag                = $this->tag;
        $info               = $this->info;

        return $this->respond(['data'=>compact('tag','info','shipping_list')]);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取配送方式详细信息
    |
    |-------------------------------------------------------------------------------
    */
    public function show(){

        $shipping_id        = request()->shipping_id;
        $shipping           = Shipping::find($shipping_id);
        $tag                = $this->tag;
        $info               = $this->info;
        if(empty($shipping)){
            return $this->respondCommonError('配送方式未选择');
        }
        return $this->respond(['data'=>compact('tag','info','shipping')]);
    }


}

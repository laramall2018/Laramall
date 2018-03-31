<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use LaraStore\Forms\Brand\ShowForm;

class BrandController extends ApiController
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
    | 获取品牌下的商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function goods(){
        $form               = new ShowForm($this);
        return ($form->isValid())? $form->successRespond(): $form->errorRespond();
    }
}

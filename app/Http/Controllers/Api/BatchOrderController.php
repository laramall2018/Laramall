<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Api\ApiController as API;
use LaraStore\Forms\BatchOrder\MakeToArrForm;
use LaraStore\Forms\BatchOrder\OrderForm;

class BatchOrderController extends API
{

    protected $tag;
    protected $info;
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
    | post请求 把客户输入的字符串转化成数组
    |
    |-------------------------------------------------------------------------------
    */
    public function createForm(){

        $form           = new MakeToArrForm($this);
        return ($form->auth() && $form->isValid() &&($form->orderCheck()))? $form->successRespond() : $form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | post请求 根据客户输入的表单 递交表单 生成订单数据
    |
    |-------------------------------------------------------------------------------
    */
    public function order(){

        $form           = new OrderForm($this);
        return ($form->auth() && $form->isValid()) ? $form->successRespond():$form->errorRespond();
    }
    
}

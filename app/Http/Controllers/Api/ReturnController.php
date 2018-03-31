<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\OrderReturn;
use App\User;
use Auth;
use LaraStore\Forms\OrderReturn\ShowForm;
use LaraStore\Forms\OrderReturn\StoreForm;
use LaraStore\Forms\OrderReturn\DeleteForm;

class ReturnController extends ApiController
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
    | 返回退货单列表
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){
        $form               = new ShowForm($this);
        return ($form->auth())? $form->successRespond() : $form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 存储
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){
        $form             = new StoreForm($this);
        return ($form->auth() && $form->isValid())? $form->successRespond() : $form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 删除退货单
    |
    |-------------------------------------------------------------------------------
    */
    public function delete(){
        $form           = new DeleteForm($this);
        return ($form->isValid())? $form->successRespond() : $form->errorRespond();
    }
}

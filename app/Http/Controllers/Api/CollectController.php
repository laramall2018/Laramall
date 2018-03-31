<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\Models\CollectGoods;
use LaraStore\Forms\Collect\ShowForm;
use LaraStore\Forms\Collect\DeleteForm;
use LaraStore\Forms\Collect\StoreForm;

class CollectController extends ApiController
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
    | 获取列表
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){
        $form           = new ShowForm($this);
        return ($form->auth())? $form->successRespond() : $form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 存储 store
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){
        $form          = new StoreForm($this);
        return ($form->isValid())?$form->successRespond():$form->errorRespond();
    }




    /*
    |-------------------------------------------------------------------------------
    |
    | 删除收藏
    |
    |-------------------------------------------------------------------------------
    */
    public function delete(){
        $form           = new DeleteForm($this);
        return ($form->auth() && $form->isValid())? $form->successRespond() : $form->errorRespond();
    }
}

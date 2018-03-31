<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Account;
use LaraStore\Forms\Account\ShowForm;
use LaraStore\Forms\Account\StoreForm;


class AccountController extends ApiController
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
    | 存储
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){
        $form           = new StoreForm($this);
        return ($form->auth()&& $form->isValid())? $form->successRespond():$form->errorRespond();
    }
}

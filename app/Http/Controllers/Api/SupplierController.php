<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use LaraStore\Forms\Supplier\RegisterForm;
use LaraStore\Forms\Supplier\LoginForm;

class SupplierController extends ApiController
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
    | 注册
    |
    |-------------------------------------------------------------------------------
    */
    public function register(){
        $form       =  new RegisterForm($this);
        return ($form->isValid())? $form->successRespond() : $form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 登录
    |
    |-------------------------------------------------------------------------------
    */
    public function login(){
        $form       = new LoginForm($this);
        return ($form->isValid() && $form->login())? $form->successRespond() : $form->errorRespond();
    }
}

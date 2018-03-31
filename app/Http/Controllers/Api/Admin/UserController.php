<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Api\ApiController as API;
use App\Models\Admin;
use LaraStore\Forms\Admin\LoginForm;


class UserController extends API
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
    public function login(){
        $form           = new LoginForm($this);
        return ($form->isValid() && $form->login())? $form->successRespond() : $form->errorRespond();
    }
}

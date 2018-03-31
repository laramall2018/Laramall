<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use LaraStore\Forms\MessageForm;
use LaraStore\Forms\MessageDeleteForm;
use LaraStore\Forms\MessageStoreForm;
use App\User;
use Auth;

class MessageController extends ApiController
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
    | 获取用户的留言列表
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){
        $form           = new MessageForm($this);
        return ($form->auth())? $form->successRespond() : $form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  删除留言
    |
    |-------------------------------------------------------------------------------
    */
    public function delete(){
        $form           = new MessageDeleteForm($this);
        return ($form->isValid())? $form->successRespond() : $form->errorRespond();
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  前台添加留言
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){
        $form           = new MessageStoreForm($this);
        return ($form->auth() && $form->isValid())? $form->successRespond() : $form->errorRespond();
    }
}
<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use LaraStore\Forms\Comment\ShowForm;
use LaraStore\Forms\Comment\StoreForm;

class CommentController extends ApiController
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
    | 获取列表
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){
        $form           = new ShowForm($this);
        return ($form->isValid())? $form->successRespond() : $form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 存储列表
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){
        $form           = new StoreForm($this);
        return ($form->isAllCheck())? $form->successRespond() : $form->errorRespond();
    }


}

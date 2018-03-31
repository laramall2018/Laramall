<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Category;
use LaraStore\Forms\Category\ShowForm;
use LaraStore\Forms\Category\GridForm;

class CatController extends ApiController
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
    public function index($id){
        $form           = new ShowForm($this,$id);
        return ($form->isValid())? $form->successRespond() : $form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | grid 获取数据
    |
    |-------------------------------------------------------------------------------
    */
    public function grid(){
        $form            = new GridForm($this);
        return ($form->isValid())? $form->successRespond() : $form->errorRespond();
    }
}

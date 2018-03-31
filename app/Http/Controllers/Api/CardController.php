<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Card;
use LaraStore\Forms\Card\CheckForm;

class CardController extends ApiController
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
    |  检测礼品卡是否有效
    |
    |-------------------------------------------------------------------------------
    */
    public function check(){

        $form               = new CheckForm($this);
        return ($form->allValid())? $form->successRespond() : $form->errorRespond();
    }
}

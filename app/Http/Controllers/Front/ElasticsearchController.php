<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Goods;

class ElasticsearchController extends Controller
{
    
    public $esc;
    public $client;

    /*
    |-------------------------------------------------------------------------------
    |
    | 显示es首页
    |
    |-------------------------------------------------------------------------------
    */
    public function index()
    {

        
        //$res    = Goods::es_all();

        $res      = Goods::search('goods_name','特斯拉');

        dd($res['hits']['hits']);



           
    }


    

    
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Goods;
use App\Models\Cart;
use App\User;
use Artisan;
use Auth;
use App\Models\Image;

class IndexController extends ApiController
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
    | 获取首页热卖商品 促销商品  新品 精品商品信息
    |
    |-------------------------------------------------------------------------------
    */
    public function getGoodsJson(){

        return  $this->toJsON();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 返回所有的记录
    |
    |-------------------------------------------------------------------------------
    */
    public function toJsON(){

        $hot                            = Goods::recommend('hot');
        $best                           = Goods::recommend('best');
        $new                            = Goods::recommend('new');
        $hot_ad                         = Image::getValue('hot_ad');
        $tag                            = $this->tag;
        $info                           = $this->info;
        $arr                            =[ 
                                            'hot',//热卖商品
                                            'best',//精品
                                            'new',//新品
                                            'hot_ad',//热卖产品的广告
                                            'tag',//执行结果
                                            'info',//弹出信息
                                         ];
        
        return $this->respond(['data'=>compact($arr)]);

    }
}

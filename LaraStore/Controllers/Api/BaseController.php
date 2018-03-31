<?php

namespace LaraStore\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;
use App\User;
use Symfony\Component\HttpFoundation\Response as SfResponse;
use Auth;

class BaseController extends Controller
{
    protected $statusCode  = SfResponse::HTTP_OK;

    /*
    |-------------------------------------------------------------------------------
    |
    |  获取状态码
    |
    |-------------------------------------------------------------------------------
    */
    public function getStatusCode(){

        return $this->statusCode;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  设置状态码 并返回对象本身
    |
    |-------------------------------------------------------------------------------
    */
    public function setStatusCode($statusCode){

        $this->statusCode       =  $statusCode;
        return $this;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  未找到数据 返回404  Not Found 
    |
    |-------------------------------------------------------------------------------
    */
    public function respondNotFound($message = 'Not Found'){

         return $this->setStatusCode(SfResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  返回错误结果
    |
    |-------------------------------------------------------------------------------
    */
    public function respondWithError($message){

        return  $this->respond([

                        'error'     =>[
                                        'message'       => $message,
                                        'status_code'   => $this->getStatusCode(),
                        ],
            ]);
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  返回json格式数据
    |
    |-------------------------------------------------------------------------------
    */
    public function respond($data,$headers = []){

        return response()->json($data,$this->getStatusCode(),$headers);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  未登录 返回错误提示
    |
    |-------------------------------------------------------------------------------
    */
    public function notLoginError(){

        $info               = '用户未登录';
        return $this->respondCommonError($info);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  没有收货地址
    |
    |-------------------------------------------------------------------------------
    */
    public function notAddressError(){

        $info               = '收货地址为空';
        return $this->respondCommonError($info);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  购物车为空
    |
    |-------------------------------------------------------------------------------
    */
    public function cartEmptyError(){

        $info               = '购物车中没有被选中的商品';
        return $this->respondCommonError($info);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取错误信息 组合成字符串
    |
    |-------------------------------------------------------------------------------
    */
    public function getErrors($validator){
        $str                = '';
        $messages           = $validator->messages();
        foreach($messages->all() as $message){
            $str            .='<p style="color:red;line-height:30px;"><i class="fa fa-times"></i>'
                            .$message
                            .'</p>';
        }
        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  通用错误提示  返回200
    |
    |-------------------------------------------------------------------------------
    */
    public function respondCommonError($info){
        $tag                = 'error';
        return $this->respond(['data'=>compact('tag','info')]);
    }

}

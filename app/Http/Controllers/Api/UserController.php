<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Models\UserAddress;
use App\Models\Region;
use Validator;
use Session;
use LaraStore\Sms\Sms;
use LaraStore\Forms\RegisterForm;
use LaraStore\Forms\LoginForm;
use LaraStore\Forms\SmsForm;
use LaraStore\Forms\UploadIconForm;
use LaraStore\Forms\UserInfoForm;
use LaraStore\Forms\UserUpdateForm;
use LaraStore\Forms\UserTagForm;
use LaraStore\Forms\UserTagDeleteForm;
use LaraStore\Forms\userTagAddForm;
use LaraStore\Forms\User\ShowPayForm;
use LaraStore\Forms\User\PayFormAct;
use App\Http\Controllers\Front\BaseController;
use LaraStore\Forms\User\ForgetForm;
use LaraStore\Forms\User\ResetForm;


class UserController extends ApiController
{
    public $tag;
    public $info;
    public $form;
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
    public function address(){

        if(!Auth::check('user')){
            $this->info      = '未登录无法获取地址信息';            
            return $this->respondNotFound($this->info);
        }

        $user                = Auth::user('user');
        $address_list        = $user->address()->get();
        $province_list       = Region::childList(1,1);
        $city_list           = [];
        $district_list       = [];
        $tag                 = $this->tag;
        $info                = $this->info;

        $arr                 = [
                                    'tag',
                                    'info',
                                    'address_list',
                                    'province_list',
                                    'city_list',
                                    'district_list',
                                ];
        return $this->respond(['data'=>compact($arr)]);
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 设置默认地址
    |
    |-------------------------------------------------------------------------------
    */
    public function addressDefault(){

        if(!Auth::check('user')){
            $this->info      = '未登录无法获取地址信息';            
            return $this->respondNotFound($this->info);
        }

        $user                = Auth::user('user');
        $id                  = request()->id;
        $address             = UserAddress::find($id);

        if(empty($address)){
            $this->info      = '程序异常';
            return $this->respondNotFound($this->info);
        }

        $user->address_id    = $id;
        $user->save();
        $address_list        = $user->address()->get();
        $tag                 = $this->tag;
        $info                = $this->info;
        return $this->respond(['data'=>compact('tag','info','address_list')]);
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 省会城市地区三级ajax查询
    |
    |-------------------------------------------------------------------------------
    */
    public function pcd(){

        $region_id          = request()->region_id;
        $region             = region::find($region_id);
        $tag                = $this->tag;
        $info               = $this->info;
        if(empty($region)){
            $tag            = 'error';
            $info           = 'error';
            return $this->respond(['data'=>compact('tag','info')]);
        }
        $city_list          = [];
        $district_list      = [];
        $child_list         = Region::where('parent_id',$region_id)->get();
        $type               = $region->region_type;

        if($type == 1){
            $city_list      = $child_list;
        }
        elseif($type == 2){
            $district_list  = $child_list;
        }
        return $this->respond(['data'=>compact('tag','info','city_list','district_list','type')]);
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 更新地址信息
    |
    |-------------------------------------------------------------------------------
    */
    public function update(){

        if(!Auth::check('user')){

            $tag            = 'error';
            $info           = '用户未登录';
            return $this->respond(['data'=>compact('tag','info')]);
        }

        $param              = request()->param;
        $param              = json_decode($param);
        //获取参数信息
        $id                 = $param->id;
        $province           = $param->province;
        $city               = $param->city;
        $district           = $param->district;
        $address            = $param->address;
        $consignee          = $param->consignee;
        $phone              = $param->phone;
        //获取模型
        $model              = UserAddress::find($id);
        //模型为空
        if(empty($model)){
            $tag            = 'error';
            $info           = '模型为空 异常';
            return $this->respond(['data'=>compact('tag','info')]);
        }
        //更新地址信息
        $model->update(compact('province','city','district','address','consignee','phone'));
        //获取地址信息
        $user                = Auth::user('user');
        $address_list        = $user->address()->get();
        $tag                 = $this->tag;
        $info                = $this->info;
        return $this->respond(['data'=>compact('tag','info','address_list')]);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 存储地址
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){

        if(!Auth::check('user')){

            $tag            = 'error';
            $info           = '用户未登录';
            return $this->respond(['data'=>compact('tag','info')]);
        }
        //获取参数
        $param              = request()->param;
        $param              = json_decode($param);
        $consignee          = $param->consignee;
        $phone              = $param->phone;
        $address            = $param->address;
        $province           = $param->province;
        $city               = $param->city;
        $district           = $param->district;
        $country            = 1;
        $user               = Auth::user('user');
        $user_id            = $user->id;
        $arr                = [
                                 'consignee',
                                 'phone',
                                 'country',
                                 'province',
                                 'city',
                                 'district',
                                 'address',
                                 'user_id',
                              ];

        $rules              = [
                                'phone'         =>'required|min:11|max:11',
                                'province'      =>'required',
                                'city'          =>'required',
                                'district'      =>'required',
                                'address'       =>'required',
                                'consignee'     =>'required',

        ];
        $validator          = Validator::make(compact($arr),$rules);
        if($validator->fails()){
            $tag            = 'error';
            $info           = '数据不完整';
            return $this->respond(['data'=>compact('tag','info')]);
        }
        //插入数据
        $model              = UserAddress::create(compact($arr));
        //设置为默认地址
        $user->address_id   = $model->id;
        $user->save();
        //获取地址信息
        $address_list        = $user->address()->get();
        $tag                 = $this->tag;
        $info                = $this->info;
        return $this->respond(['data'=>compact('tag','info','address_list')]);

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 删除地址
    |
    |-------------------------------------------------------------------------------
    */
    public function delete(){

        if(!Auth::check('user')){

            $tag                    = 'error';
            $info                   = '用户未登录';
            return $this->respond(['data'=>compact('tag','info')]);
        }

        $id                         = request()->id;
        $model                      = UserAddress::find($id);
        if(empty($model)){
            $tag                    = 'error';
            $info                   = '程序异常';
            return $this->respond(['data'=>compact('tag','info')]);
        }
        $user                       = Auth::user('user');
        if($model->isDefault == 1){
            $tag                    = 'error';
            $info                   = '默认地址禁止删除';
            return $this->respond(['data'=>compact('tag','info')]);
        }
        //删除地址
        $model->delete();
        $address_list        = $user->address()->get();
        $tag                 = $this->tag;
        $info                = $this->info;
        return $this->respond(['data'=>compact('tag','info','address_list')]);
    }


  

    /*
    |-------------------------------------------------------------------------------
    |
    | 用户登录 post
    |
    |-------------------------------------------------------------------------------
    */
    public function login(){
        $form          = new LoginForm($this);
        return ($form->isValid() && $form->login())? $form->successRespond() : $form->errorRespond();
    }


    
    /*
    |-------------------------------------------------------------------------------
    |
    | 用户注册 post
    |
    |-------------------------------------------------------------------------------
    */
    public function register(){
        $form       = new RegisterForm($this,new Sms);
        return ($form->isValid())? $form->successRespond() : $form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 编辑用户头像
    |
    |-------------------------------------------------------------------------------
    */
    public function uploadUserIcon(){
        $form           = new UploadIconForm($this);
        return ($form->isValid())? $form->successRespond():$form->errorRespond();

    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 发送手机短信验证码
    |
    |-------------------------------------------------------------------------------
    */
    public function getSms(){
       $form        = new SmsForm($this,new Sms);
       return ($form->isValid())? $form->successRespond() : $form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取用户信息
    |
    |-------------------------------------------------------------------------------
    */
    public function show(){
        $form       = new UserInfoForm($this);
        return ($form->auth())?  $form->successRespond() : $form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 更新用户资料
    |
    |-------------------------------------------------------------------------------
    */
    public function updateUser(){
        $form       = new UserUpdateForm($this,Auth::user('user'));
        return ($form->isValid())?  $form->successRespond() : $form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取用户添加的商品标签
    |
    |-------------------------------------------------------------------------------
    */
    public function tag(){
        $form           = new UserTagForm($this);
        return ($form->auth())?  $form->successRespond() : $form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 删除标签
    |
    |-------------------------------------------------------------------------------
    */
    public function tagDelete(){
        $form           = new UserTagDeleteForm($this);
        return ($form->isValid())? $form->successRespond() : $form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 添加标签
    |
    |-------------------------------------------------------------------------------
    */
    public function tagAdd(){
        $form           = new UserTagAddForm($this);
        return ($form->isValid()&& $form->auth())? $form->successRespond() : $form->errorRespond();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 用于余额支付显示
    |
    |-------------------------------------------------------------------------------
    */
    public function accountPay($order_id){
        
         $form          =  new ShowPayForm(new BaseController() , $order_id);
         return ($form->isValid())? $form->successRespond() : $form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 执行余额支付
    |
    |-------------------------------------------------------------------------------
    */
    public function accountPayAct(){

        $form           = new PayFormAct($this);
        return ($form->isValid())? $form->successRespond() : $form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 显示表单
    |
    |-------------------------------------------------------------------------------
    */
    public function forgetPassword(){

        $form           = new ForgetForm(new BaseController());
        return $form->successRespond();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 充值密码表单
    |
    |-------------------------------------------------------------------------------
    */
    public function resetPassword(){

        $form           = new ResetForm($this);
        return ($form->allValid())? $form->successRespond() : $form->errorRespond();
    }

}

<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Phpstore\Base\Common;
use App\Models\UserAddress;
use DB;
use App\User;
use Auth;
use Validator;

class AddressController extends BaseController
{
    
    public $common;
    public $login_url;
    public $list_url;
    public $menu_tag;


    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct()
    {
        
        parent::__construct();

        $this->common           = new Common();
        $this->list_url         = 'auth/address';
        $this->login_url        = 'auth/login';
        $this->menu_tag         = 'address'; 

        //中间件 检测用户是否为前台登录用户
        $this->middleware('front.auth');

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 显示所有地址列表
    |
    |-------------------------------------------------------------------------------
    */
    public function index()
    {
        
        
        $view                       = $this->view('user_address_list');
        $view->menu_tag             = $this->menu_tag;
        $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.address_list'));
        $view->breadcrumb_mobile    = $this->breadcrumb_mobile(trans('front.address_list'),url('auth/address'));
        $view->address_list         = $this->common->get_user_address_list();
        $view->province_list        = $this->get_region_list(1);
        $view->user                 = Auth::user('user');

        return $view;

    } 

    

    /*
    |-------------------------------------------------------------------------------
    |
    | 存储表单数据到数据库
    |
    |-------------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        
        $model              = new UserAddress();
        $rules              = [
                                'consignee'     =>'required',
                                'email'         =>'required|unique:user_address,email',
                                'phone'         =>'required',
                                'address'       =>'required',
                                'province'      =>'required',
                                'city'          =>'required',
                                'district'      =>'required',
        ];

        $validator          = Validator::make($request->all(),$rules);
        if($validator->fails()){

                return $this->validator_is_fails($validator,$this->list_url);
        }

        $row                  = ['consignee','email','phone','address','province','city','district','zipcode'];

        foreach($row as $item){

            $model->$item     = $request->$item;
        }
            $model->country   = 1;
            $model->user_id   = Auth::user('user')->id;

        if($model->save()){

            return redirect($this->list_url);
        }
        else{

            return $this->store_or_update_is_fails($this->list_url);
        }
    }

    


    /*
    |-------------------------------------------------------------------------------
    |
    | 编辑
    |
    |-------------------------------------------------------------------------------
    */
    public function edit($id)
    {
        

        $model                          =  UserAddress::find($id);

        if(empty($model)){

             return $this->model_is_empty($this->list_url);

        }


        $view                           = $this->view('user_address_edit');
        $view->breadcrumb               = $this->common->get_breadcrumb(trans('front.address_list'));
        $view->menu_tag                 = $this->menu_tag;
        $view->model                    = $model;
        $view->province_list            = $this->get_region_list(1);
        $view->city_str                 = $this->get_region_name($model->city);
        $view->district_str             = $this->get_region_name($model->district);
        $view->back_url                 = url($this->list_url);
        return $view;

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 更新数据库记录
    |
    |-------------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        
        $model                      = UserAddress::find($request->id);

        if(empty($model)){

            return $this->model_is_empty($this->list_url);
        }

        $rules              = [
                                'consignee'     =>'required',
                                'email'         =>'required|unique:user_address,email,'.$id,
                                'phone'         =>'required',
                                'address'       =>'required',
                                'province'      =>'required',
                                'city'          =>'required',
                                'district'      =>'required',
        ];

        $validator          = Validator::make($request->all(),$rules);
        if($validator->fails()){

                return $this->validator_is_fails($validator,$this->list_url);
        }

        $row                            = ['consignee','email','phone','address','province','city','district','zipcode'];

        foreach($row as $item){

            $model->$item               = $request->$item;
        }
            $model->country             = 1;

        if($model->save()){

            return redirect($this->list_url);
        }
        else{

            return $this->store_or_update_is_fails($this->list_url);
        }

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 删除记录
    |
    |-------------------------------------------------------------------------------
    */
    public function destroy($id)
    {
         
         $model             = UserAddress::find($id);

         if(empty($model)){

                return $this->model_is_empty($this->list_url);
         }

         if($model->delete()){

            //更新用户的默认地址
            $user           = Auth::user('user');
            //用户默认地址是该地址
            if($user->address_id == $id){

                $user->address_id  = 0;
                $user->save();
            }
            return redirect($this->list_url);
         }
         else{

            return $this->operate_database_is_fails($this->list_url);
         }
    }



    

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取所有省会城市地址
    |
    |-------------------------------------------------------------------------------
    */
    public function get_region_list($type){

        $row            = DB::table('region')
                            ->where('region_type',$type)
                            ->get();

        return $row;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取地区的名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_region_name($region_id){

        $res                = DB::table('region')->where('region_id',$region_id)->first();

        if($res){

            return $res->region_name;
        }

        return '';
    }

} 

<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Phpstore\Base\Common;
use App\Models\Sms;
use DB,Auth,Validator;

class SmsController extends BaseController
{
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
        $this->list_url         = 'auth/sms';
        $this->menu_tag         = 'sms'; 

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
        
        
        $view                       = $this->view('user_sms_list');
        $view->menu_tag             = $this->menu_tag;
        $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.sms_list'));
        $view->sms_list             = $this->common->get_sms_list();
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
        
        $model              = new Sms();
        $rules              = [
                                'sms_content'         =>'required',
                               
                                
        ];

        $validator          = Validator::make($request->all(),$rules);
        if($validator->fails()){

                return $this->validator_is_fails($validator,$this->list_url);
        }

        $row                  = ['sms_content'];

        foreach($row as $item){

            $model->$item     = $request->$item;
        }
            $model->post_time  = time();
            $model->user_id    = Auth::user('user')->id;
            $model->ip         = $request->getClientIp();

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
         
         $model             = Sms::find($id);

         if(empty($model)){

                return $this->model_is_empty($this->list_url);
         }

         if($model->delete()){

            return redirect($this->list_url);
         }
         else{

            return $this->operate_database_is_fails($this->list_url);
         }
    }


}

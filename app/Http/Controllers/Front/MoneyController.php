<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Phpstore\Base\Common;
use DB,Auth,Validator;
use App\Models\Account;

class MoneyController extends BaseController
{
    public $common;
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
        $this->list_url         = 'auth/money';
        $this->menu_tag         = 'money'; 

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
        
        
        $view                = $this->view('account');
        $view->menu_tag      = $this->menu_tag;
        $view->breadcrumb    = $this->common->get_breadcrumb(trans('front.account_list'));
        $view->account_list  = DB::table('users_account')
                                        ->where('username',Auth::user('user')->username)
                                        ->paginate(20);
        $view->total_amount  = $this->common->get_user_account_amount(Auth::user('user')->username);
        $view->user          = Auth::user('user');
        


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
        
        $model              = new Account();
        $rules              = ['amount'=>'required','type'=>'required','payment'=>'required'];

        $validator          = Validator::make($request->all(),$rules);
        if($validator->fails()){

                return $this->validator_is_fails($validator,$this->list_url);
        }

        $row                  = ['type','amount','payment','user_note'];

        foreach($row as $item){

            $model->$item     = $request->$item;
        }
            $model->add_time  = time();
            $model->username  = Auth::user('user')->username;
            $model->ip        = $request->getClientIp();
            $model->pay_tag   = 0;
            $model->sort_order = 0;

        if($model->save()){

            return redirect($this->list_url);
        }
        else{

            return $this->store_or_update_is_fails($this->list_url);
        }
    } 

}

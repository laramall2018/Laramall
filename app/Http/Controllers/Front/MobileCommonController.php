<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Phpstore\Mobile\Common;
use App\User;

class MobileCommonController extends BaseController
{

    public $common;
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
        $this->middleware('mobile.auth');
        $this->common       = new Common();
           
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($model)
    {
         //获取函数
         $func_name         = $model.ucfirst(__FUNCTION__);

         //如果存在该方法 则返回该方法
         if(method_exists($this->common,$func_name)){

            return call_user_func([$this->common,$func_name]);
         }

         return $this->view('404');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($model)
    {
        //获取函数
         $func_name         = $model.ucfirst(__FUNCTION__);

         //如果存在该方法 则返回该方法
         if(method_exists($this->common,$func_name)){

            return call_user_func([$this->common,$func_name]);
         }

         return $this->view('404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($model)
    {
         //获取函数
         $func_name         = $model.ucfirst(__FUNCTION__);
         //如果存在该方法 则返回该方法
         if(method_exists($this->common,$func_name)){

            return call_user_func([$this->common,$func_name]);
         }

         return $this->view('404');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($model,$id)
    {
        //获取函数
         $func_name         = $model.ucfirst(__FUNCTION__);
         //如果存在该方法 则返回该方法
         if(method_exists($this->common,$func_name)){

            return call_user_func([$this->common,$func_name],$id);
         }

         return $this->view('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($model,$id)
    {
        //获取函数
        $func_name         = $model.ucfirst(__FUNCTION__);
        //如果存在该方法
        if(method_exists($this->common,$func_name)){
            //返回该方法
            return call_user_func([$this->common,$func_name],$id);
        }

        return $this->view('404');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($model)
    {
        //获取函数
        $func_name         = $model.ucfirst(__FUNCTION__);
        if(method_exists($this->common,$func_name)){
            return call_user_func([$this->common,$func_name]);
        }

        return $this->view('404');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($model,$id)
    {
        //获取函数
        $func_name         = $model.ucfirst(__FUNCTION__);
        //检测方法是否存在
        if(method_exists($this->common,$func_name)){
            return call_user_func([$this->common,$func_name],$id);
        }

        return $this->view('404');
    }

    /**
     * 处理模型的ajax
     *
     * @param  string $model
     * @return  function 
     */
    public function ajax($model){

        //获取函数
        $func_name         = $model.ucfirst(__FUNCTION__);
        //检测方法是否存在
        if(method_exists($this->common,$func_name)){
            return call_user_func([$this->common,$func_name]);
        }

        return $this->view('404');

    }

}

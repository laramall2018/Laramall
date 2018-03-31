<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use App\Models\Region;
use App\User;
use Validator;
use Auth;

class MobileAddressController extends BaseController
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

        //中间件 检测用户是否为前台登录用户
        $this->middleware('front.auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $view                               = $this->view('address_add');
        $view->breadcrumb_mobile            = $this->breadcrumb_mobile(trans('front.address'),url('mobile/address/'));

        return $view;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $rules          = [

                            'consignee'         =>'required',
                            'phone'             =>'required',
                            'email'             =>'required|email',
                            'address'           =>'required',
                            'country'           =>'required',
                            'province'          =>'required',
                            'city'              =>'required',
                            'district'          =>'required',
                         ];

        $validator              = Validator::make($request->all(),$rules);

        if($validator->fails()){

            return redirect('mobile/address/create')->withInput()
                                                    ->withErrors($validator->messages());
        }

        $address                = UserAddress::create($request->all());
        $address->user_id       = Auth::user('user')->id;
        $address->save();
        
        User::where('id',Auth::user('user')->id)
            ->update(['address_id'=>$address->id]);

        return redirect('checkout');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $model                              = UserAddress::find($id);

        if(empty($model)){

            return $this->view('404');
        }


        $view                               = $this->view('address');
        $view->breadcrumb_mobile            = $this->breadcrumb_mobile(trans('front.address'),url('mobile/auth/address/'.$id));
        $view->model                        = $model;

        return $view;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model          = UserAddress::find($id);

        if(empty($model)){

            return $this->view('404');
        }

        $rules         = [
                            'consignee'     =>'required',
                            'email'         =>'required|email',
                            'phone'         =>'required',
                            ''
                         ];

        $rules          = [

                            'consignee'         =>'required',
                            'phone'             =>'required',
                            'email'             =>'required|email',
                            'address'           =>'required',
                            'country'           =>'required',
                            'province'          =>'required',
                            'city'              =>'required',
                            'district'          =>'required',
                         ];

        $validator              = Validator::make($request->all(),$rules);

        if($validator->fails()){

            return redirect('mobile/address/'.$id)->withInput()
                                                  ->withErrors($validator->messages());
        }

        $model->update($request->all());

        User::where('id',Auth::user('user')->id)->update(['address_id'=>$id]);

        return redirect('checkout');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id             = intval($id);
        $model          = UserAddress::find($id);

        if(empty($model)){

            return $this->toJSON(['tag'=>'empty']);
        }

        //如果地址删除 如果有默认地址为该地址的 都需要更新为0
        User::where('address_id',$id)->update(['address_id'=>0]);
        $model->delete();

        return $this->toJSON(['tag'=>'ok']);

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 省会城市地区三级ajax联查
    |
    |-------------------------------------------------------------------------------
    */
    public function pcd(){

         $region_id         = request()->region_id;
         $tag               = request()->tag;
         $_token            = request()->_token;

         $res               = Region::where('parent_id',$region_id)->get();
         $str               = '<option value="">请选择</option>';

         foreach($res as $item){

             $str           .= '<option value="'.$item->region_id.'">'.$item->region_name.'</option>';
         }


         return $this->toJSON(['str'=>$str,'tag'=>$tag]);


    }
}

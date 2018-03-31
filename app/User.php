<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Phpstore\Crud\ImageLib;
use Hash;
use App\Models\Tag;
use App\Models\Account;
use Phpstore\Repository\UserRepository;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword,UserRepository;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                            'username',
                            'phone',
                            'email',
                            'sex',
                            'nickname',
                            'birthday',
                            'sfz',
                            'pay_points',       //消费积分
                            'rank_points',      //等级积分
                            'rank_id',          //会员等级
                            'password',
                            'reg_from',
                            'add_time',
                          ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    protected $appends = ['ossIcon','sexName','lastLoginTimeFormat','registerTimeFormat'];


    /*
    |-------------------------------------------------------------------------------
    |
    | 类型转化
    |
    |-------------------------------------------------------------------------------
    */
    protected $casts = [
            
    ];

    
    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个用户会有多个地址
    |
    |-------------------------------------------------------------------------------
    */
    public function address(){

        return $this->hasMany(Models\UserAddress::class,'user_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个会员等级会有多个会员
    |
    |-------------------------------------------------------------------------------
    */
    public function rank(){

        return $this->belongsTo('App\Models\UserRank','rank_id','id');
    }


    


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个用户 会有多个购物车记录
    |
    |-------------------------------------------------------------------------------
    */
    public function cart(){

        return $this->hasMany(Models\Cart::class,'user_id','id');
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个用户 会有多个退货单记录
    |
    |-------------------------------------------------------------------------------
    */
    public function order_return(){

        return $this->hasMany(Models\OrderReturn::class,'user_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个用户 会有多个订单
    |
    |-------------------------------------------------------------------------------
    */
    public function order(){

       return $this->hasMany(Models\Order::class,'user_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个用户 会有多个礼品卡
    |
    |-------------------------------------------------------------------------------
    */
    public function card(){

       return $this->hasMany(Models\Card::class,'user_id','id');
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多关联  一个用户 可以有多个标签记录
    |
    |-------------------------------------------------------------------------------
    */
    public function collect(){

        return $this->hasMany('App\Models\CollectGoods','user_id','id');
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取一个用户添加的标签列表
    |
    |-------------------------------------------------------------------------------
    */
    public function tag(){

        return  \App\Models\Tag::where('username',$this->username);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取一个用户的留言列表
    |
    |-------------------------------------------------------------------------------
    */
    public function message(){

        return \App\Models\Message::where('username',$this->username);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取用户的充值或提现记录
    |
    |-------------------------------------------------------------------------------
    */
    public function account(){

        return Account::where('username',$this->username);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取用户的短消息
    |
    |-------------------------------------------------------------------------------
    */
    public function sms(){

        return $this->hasMany('App\Models\Sms','user_id','id');
    }

}

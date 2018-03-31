<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Phpstore\Repository\AccountRepository;

class Account extends Model
{   
    use AccountRepository;
    protected $table 			= 'users_account';
    protected $fillable 		= ['username','type','amount','payment','user_note','add_time','ip','pay_tag'];
    protected $appends          = ['typeName','amountFormat','accountStatus','createTime'];

}

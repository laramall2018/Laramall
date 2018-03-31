<?php namespace Phpstore\Weixin;

use App\User;
use Auth;

/*
|-------------------------------------------------------------------------------
|
|   微信登录和支付相关函数
|
|-------------------------------------------------------------------------------
*/
class Common{

	public $appid;
	public $secret;
	public $weixin_base_url;

	/*
	|----------------------------------------------------------------------------
	|
	|  构造函数
	|
	|----------------------------------------------------------------------------
	*/
	function __construct(){

		$this->appid 				= 'wx4a2f24d142549227';
		$this->secret 				= 'fa1ea46adbfc15d108dedd2bd02cba80';
		$this->redirect_uri 		= 'https://larastore.net/auth/weixin/login';

	}

	/*
	|----------------------------------------------------------------------------
	|
	|  获取请求code的完整链接
	|
	|----------------------------------------------------------------------------
	*/
	public function get_code_url(){
		$url 	= 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='
				  .$this->appid
				  .'&redirect_uri='
				  .urlencode($this->redirect_uri)
				  .'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect'; 
		return $url;
	}


	/*
	|----------------------------------------------------------------------------
	|
	|  通过code 获取access_token
	|
	|----------------------------------------------------------------------------
	*/
	public function get_access_token_url($code){

		$url 		= 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='
					  .$this->appid
					  .'&secret='
					  .$this->secret
					  .'&code='
					  .$code
					  .'&grant_type=authorization_code';
		return $url;
	}


	/*
	|----------------------------------------------------------------------------
	|
	|  刷新access_token  
	|
	|----------------------------------------------------------------------------
	*/
	public function get_refresh_access_token_url($refresh_token){

		$url 		= 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='
					  .$this->appid
					  .'&grant_type=refresh_token&refresh_token='.$refresh_token;

		return $url;
	}


	/*
	|----------------------------------------------------------------------------
	|
	|  刷新access_token  
	|
	|----------------------------------------------------------------------------
	*/
	public function get_user_info_url($access_token,$openid){

		$url 		= 'https://api.weixin.qq.com/sns/userinfo?access_token='
					  .$access_token
					  .'&openid='
					  .$openid
					  .'&lang=zh_CN';
		return $url;
	}


	/*
	|----------------------------------------------------------------------------
	|
	|  获取最终用户的信息对象
	|
	|----------------------------------------------------------------------------
	*/
	public function userInfo($code){

		//通过code 获取access_token
		$url 					= $this->get_access_token_url($code);
		$json 					= $this->get_https_json($url);
		$json 					= json_decode($json);

		//刷新access_token
		$url 					= $this->get_refresh_access_token_url($json->refresh_token);
		$json 					= $this->get_https_json($url);
		$json 					= json_decode($json);

		//获取用户信息
		$url 					= $this->get_user_info_url($json->access_token,$json->openid);
		$json 					= $this->get_https_json($url);
		$json 					= json_decode($json);

		//返回对象数据
		return $json;
	}


	/*
	|----------------------------------------------------------------------------
	|
	|  使用微信登录
	|
	|----------------------------------------------------------------------------
	*/
	public function login($json){

		if(empty($json)){

			return '授权错误';
		}

		//检测用户是否存在
		$user 		= User::where('openid',$json->openid)->first();
		//存在则直接登录
		if($user){

			Auth::login($user);
			return redirect('auth/center');
		}

		//注册新用户
		$user 							= new User();
		$user->username 				= $json->nickname;
		$user->nickname 				= $json->nickname;
		$user->openid 					= $json->openid;
		$user->user_icon 				= $json->headimgurl;
		$user->add_time 				= time();
		$user->login_ip 				= request()->getClientIp();
		$user->reg_from 				= '微信登录';

		//微信的性别数字编码和phpstore系统不一致 调整差异
		$sex 							= intval($json->sex);
		if($sex == 0){

			$user->sex 					= 2;
		}
		else{

			$user->sex 					= $sex - 1;
		}

		$user->save();
		//使用新创建的用户登录
		Auth::login($user);
		return redirect('auth/center');

	}






	/*
	|----------------------------------------------------------------------------
	|
	|  读取远程json格式数据
	|
	|----------------------------------------------------------------------------
	*/
	public function get_https_json($url){
		
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
	}


}
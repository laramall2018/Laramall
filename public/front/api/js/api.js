
var  api   = {};


/*
|-------------------------------------------------------------------------------
|
| 注册表单
|
|-------------------------------------------------------------------------------
*/
api.register = function(ajax_url){

	$(document).on('click','#register-btn',function(){

		  var  username 	= $('#username').val();
		  var  password 	= $('#password').val();

		  $.ajax({

		  	 url:ajax_url,
		  	 type:'POST',
		  	 dateType:'json',
		  	 data:'username=' + username + '&password=' + password,
		  	 success:function(data){

		  	 	alert(data.result);
		  	 }
		  })
	})
}


/*
|-------------------------------------------------------------------------------
|
| 登录表单
|
|-------------------------------------------------------------------------------
*/
api.login = function(ajax_url){

	$(document).on('click','#login-btn',function(){

		  var  username 	= $('#username').val();
		  var  password 	= $('#password').val();

		  $.ajax({

		  	 url:ajax_url,
		  	 type:'POST',
		  	 dateType:'json',
		  	 data:'username=' + username + '&password=' + password,
		  	 success:function(data){

		  	 	alert(data.result);
		  	 }
		  })
	})
}
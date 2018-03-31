<script type="text/javascript">
	var sregroot  = new Vue({
		el:'#sregroot',
		data:{
			username:'',
			email:'',
			phone:'',
			password:'',
		},
		methods:{

			addSupplier:function(){
				var  param 				= {};
				param.username 			= this.username;
				param.email 			= this.email;
				param.phone 			= this.phone;
				param.password 			= this.password;

				$.ajax({
					url:"{{url('api/supplier/register')}}",
					type:"POST",
					data:'param='+$.toJSON(param),
					dataType:'json',
					success:function(data){
						var content  = data.data;
						if(content.tag == 'error'){
                        	swal({
                                title: "表单数据异常",
                                text: content.info,
                                html: true
                        	});
                        	return false;
                      	}

                      	if(content.tag == 'success'){
                        	swal("注册成功", "您已经注册成功", "success");
                        	window.location.href ="{{url('supplier/login')}}";
                      	}
					}
				});
			},
		},
	})
</script>
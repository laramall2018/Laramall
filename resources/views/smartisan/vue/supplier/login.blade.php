<script type="text/javascript">
	var  sloginroot 	= new Vue({
		el:'#sloginroot',
		data:{
			username:'',
			password:'',
		},
		methods:{
			supplierLogin:function(){
				var  username 	= this.username;
				var  password 	= this.password;
				$.ajax({
					url:"{{url('api/supplier/login')}}",
					type:"POST",
					data:'username='+username +'&password='+password,
					dataType:"json",
					success:function(data){
						var res  	= data.data;
						if(res.tag =='error'){
							swal({
								title:"信息提示",
								text:res.info,
								html:true
							});
							return false;
						}
						//
						if(res.tag =='success'){
							swal("登录成功","您已经成功登录供货商系统","success");
							window.location.href = "{{url('supplier/center')}}";
						}
					}
				})
			}
		}
	})
</script>
<script type="text/javascript">
	var accountroot  = new Vue({

		el:'#accountroot',
		data:{
			rows:[],
			type:0,
			amount:100,
			payment:'支付宝',
			user_note:'',

		},
		created:function(){
			this.getList();
		},
		methods:{
			//获取列表
			getList:function(){
				var _this = this;
				$.ajax({
					url:"{{url('api/account')}}",
					type:"GET",
					dataType:"json",
					success:function(data){
						var res 	= data.data;
						if(res.tag == 'success'){
							_this.rows 	= res;
						}
					}
				});
			},

			//添加账户记录
			addAccount:function(){
				var type 		= this.type;
				var amount 		= this.amount;
				var payment 	= this.payment;
				var user_note 	= this.user_note;

				$.ajax({
					url:"{{url('api/account')}}",
					type:"POST",
					data:'type='+type+'&amount='+amount+'&payment='+payment+'&user_note='+user_note,
					dataType:"json",
					success:function(data){
						var  content  = data.data;
						if(content.tag == 'error'){
							swal({
								title:"错误提示",
								text:content.info,
								html:true
							});
							return false;
						}
						//成功
						if(content.tag == 'success'){
							accountroot.rows 	= content;
							$('#myModalNew').modal('hide');
							swal("添加成功","您已经添加记录","success");
						}
					}
				});
			},
		}
	});
</script>
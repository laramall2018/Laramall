<script type="text/javascript">
	var returnroot = new Vue({
		el:'#returnroot',
		data:{
			rows:[],
			order_id:'',
			type:'',
			return_note:'',
			bank_name:'',
			bank_account:'',
			return_amount:'',
			username:"{{$user->username}}",
		},
		created:function(){
			this.getList();
		},
		methods:{
			//获取列表
			getList:function(){
				var  _this  = this;
				$.ajax({
					url:"{{url('api/return')}}",
					type:"GET",
					dataType:"json",
					success:function(data){
						var  res   = data.data;
						if(res.tag == 'success'){
							_this.rows  = res;
						}
					}
				});
			},
			//申请退货单
			addReturn:function(){
				var param 				= {};
				param.order_id 			= this.order_id;
				param.type 				= this.type;
				param.return_note 		= this.return_note;
				param.bank_name 		= this.bank_name;
				param.bank_account 		= this.bank_account;
				param.return_amount 	= this.return_amount;
				param.username 			= this.username;

				$.ajax({
					url:"{{url('api/return')}}",
					type:"POST",
					data:'param='+$.toJSON(param),
					dataType:'json',
					success:function(data){
						var res  	= data.data;
						if(res.tag =='error'){
							swal({
								title:"错误提示",
								text:res.info,
								html:true
							});
							return false;
						}

						if(res.tag =='success'){
							returnroot.rows 	= res;
							swal("添加成功","已经成功递交了退货申请","success");
							$('#myModalNew').modal('hide');
						}
					}
				});
			},

			//删除confirm
			delConfirm:function(id){
				var  _this  = this;
				swal({
  						title: "确认删除？",
  						text: "确认从数据库中删除该条记录？",
  						type: "warning",
  						showCancelButton: true,
  						confirmButtonColor: "#DD6B55",
  						confirmButtonText: "确认",
  						cancelButtonText:"取消",
  						closeOnConfirm: false
					},
					function(){
						_this.delReturn(id);
					});
			},

			//删除退货
			delReturn:function(id){
				$.ajax({
					url:"{{url('api/return/delete')}}",
					type:"DELETE",
					data:'id='+id,
					dataType:'json',
					success:function(data){
						var res  = data.data;
						if(res.tag == 'error'){
							swal({
								title:'错误提示',
								text:res.info,
								html:true
							});
							return false;
						}
						if(res.tag == 'success'){
							returnroot.rows 	= res;
							swal("成功删除","您已成功删除退货单","success");
						}
					}
				});
			},
		}
	})
</script>
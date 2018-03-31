<script type="text/javascript">
	var  orderroot 	= new Vue({
		el:'#orderroot',
		data:{
			rows:[],
			allSelected:0,
		},
		created:function(){
			this.getList();
		},
		methods:{

			//获取列表
			getList:function(){
				$.ajax({
					url:"{{url('api/order')}}",
					type:'GET',
					dataType:'json',
					success:function(data){
						var res 	= data.data;
						if(res.tag == 'success'){
							orderroot.rows 	= res;
						}
					}
				});
			},
			//删除订单
			delOrder:function(id){
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
						$.ajax({
							url:"{{url('api/order/delete')}}",
							type:"DELETE",
							data:'id='+id,
							dataType:'json',
							success:function(data){
								var  content 	= data.data;
								if(content.tag =='error'){
									swal(content.info);
									return false;
								}

								if(content.tag == 'success'){
									orderroot.rows = content;
									swal("删除成功", "您已经成功在数据库中删除该条记录", "success");
								}

							}
						});
					});

			},

			//全部选中订单
			checkedAll:function(){

				var  tmp  = this.allSelected;

				if(tmp == 1){

					tmp = 0;
				}
				else{

					tmp  = 1;
				}

				this.allSelected  = tmp;
			},

			//选择单个订单
			orderSelect:function(event){

				var cur  = event.currentTarget;

				if($(cur).hasClass('checked-on')){

					$(cur).removeClass('checked-on');
				}
				else{

					$(cur).addClass('checked-on');
				}

			},

			//获取被选中的订单编号
			getIds:function(){

				var ids 	= $('span.order-checked-btn');
				var arr     = new Array();
				$.each(ids,function(index,item){
                        if($(item).hasClass('checked-on')){

                        	  var  order_id  =  $(item).data('id');
                        	  arr.push(order_id);
                        }
				});

				return arr;
			},

			//合并订单
			mergeOrder:function(){

				 var  ids 		=  this.getIds();
				 //如果为空 错误提示
				 if(ids.length == 0){

				 	swal({
				 		title:"错误提示",
				 		text:"您未选中任何订单",
				 		type:"error"
				 	});
				 	return false;
				 }

				 $.ajax({
				 	url:"{{url('api/order/merge')}}",
				 	type:"post",
				 	data:'ids='+$.toJSON(ids),
				 	dataType:"json",
				 	success:function(data){
				 		var res  = data.data;
				 		if(res.tag == 'error'){

				 			swal({
				 				title:"错误提示",
				 				text:res.info,
				 				html:true,
				 				type:"error"
				 			});
				 			return false;
				 		}

				 		//成功执行
				 		if(res.tag =='success'){

				 			swal({
				 				title:"成功批量支付",
				 				text:res.info,
				 				html:true,
				 				type:"success"
				 			});
				 			var  order 		= res.order;
				 			//跳转到新生成的订单支付界面
				 			window.location.href  = "{{url('order/payment/')}}" + '/' + order.id;
				 		}
				 	}
				 });
			},

		},
	});
</script>
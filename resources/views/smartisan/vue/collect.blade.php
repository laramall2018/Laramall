<script type="text/javascript">
	var collectroot  = new Vue({
		el:'#collectroot',
		data:{
			rows:[],
			goods_id:'',
		},
		created:function(){
			this.getList();
		},
		methods:{

			//获取用户的收藏列表
			getList:function(){
				var _this  = this;
				$.ajax({
					url:"{{url('api/collect')}}",
					type:"GET",
					dataType:"json",
					success:function(data){
						var res 	= data.data;
						if(res.tag =='success'){
							_this.rows  = res;
						}
					}
				});
			},
			//删除函数
			delCollect:function(id){
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
							url:"{{url('api/collect/delete')}}",
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
									collectroot.rows = content;
									swal("删除成功", "您已经成功在数据库中删除该条记录", "success");
								}

							}
						});
					});
			},
			//添加收藏
			addCollect:function(){
				var  goods_id  = this.goods_id;
				$.ajax({
					url:"{{url('api/collect')}}",
					type:"POST",
					data:'goods_id='+goods_id,
					dataType:"json",
					success:function(data){
						var  res  = data.data;
						if(res.tag == 'error'){
							swal({
    								title:"错误提示",
    								text:res.info,
    								html:true
    						});
    						return false;
						}

						if(res.tag == 'success'){
							collectroot.rows 	= res;
							$('#myModalNew').modal('hide');
							swal("添加成功","您已经成功收藏","success");

						}
					}
				})
			}
			
		}
	})
</script>
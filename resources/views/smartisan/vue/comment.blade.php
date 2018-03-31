<script type="text/javascript">
	var cmtapp    = new Vue({

		el:'#commentapp',
		data:{

			rows:[],
			id:"{{$goods->id}}",
			rank:5,
			content:'',
		},
		created:function(){
			this.getList();
		},
		methods:{

			//获取列表
			getList:function(){
				var id   	= this.id;
				$.ajax({
					url:"{{url('api/comment')}}",
					type:"GET",	
					data:'id='+ id,
					dataType:'json',
					success:function(data){
						var  res  = data.data;
						if(res.tag == 'success'){
							cmtapp.rows  = res;
						}
					}
				});
			},
			//添加评论
			addCmt:function(){

				var  rank 		= this.rank;
				var  content    = this.content;
				var  id 		= this.id;

				$.ajax({

					url:"{{url('api/comment')}}",
					type:"POST",
					data:'content=' + content + '&rank=' + rank + '&id=' + id,
					dataType:"json",
					success:function(data){

						var  res  	= data.data;
						if(res.tag == 'error'){

							swal({
								title:"错误提示",
								text:res.info,
								html:true,
								type:"error"
							});
							$('#myModalNew').modal('hide');
							return false;
						}

						if(res.tag == 'success'){
							cmtapp.rows   = res;
							$('#myModalNew').modal('hide');
						}
					}
				});
			},
		}
	})
</script>
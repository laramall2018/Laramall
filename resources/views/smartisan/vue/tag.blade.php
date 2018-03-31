<script type="text/javascript">
	var tagroot 	= new Vue({
		el:'#tagroot',
		data:{
				rows:[],
				tag_name:'',
				sort_order:0,
				goods_id:0,
		},
		created:function(){
			this.getList();
		},
		methods:{

			//获取列表
			getList:function(){

					$.ajax({
						url:"{{url('api/user/tag')}}",
						type:"GET",
						dataType:"json",
						success:function(data){
							var  content 	= data.data;
							if(content.tag == 'success'){
								tagroot.rows  = content;
							}
						}
					});
			},

			//删除标签
			deleteTag:function(id){

				swal({
  						title: "确认删除吗？",
  						text: "您的操作将从数据库中删除该条记录",
  						type: "warning",
  						showCancelButton: true,
  						confirmButtonColor: "#DD6B55",
  						confirmButtonText: "确认删除",
  						cancelButtonText:"取消",
  						closeOnConfirm: false
					  },
					function(){
						$.ajax({
							url:"{{url('api/user/tag/delete')}}",
							type:"DELETE",
							data:'id='+id,
							dataType:'json',
							success:function(data){
								var content = data.data;
								if(content.tag=='success'){
									swal("删除成功!", "您已经成功删除记录", "success");
									tagroot.rows 	= content;
								}
							}
						});
					});
			},
			//添加标签
			addTag:function(){

				var  tag_name 	= this.tag_name;
				var  goods_id 	= this.goods_id;
				var  sort_order = this.sort_order;

				$.ajax({
					url:"{{url('api/user/tag')}}",
					type:'POST',
					data:'tag_name='+tag_name +'&goods_id='+goods_id +'&sort_order=' +sort_order,
					dataType:'json',
					success:function(data){
						var  content 	= data.data;
						if(content.tag == 'error'){

							swal({
  									title: "错误提示",
  									text: content.info,
  									html: true
							});
							return false;
						}
						if(content.tag == 'success'){
							tagroot.rows 	= content;
							swal("添加成功", "您已经成功添加标签", "success");
							$('#myModalNew').modal('hide');
						}
					}
				});
			},
		}
	})
</script>
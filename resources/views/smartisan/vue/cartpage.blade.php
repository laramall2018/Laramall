
<script type="text/javascript">
	var cartpageapp 	= new Vue({

				el:'#cartpageapp',
				data:{
						//购物车数据
						rows:[],
				},
				created:function(){

					  this.getList();
				},
				//方法列表
				methods:{

					//获取初始数据
					getList:function(){
						$.ajax({
							url:"{{url('api/cart')}}",
							type:'GET',
							dataType:'json',
							success:function(data){
								cartpageapp.rows  = data.data;
							},
						});
					},

					//选中获取取消单选按钮
					isChecked:function(id){

						  $.ajax({
						  	type:'POST',
						  	url:"{{url('api/cart/checked')}}",
						  	data:'id='+id,
						  	dataType:'json',
						  	success:function(data){
						  		cartpageapp.rows 	= data.data;
						  	}
						  })
					},

					//全部选中，或者全部取消
					checkedAll:function(){

						$.ajax({
							type:'POST',
							url:"{{url('api/cart/checked-all')}}",
							dataType:'json',
							success:function(data){
								cartpageapp.rows = data.data;
							}
						})
					},

					//减少1
					subCart:function(id){
						$.ajax({
							type:'POST',
							url:"{{url('api/cart/number-sub')}}",
							data:"id="+id,
							dataType:'json',
							success:function(data){
								cartpageapp.rows = data.data;
							}
						})
					},

					//购物车数量+1
					addCart:function(id){
						$.ajax({
							type:'POST',
							url:"{{url('api/cart/number-add')}}",
							data:'id='+id,
							dataType:'json',
							success:function(data){
								cartpageapp.rows  = data.data;
							}
						})
					},

					//删除购物车中记录
					deleteCart:function(id){
						$.ajax({
							type:'DELETE',
							url:"{{url('api/cart/delete')}}",
							data:'id='+id,
							dataType:'json',
							success:function(data){
								cartpageapp.rows = data.data;
							}
						})
					}


				},
	});
</script>
<script type="text/javascript">
	var  cartapp = new Vue({

			el:'#cartapp',
			data:{

				rows:[],
			},
			created:function(){
				this.getList();
			},
			methods:{

					//获取数据
					getList:function(){

						$.ajax({
							type:'GET',
							url:"{{url('api/cart')}}",
							dataType:'json',
							success:function(data){
								cartapp.rows 	= data.data;
							}
						});
					},

					//ajax删除购物车信息
					cartDelete:function(id){

						$.ajax({
							type:'DELETE',
							url:"{{url('api/cart/delete')}}",
							data:'id=' + id,
							dataType:'json',
							success:function(data){

								cartapp.rows  = data.data;
							}
						});
				    },

			},

	});
</script>
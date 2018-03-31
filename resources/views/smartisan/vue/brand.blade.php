<script type="text/javascript">
	var  brandroot 	= new Vue({

		el:'#brandroot',
		data:{
			rows:[],
		},
		created:function(){
			this.getList();
		},
		methods:{
			//获取列表
			getList:function(){
				$.ajax({
					url:"{{url('api/brand/goods')}}",
					type:"GET",
					data:'id='+"{{$model->id}}",
					dataType:"json",
					success:function(data){
						var  res  = data.data;
						if(res.tag 	== 'success'){
							brandroot.rows 	= res;
						}
					}
				});
			},
		  	//加入购物车
		  	addCart:function(id){

		  			$.ajax({

		  				url:"{{url('api/cart/add')}}",
		  				type:'POST',
		  				data:'id='+ id,
		  				dataType:'json',
		  				success:function(data){
		  					var  content  = data.data;
		  					if(content.tag == 'error'){

		  						swal(content.info);
		  						return false;
		  					}

		  					if(content.tag == 'success'){
		  						swal("操作成功","您已成功添加商品到购物车","success")
		  					}

		  					cartapp.rows 	= content;
		  				}
		  			})
		  	},
		},
	})
</script>
<script type="text/javascript">

    $(function(){
		larastore.goods.gallery();
	})

	var goodsapp 	= new Vue({

		  el:'#goodsapp',
		  data:{

		  			rows:[],
		  },
		  created:function(){

		  	 this.getList();
		  },
		  
		  methods:{

		  		//获取商品记录
		  		getList:function(){

		  			$.ajax({
		  				url:"{{url('api/recommend/goods')}}",
		  				type:'GET',
		  				dataType:'json',
		  				success:function(data){

		  					 goodsapp.rows 	= data.data;
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
	});
</script>
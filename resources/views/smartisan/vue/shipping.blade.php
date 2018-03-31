<script type="text/javascript">
	var shippingroot	= new Vue({

		el:'#shippingroot',
		data:{

			 rows:[],
			 shipping_id:0,
		},
		created:function(){

			this.getList();
		},

		methods:{

			//获取配送方式列表
			getList:function(){
				$.ajax({
					type:'GET',
					url:"{{url('api/shipping')}}",
					dataType:'json',
					success:function(data){
						shippingroot.rows = data.data;
					}
				});
			},
			//选择配送方式
			selectShipping:function(shipping_id){
				this.shipping_id 	= shipping_id;
				$.ajax({
					url:"{{url('api/shipping/')}}",
					type:"POST",
					data:'shipping_id=' + shipping_id,
					dataType:"json",
					success:function(data){
						var content 			   = data.data;
						if(content.tag == 'success'){
							checkoutroot.shipping_fee  = content.shipping.fee;
							checkoutroot.orderAmount();
						}
					}
				})
				
			}
		}
	})
</script>
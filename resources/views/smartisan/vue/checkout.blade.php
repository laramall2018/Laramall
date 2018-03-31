<script type="text/javascript">
	var checkoutroot 	= new Vue({

		el:'#checkoutroot',
		data:{
				rows:[],
				card_sn:'',
				shipping_fee:0,
				discount:0,
				order_amount:0,
		},
		created:function(){
			this.getList();
		},
		methods:{

			//获取购物车列表
			getList:function(){
				$.ajax({
					type:'GET',
					url:"{{url('api/cart')}}",
					dataType:'json',
					success:function(data){
						var  content 	  			= data.data;
						checkoutroot.rows 			= content;
						//计算订单总金额
						checkoutroot.order_amount 	= content.cart_checked_amount 
										  			+ checkoutroot.shipping_fee 
										  			- checkoutroot.discount;

					}
				});
			},
			//检测礼品卡
			checkGiftCard:function(){
				var that 	= this;
				if(!this.card_sn){
					swal({
						title:"错误提示",
						text:"礼品卡串号不能为空",
						type:"error"
					});
					return false;
				}

				var  card_sn 	= checkoutroot.card_sn; 

				$.ajax({
					type:"POST",
					url:"{{url('api/card/check')}}",
					data:'card_sn=' + card_sn,
					dateTyp:'json',
					success:function(data){

						var  content = data.data;
						if(content.tag == 'error'){

							swal({
								title:"错误提示",
								text:content.info,
								html:true,
								type:"error"
							});

							return false;
						}

						if(content.tag == 'success'){

							swal({
								title:"信息提示",
								text:content.info,
								html:true,
								type:"success"
							});

							checkoutroot.discount = content.card.price;
							//计算订单总金额
							that.orderAmount();
						}
					}
				})
			},
			//计算订单总金额
			orderAmount:function(){

				var  goods_amount 	= parseFloat(this.rows.cart_checked_amount);
				var  fee 			= parseFloat(this.shipping_fee);
				var  discount 		= parseFloat(this.discount);
				var  order_amount   = goods_amount + fee - discount;

				this.order_amount   = order_amount;
			},
			//确认下单
			orderDone:function(){
				//检测支付方式和配送方式是否选择
				if(payroot.pay_id == 0){
					
					swal({
						title:"错误提示",
						text:"请选择支付方式",
						html:true,
						type:"error"
					});
					return false;
				}
				if(shippingroot.shipping_id == 0){
					swal({
						title:"错误提示",
						text:"请选择配送方式",
						html:true,
						type:"error"
					});
					return false;
				}
				//获取相关参数
				var  param 	= this.getParam();
				$.ajax({
					url:"{{url('api/order/done')}}",
					type:"POST",
					data:'param='+$.toJSON(param),
					dataType:'json',
					success:function(data){

						var  content 		= data.data;
						if(content.tag == 'error'){
							swal({
									title:"错误提示",
									text:content.info,
									html:true,
									type:"error"
							});
							return false;
						}
						window.location.href="{{url('order/payment')}}" + '/' + content.order.id;
					}

				})
			},
			//获取下单的相关参数
			getParam:function(){
				var param 				= {};
					param.pay_id 		= payroot.pay_id;
					param.shipping_id 	= shippingroot.shipping_id;
					param.card_sn 		= checkoutroot.card_sn;
					param.fp_tag 		= fpapp.fp_tag;
					param.fp_title 	    = fpapp.fp_title;
					param.fp_type 	    = fpapp.fp_type;

					return param;
			},
		},
	})
</script>
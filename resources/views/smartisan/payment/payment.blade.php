<div class="row">
	<div class="panel panel-goods">
		<div class="panel-heading">
			<h4>订单支付</h4>
		</div><!--/panel-heading-->
		<div class="panel-body">
			<div class="payment-info">
				<h2>递交订单成功</h2>
				<p class="text-center">请在 24 小时内完成支付，超时订单将自动取消</p>
			</div><!--/payment-info-->
			<div class="payment-content" id="orderpayroot">
				<div class="pay-list padding20">
				<h4 class="botbor">请选择支付方式</h4>
				<div class="pay-item" v-for="payment in rows.payment_list">

					<img v-bind:src="payment.paymentIcon"
						 v-bind:class="{'active-img':pay_id == payment.id}"
						 v-on:click="changePayment(payment.id)"
						v-bind:alt="payment.pay_name">
				</div><!--/pay-item-->
			</div><!--/pay-list-->

			<div class="pay-btn">
				
				<div class="row">
					<div class="col-md-6">
						<span class="price">￥{{$order->order_amount}}</span>
					</div><!--/col-md-6-->
					<div class="col-md-6 text-right">
						<p v-html="pay_btn"></p>
					</div><!--col-md-6-->
				</div><!--row-->
			</div><!--/pay-btn-->
			</div><!--/payment-content-->
		</div>
	</div><!--/panel-goods-->
</div><!--/row-->

<script type="text/javascript">
	var orderpayroot  = new Vue({
		el:'#orderpayroot',
		data:{
			rows:[],
			pay_id:"{{$order->pay_id}}",
			pay_btn:'{!!$order->pay_btn()!!}',
		},
		created:function(){
			this.getList();
		},
		methods:{

			//获取支付方式列表
			getList:function(){
				var  _this 			= this;
				$.ajax({
					url:"{{url('api/payment')}}",
					type:"GET",
					dataType:"json",
					success:function(data){
						var content  	=  data.data;
						_this.rows 		= content;
					}
				})
			},

			//选择支付方式
			changePayment:function(pay_id){
				this.pay_id 	= pay_id;
				var  _this 		= this;
				$.ajax({
					url:"{{url('api/payment/paybtn')}}",
					type:"POST",
					data:'pay_id='+pay_id +'&order_id=' + "{{$order->id}}",
					dataType:"json",
					success:function(data){
						var  content 		= data.data;
						if(content.tag =='success'){
							_this.pay_btn 	= content.pay_btn;
						}
					}
				})
			},
		}
	})
</script>
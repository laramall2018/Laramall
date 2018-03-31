<script type="text/javascript">
	var payroot 	= new Vue({
		el:'#payroot',
		data:{

				rows:[],
				pay_id:0,
		},
		created:function(){

			this.getList();
		},
		methods:{

			//获取支付列表
			getList:function(){
				$.ajax({
					url:"{{url('api/payment')}}",
					type:'GET',
					dataType:'json',
					success:function(data){
						var content 	= data.data;
						payroot.rows 	= content;
					}
				})
			},

			//改变支付方式
			changePayment:function(pay_id){

				this.pay_id  = pay_id;
			},
		},
	})
</script>
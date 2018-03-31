<script type="text/javascript">
	
	var batchroot 	= new Vue({

		el:'#batchroot',
		data:{
				orderStr:'',
				order_list:[],
				orders:[],
		},
		methods:{

			//用户输入的字符串转化成数组传递给下一个页面
		    createForm:function(){

		    	var  orderStr  = this.orderStr;

		    	$.ajax({

		    		url:"{{url('api/batch-order')}}",
		    		type:'POST',
		    		data:'orderStr=' + orderStr,
		    		dataType:'json',
		    		success:function(data){

		    			 var res  = data.data;
		    			 //错误提示
		    			 if(res.tag == 'error'){

		    			 	swal({
		    			 		title:"错误提示",
		    			 		text:res.info,
		    			 		html:true,
		    			 		type:'error'
		    			 	});
		    			 	return false;
		    			 }

		    			 //如果成功返回
		    			 if(res.tag == 'success'){

		    			 	swal({
		    			 		title:"操作成功",
		    			 		text:res.info,
		    			 		html:true,
		    			 		type:'success'
		    			 	});

		    			 	batchroot.order_list  = res.order_list;
		    			 }
		    			 

		    		}
		    	});
		    },

		    //重新输入
		    resetInput:function(){

		    	this.order_list = [];
		    	this.orders  	= [];
		    },

		    //删除商品项
		    delItem:function(event){

		    	var  _this = event.currentTarget;
		    	$(_this).parent('.col-md-1').parent('.form-group').remove();
		    },

		    //确认下单
		    orderDone:function(){

		    	var param  = this.getParam();

		    	$.ajax({

		    		url:"{{url('api/batch-order/done')}}",
		    		type:'POST',
		    		data:'param='+param,
		    		dataType:'json',
		    		success:function(data){

		    			var res  = data.data;
		    			 //错误提示
		    			if(res.tag == 'error'){

		    			 	swal({
		    			 		title:"错误提示",
		    			 		text:res.info,
		    			 		html:true,
		    			 		type:'error'
		    			 	});
		    			 	return false;
		    			 }

		    			 //成功执行
		    			 if(res.tag == 'success'){

		    			 	swal({
		    			 		title:"操作成功",
		    			 		text:res.info,
		    			 		html:true,
		    			 		type:'success'
		    			 	});
		    			 	batchroot.orders  	= res.orders;
		    			 }
		    		}
		    	});
		    },

		    //获取参数
		    getParam:function(){

		    	var  _this 			= this;
		    	var  param    		=  {};
		    	var  keys_value	    =  _this.getArrayValue('keys');
		    	param.keys 			= keys_value;

		    	$.each(keys_value,function(index,value){

		    			//商品编号
		    			param['goods_ids'+value]			= _this.getSelectValue('goods_ids'+value);
		    			//商品属性
		    			param['attrs'+value]  				= _this.getArrayValue('attrs'+value);
		    			//商品数量
		    			param['goods_numbers'+value] 		= _this.getArrayValue('goods_numbers'+value);

		    			//用户名称
		    			var  usernames_key 	   				= 'usernames' + value;
		    			var  usernames 		   				= _this.getArrayValue(usernames_key);
		    			param['usernames'+value]    		= usernames;

		    			//手机
		    			var  phones_key 	   				= 'phones' + value;
		    			var  phones 		   				= _this.getArrayValue(phones_key);
		    			param['phones'+value]       		= phones;

		    			//地址
		    			var  address_key 	   				= 'address' + value;
		    			var  address 		   				= _this.getArrayValue(address_key);
		    			param['address'+value] 				= address;
		    	});

		    	return $.toJSON(param);
		    },

		    //使用jquery获取数组表单的所有值
		    getArrayValue:function(field){

		    	return values = $("input[name='" + field +"[]']").map(function(){return $(this).val();}).get();
		    },

		    //使用jquery获取select表单的数组值
		    getSelectValue:function(field){

		    	return values = $("select[name='" + field +"[]']").map(function(){return $(this).val();}).get();
		    },


		},
	})

</script>
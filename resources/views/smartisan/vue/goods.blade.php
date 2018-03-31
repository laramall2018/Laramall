<script type="text/javascript">
	var goodsapp = new Vue({

		 el:'#goodsapp',
		 data:{

		 	   goods_number:1,
		 	   goods_total_number:"{{$goods->goods_number}}",
		 	   attr_list:[],
		 	   goods_attr_ids:[],
		 	   goods_attr_values:[],

		 },
		 created:function(){

		 	 this.getList();
		 },
		 //方法列表
		 methods:{

		 	  getList:function(){

		 	  	 $.ajax({

		 	  	 	type:'GET',
		 	  	 	url:"{{url('api/goods/'.$goods->id)}}",
		 	  	 	dataType:'json',
		 	  	 	success:function(data){
		 	  	 		var   content 		= data.data;
		 	  	 		goodsapp.attr_list  = content.attr_list;
		 	  	 	}
		 	  	 })

		 	  },
		 	  //增加商品购买数量
		 	  addGoodsNumber:function(){

		 	  		if(goodsapp.goods_number < goodsapp.goods_total_number){
		 	  			goodsapp.goods_number += 1;
		 	  		}
		 	  		else{
		 	  			
		 	  			swal({
		 	  				title:"错误提示",
		 	  				text:'超过最大购买数量',
		 	  				html:true,
		 	  				type:"error"
		 	  			});
		 	  			return false;
		 	  		}
		 	  		
		 	  },
		 	  //减少商品购买数量
		 	  subGoodsNumber:function(){

		 	  	   if(goodsapp.goods_number > 1){

		 	  	   	  goodsapp.goods_number -= 1;
		 	  	   }
		 	  	   else{
		 	  	   	  swal({
		 	  				title:"错误提示",
		 	  				text:'<p>最小购买数量为1</p>',
		 	  				html:true,
		 	  				type:"error"
		 	  			});
		 	  			return false;
		 	  	   }
		 	  },

		 	  //选择商品属性
		 	  changeAttr:function(event){

		 	  	   var  that 	 = event.currentTarget;
		 	  	   $(that).parent('.goods-detail-attr-item').find('span.attr-value').removeClass('active');
		 	  	   $(that).addClass('active');
		 	  	   //绑定选中的商品属性值
		 	  	   goodsapp.goods_attr_ids = this.getGoodsAttrIds();
		 	  	   //获取被选中的商品属性值
		 	  	   this.getAjaxAttrValue();
		 	  },

		 	  //获取被选中的商品属性值
		 	  getGoodsAttrIds:function(){

		 	  	  var  attr_list 		= $('.goods-detail-attr-item span.attr-value');
		 	  	  var  arr 			    = new Array();
		 	  	  $.each(attr_list ,function(i,item){

		 	  	  		 if($(item).hasClass('active')){
		 	  	  		 	  var goods_attr_id 	= $(item).data('goods_attr_id');
		 	  	  		 	      goods_attr_id 	= parseInt(goods_attr_id);
		 	  	  		 	      if(goods_attr_id > 0){
		 	  	  		 	      	 //绑定到data
		 	  	  		 	      	  arr.push(goods_attr_id);
		 	  	  		 	      }
		 	  	  		 }
		 	  	  });

		 	  	  return arr;
		 	  },
		 	  //执行ajax获取选中的商品属性
		 	  getAjaxAttrValue:function(){

		 	  	  var ids 		= goodsapp.goods_attr_ids;
		 	  	  $.ajax({
		 	  	  	 type:'POST',
		 	  	  	 url:"{{url('api/goods-attr')}}",
		 	  	  	 data:'ids=' + $.toJSON(ids),
		 	  	  	 dataType:'json',
		 	  	  	 success:function(data){
		 	  	  	 	var  content 			 	= data.data;
		 	  	  	 	goodsapp.goods_attr_values 	= content.goods_attr_values;
		 	  	  	 }
		 	  	  });
		 	  },
		 	  //加入购物车
		 	  addCart:function(){

		 	  	 var  param 				= this.getParam();
		 	  	 var  goods_number 			= goodsapp.goods_number;
		 	  	 	  goods_number 			= parseInt(goods_number);
		 	  	 var  goods_total_number    = goodsapp.goods_total_number;
		 	  	 	  goods_total_number 	= parseInt(goods_total_number);

		 	  	 	  if(goods_number >= goods_total_number){
		 	  	 	  	
		 	  	 	  	swal({
		 	  				title:"错误提示",
		 	  				text:'超过最大购买数量',
		 	  				html:true,
		 	  				type:"error"
		 	  			});
		 	  	 	  	return false;
		 	  	 	  }
		 	  	 //执行ajax
		 	  	 $.ajax({
		 	  	 	type:'POST',
		 	  	 	url:"{{url('api/goods/add-to-cart')}}",
		 	  	 	data:'param=' + $.toJSON(param),
		 	  	 	dataType:'json',
		 	  	 	success:function(data){

		 	  	 		if(data.tag == 'error'){

		 	  	 			swal({
		 	  				title:"错误提示",
		 	  				text: data.info,
		 	  				html:true,
		 	  				type:"error"
		 	  			});
		 	  			return false;
		 	  	 			
		 	  	 		}
		 	  	 		if(data.tag == 'success'){

		 	  	 			swal({
		 	  				title:"添加购物车成功",
		 	  				text: data.info,
		 	  				html:true,
		 	  				type:"success"
		 	  			});
		 	  	 			cartapp.rows  = data;
		 	  	 		}
		 	  	 	}
		 	  	 });
		 	  },
		 	  //立即购买
		 	  buy:function(){
		 	  	 var  param 				= this.getParam();
		 	  	 var  goods_number 			= goodsapp.goods_number;
		 	  	 	  goods_number 			= parseInt(goods_number);
		 	  	 var  goods_total_number    = goodsapp.goods_total_number;
		 	  	 	  goods_total_number 	= parseInt(goods_total_number);

		 	  	 	  if(goods_number >= goods_total_number){
		 	  	 	  	swal('超过最大购买数量');
		 	  	 	  	return false;
		 	  	 	  }
		 	  	 //执行ajax
		 	  	 $.ajax({
		 	  	 	type:'POST',
		 	  	 	url:"{{url('api/goods/add-to-cart')}}",
		 	  	 	data:'param=' + $.toJSON(param),
		 	  	 	dataType:'json',
		 	  	 	success:function(data){

		 	  	 		if(data.tag == 'error'){

		 	  	 			swal(data.info);
		 	  	 			return false;
		 	  	 		}
		 	  	 		if(data.tag == 'success'){

		 	  	 			//swal(data.info);
		 	  	 			cartapp.rows  = data;
		 	  	 			window.location.href = "{{url('cart')}}";
		 	  	 		}
		 	  	 	}
		 	  	 });
		 	  },
		 	  //获取参数
		 	  getParam:function(){

		 	  	  var  param 					= {};
		 	  	  	   param.goods_id 			= "{{$goods->id}}";
		 	  	  	   param.goods_number 		= goodsapp.goods_number;
		 	  	  	   param.goods_attr_ids 	= goodsapp.goods_attr_ids;
		 	  	  	   return param;
		 	  },

		 }

	});
</script>
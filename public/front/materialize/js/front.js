
/*
|-------------------------------------------------------------------------------
|
| 移动版本 前台页面需要的js文件集合
|
|-------------------------------------------------------------------------------
*/

var front 			= {};
	front.goods     = {};
	front.user 		= {};
	front.cart 		= {};
	front.address 	= {};
	front.checkout 	= {};
	front.mobile 	= {};




/*
|-------------------------------------------------------------------------------
|
| 移动版本 前台页面需要的js文件集合
|
|-------------------------------------------------------------------------------
*/
front.goods.buy 	= function(ajax_url,checkout_url){

	//加入购物车按钮
	$(document).on('click','span#cart-btn',function(){

		var  info 						= {};
	    var  goods_number 				= $('#goods_number').val();
	    var  goods_attr 				= front.goods.attr();
	    var  goods_id 					= $(this).data('goods_id');

	    	 //把商品所有字段属性赋值给info 再转化成json
	    	 info.goods_number 			= goods_number;
	    	 info.goods_attr 			= goods_attr;
	    	 info.goods_id 				= goods_id;
	    	 info.buy_tag 			    = 'cart';

	    	 //执行ajax操作
	    	 front.goods.ajax(ajax_url,checkout_url,info);
	})

	//购买按钮
	$(document).on('click','span#buy-btn',function(){

		var  info 						= {};
	    var  goods_number 				= $('#goods_number').val();
	    var  goods_attr 				= front.goods.attr();
	    var  goods_id 					= $(this).data('goods_id');

	    	 //把商品所有字段属性赋值给info 再转化成json
	    	 info.goods_number 			= goods_number;
	    	 info.goods_attr 			= goods_attr;
	    	 info.goods_id 				= goods_id;
	    	 info.buy_tag 			    = 'buy';

	    	 //执行ajax操作
	    	 front.goods.ajax(ajax_url,checkout_url,info);
	})
}

/*
|-------------------------------------------------------------------------------
|
|  获取商品的属性
|
|-------------------------------------------------------------------------------
*/
front.goods.attr 		= function(){

	var  arr 			= '';
    var  goods_attr     = $('input.attr_list');
    
    //循环获取被选中的商品属性单选按钮
    $.each(goods_attr , function(i,item){

    	
    	//如果单选按钮被选中
    	if($(item).prop('checked')){
    		//获取单选按钮的值
    		var item_val 	= $(item).val();
    		//把单选按钮的值放入数组
    		arr 			= arr + item_val;
    	}
    })
    //最后返回数组的值
    return arr;
}

/*
|-------------------------------------------------------------------------------
|
|  执行ajax操作
|
|-------------------------------------------------------------------------------
*/
front.goods.ajax  = function(ajax_url,checkout_url,info){


		$.ajax({

			'url':ajax_url,
			'type':'POST',
			'data':'info=' + $.toJSON(info),
			'dataType':'json',
			success:function(data){

				//成功加入购物车
				if(data.tag == 'ok'){

					//如果是加入购物车
					if(info.buy_tag == 'cart'){

						 //更新购物车信息
						 $('#top-cart-number').html(data.cart_num);

						 swal({
  									title: "<h5>已经成功加入购物车</h5>",
  									text: "<p>购物车中有商品：<strong>" + data.cart_num + "</strong><p><p><a href='" + checkout_url + "'>去结算</a></p>",
  									html: true
						});
					}

					//如果是直接购买 直接跳转到购物车页面
					if(info.buy_tag == 'buy'){

						window.location.href= checkout_url;
					}
				}

				//如果没有登录
				if(data.tag == 'nologin'){

					swal({
  									title: "<h5>" + data.info + "</h5>",
  									text: data.url,
  									html: true
					});
				}
			}
		});
}


/*
|-------------------------------------------------------------------------------
|
|  点击验证码图片 会激活ajax 重新生成验证码图片
|
|-------------------------------------------------------------------------------
*/
front.user.captcha  = function(ajax_url){

	$(document).on('click','.captcha-img img',function(){


		$.ajax({

			'url':ajax_url,
			'type':'POST',
			'dataType':'json',
			success:function(data){

				if(data.img){
					$('.captcha-img img').attr('src',data.img);
				}
				
			}
		})

	})
}


/*
|-------------------------------------------------------------------------------
|
|  购物车页面ajax操作 wap版本
|
|-------------------------------------------------------------------------------
*/
front.cart.init = function(ajax_url){

	//单选按钮点击事件
	$(document).on('click','input.cart-checkbox',function(){

		 var 	id 		= $(this).val();
		 var 	type 	= 'single';
		 var    code 	= 'checked';
		 var    info 	= {};
		 info.id 		= id;
		 info.type 		= type;
		 info.code 		= code;
		 info.value 	= front.cart.value();

		 front.cart.ajax(ajax_url ,info);
	});


	//商品数量+1
	$(document).on('click','.cart-add-btn',function(){

		 var  	id 		= $(this).parent('div.number-div').data('id');
		 var    type 	= 'single';
		 var    code 	= 'add'
		 var    info 	= {};
		 info.id 		= id;
		 info.type 		= type;
		 info.code 		= code;
		 info.value 	= front.cart.value();

		 front.cart.ajax(ajax_url,info); 
	});

	//商品数量 -1
	$(document).on('click','.cart-sub-btn',function(){

		 var  	id 				= $(this).parent('div.number-div').data('id');
		 var    type 			= 'single';
		 var 	code 			= 'sub';
		 var    info 			= {};
		 info.id 				= id;
		 info.type 				= type;
		 info.code 				= code;
		 info.value 			= front.cart.value();

		 front.cart.ajax(ajax_url,info); 
	})

	//删除单条记录
	$(document).on('click','span.cart-delete-btn',function(){

		var  that 	= this;

		 swal({
  					title: "确认删除吗?",
  					text: "删除后 可以重新再加入购物车",
  					type: "warning",
  					showCancelButton: true,
  					confirmButtonColor: "#DD6B55",
  					confirmButtonText: "删除",
  					closeOnConfirm: true
			 },
			 function(){

					var 	id 				= $(that).data('id');
					var 	type 			= 'single';
					var		code 			= 'delete';
					var 	info 			= {};
					info.id 				= id;
					info.type 				= type;
					info.code 				= code;
					info.value 				= front.cart.value();
					front.cart.ajax(ajax_url,info);

			});
	});


	//选中或者取消所有
	$(document).on('click','input#all_select',function(){

		var value 		 	   = 0;
		if($(this).prop('checked')){

			value			   = 1;

		}
		
		
		 var    type 			= 'all';
		 var 	code 			= 'checked';
		 var    info 			= {};
		 info.type 				= type;
		 info.code 				= code;
		 info.value 			= value;

		 front.cart.ajax(ajax_url,info); 
	})


	//清空购物车操作
	$(document).on('click','span.cart-empty',function(){

		swal({
  					title: "确认清空购物车吗?",
  					text: "您的操作会清空当前购物车",
  					type: "warning",
  					showCancelButton: true,
  					confirmButtonColor: "#DD6B55",
  					confirmButtonText: "确认清空",
  					closeOnConfirm: true
			 },
			 function(){

					var  type 			    = 'all';
					var  code 				= 'delete';
					var  info 				= {};
					info.type 				= type;
					info.code 				= code;
					info.value 				= front.cart.value();

					front.cart.ajax(ajax_url,info); 
			});
	})


	//批量删除选中的购物车记录
	$(document).on('click','#batch-delete-btn',function(){


		swal({
  					title: "确认删除吗?",
  					text: "您的操作会删除选中的项",
  					type: "warning",
  					showCancelButton: true,
  					confirmButtonColor: "#DD6B55",
  					confirmButtonText: "删除",
  					closeOnConfirm: true
			 },
			 function(){

					var  type 				= 'batch';
					var  code 				= 'delete';
					var  info 				= {};
		
					info.type 				= type;
					info.code 				= code;
					info.value 				= front.cart.value();
					info.ids 				= front.cart.ids();

					front.cart.ajax(ajax_url,info);
		    });
	})



}

/*
|-------------------------------------------------------------------------------
|
|  购物车wap版本激活ajax操作
|
|-------------------------------------------------------------------------------
*/
front.cart.ajax = function(ajax_url,info){

	$.ajax({

		'url':ajax_url,
		'type':'POST',
		'data':'info=' + $.toJSON(info),
		'dataType':'json',
		success:function(data){

			if(data.tag && data.tag =='sub_error'){

				swal('最小购买数量为1');
				return ;
			}

			var  list 		= data.list;
			$('#cart-table').html(list);
			$('#top-cart-number').html(data.number);
		}
	})
}

/*
|-------------------------------------------------------------------------------
|
|  获取value的值
|
|-------------------------------------------------------------------------------
*/
front.cart.value 	= function(){

	var value 		 	   	   = 0;
	if($('input#all_select').prop('checked')){

			value			   = 1;
	}

	return value;
}


/*
|-------------------------------------------------------------------------------
|
|  获取选中的购物车列表项
|
|-------------------------------------------------------------------------------
*/
front.cart.ids 		= function(){

	var  cart_list 		= $('input.cart-checkbox');
	var  ids 			= new Array();

	$.each(cart_list , function(i,item){

		if($(item).prop('checked')){

			ids.push($(item).val());
		}
	})

	return ids;
}



/*
|-------------------------------------------------------------------------------
|
|  地址ajax删除
|
|-------------------------------------------------------------------------------
*/
front.address.delete = function(ajax_url,back_url,_token){

	$(document).on('click','span.address-del-btn',function(){

		    var that 		= this;

			swal({
  					title: "确认删除吗?",
  					text: "您的操作会删除选中的项",
  					type: "warning",
  					showCancelButton: true,
  					confirmButtonColor: "#DD6B55",
  					confirmButtonText: "删除",
  					closeOnConfirm: true
			 },
			 function(){

			 		var  id 		= $(that).data('id');
		  			ajax_url 		= ajax_url + '/' + id;

		  			$.ajax({

		  	  			'url':ajax_url,
		  	  			'type':'DELETE',
		  	  			'data':'id=' + id +'&_token=' + _token,
		  	  			'dataType':'json',
		  	  			success:function(data){

		  	  					if(data.tag == 'ok'){

		  	  						location.href = back_url;
		  	  		   			}
		  	  			}

		  			})
			 });

	});
}


/*
|-------------------------------------------------------------------------------
|
|  地址ajax删除
|
|-------------------------------------------------------------------------------
*/
front.address.ajax = function(ajax_url ,back_url,_token){

	$(document).on('click','span.address-del-btn',function(){




		  var  id 		= $(this).data('id');
		  ajax_url 		= ajax_url + '/' + id;

		  $.ajax({

		  	  'url':ajax_url,
		  	  'type':'DELETE',
		  	  'data':'id=' + id +'&_token=' + _token,
		  	  'dataType':'json',
		  	  success:function(data){

		  	  		if(data.tag == 'ok'){

		  	  			windows.href = back_url;
		  	  		}
		  	  }
		  })
	})
}


/*
|-------------------------------------------------------------------------------
|
|  省会城市地区三级ajax联查
|
|-------------------------------------------------------------------------------
*/
front.address.pcd = function(ajax_url,_token){

	$(document).on('change','.pcd-select',function(){


		  var  region_id 	= $(this).val();
		  var  tag 			= $(this).data('tag');
		  var  that 		= this;

		  $.ajax({

		  	  'url':ajax_url,
		  	  'type':'POST',
		  	  'data':'region_id=' + region_id + '&tag=' + tag + '&_token=' + _token,
		  	  'dataType':'json',
		  	  success:function(data){
	
		  	  		$('#'+data.tag).html(data.str);
		  	  		//初始化select
		  	  		$('select').material_select();

		  	  }
		  });

		  //解决materializecss的bug
		  $(this.refs.yourSelectTag).material_select(this._handleSelectChange.bind(this));
	})
}

/*
|-------------------------------------------------------------------------------
|
|  选择配送方式的时候 刷新运费
|
|-------------------------------------------------------------------------------
*/
front.checkout.shipping = function(ajax_url,_token){

	$(document).on('click','.shipping_id',function(){

		 var shipping_id 		= $(this).val();

		 $.ajax({

		 	'url':ajax_url,
		 	'type':'POST',
		 	'data':'shipping_id=' + shipping_id + '&_token=' + _token,
		 	'dataType':'json',
		 	success:function(data){

		 		$('#shipping-fee').html(data.fee);
		 		$('#checkout-total').html(data.total);
		 	}
		 })
	})
}


/*
|-------------------------------------------------------------------------------
|
|  确认下单
|
|-------------------------------------------------------------------------------
*/
front.checkout.submit = function(ajax_url ,_token){

	$(document).on('click','#order-submit-btn',function(){

		 var  address_id    = 0;
		 var  pay_id 		= 0;
		 var  shipping_id 	= 0;

		 
		 $.each($('input[name="address_id"]') , function(i,item){

		 	 if($(this).prop('checked')){

		 	 	address_id 	= $(this).val();
		 	 }
		 });

		 $.each($('input[name="pay_id"]') , function(i,item){

		 	 if($(this).prop('checked')){

		 	 	pay_id 	= $(this).val();
		 	 }
		 });

		 $.each($('input[name="shipping_id"]') , function(i,item){

		 	 if($(this).prop('checked')){

		 	 	shipping_id 	= $(this).val();
		 	 }
		 })

		 if(address_id == 0){

		 	swal("请选择收货地址");
		 	return ;
		 }

		 if(pay_id == 0){

		 	swal("请选择支付方式");
		 	return ;
		 }

		 if(shipping_id == 0){

		 	swal("请选择配送方式");
		 	return;
		 }

		 var  info 				= {};
		 info.address_id 		= address_id;
		 info.pay_id 			= pay_id;
		 info.shipping_id 		= shipping_id;

		 $.ajax({

		 	'url':ajax_url,
		 	'type':'POST',
		 	'data':'info='+$.toJSON(info) +'&_token=' + _token,
		 	'dataType':'json',
		 	success:function(data){

		 		 if(data.info == 'cart_empty'){

		 		 	swal("购物车为空");
		 		 	return ;
		 		 }

		 		 if(data.info == 'error'){

		 		 	swal("购买异常");
		 		 	return ;
		 		 }

		 		 if(data.info == 'ok'){

		 		 	location.href = data.url;
		 		 }
		 	}
		 })


	})
}


/*
|-------------------------------------------------------------------------------
|
|  ajax收藏功能
|
|-------------------------------------------------------------------------------
*/
front.goods.collect = function(ajax_url,_token){

	$(document).on('click','.btn-collect',function(){

		 var goods_id 	= $(this).data('goods_id');
		 var that 		= this;
		 $.ajax({
		 	'url':ajax_url,
		 	'type':'POST',
		 	'data':'goods_id='+ goods_id + '&_token=' + _token,
		 	'dataType':'json',
		 	success:function(data){

		 		if(data.info == 'nologin'){

		 			swal("请登录后再收藏");
		 		}

		 		if(data.info == 'error'){

		 			swal("程序异常");
		 		}

		 		if(data.info == 'success'){

		 			$(that).find('i').html(data.str);
		 			$(that).find('small').html(data.number);
		 		}
		 	}
		 })
	})
}


/*
|-------------------------------------------------------------------------------
|
|  取消订单的相关操作
|
|-------------------------------------------------------------------------------
*/
front.mobile.dom_cancel = function(){

	$(document).on('click','.mobile-cancel-btn',function(){
        
		 var  url 	= $(this).data('url');
		 swal({
  					title: "确认该操作吗?",
  					text: "您的操作会取消或删除选中的项",
  					type: "warning",
  					showCancelButton: true,
  					confirmButtonColor: "#DD6B55",
  					confirmButtonText: "确认",
  					closeOnConfirm: true
			 },
			 function(){

			 		location.href = url;

			 });

	})
}



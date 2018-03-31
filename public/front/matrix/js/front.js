/*
|-------------------------------------------------------------------------------
|
| 前台页面需要的js文件集合
|
|-------------------------------------------------------------------------------
*/

var front 			= {};

front.home 			= {};
front.goods 		= {};
front.login 		= {};
front.register 	= {};
front.cart      = {};
front.supplier  = {};
front.attr 			= {};
front.user 		  = {};
front.color     = {};
front.common    = {};



/*
|-------------------------------------------------------------------------------
|
| 分类菜单的弹出效果
|
|-------------------------------------------------------------------------------
*/
front.category = function(){

	$(document).on('mouseenter','.category-nav li.item',function(){

		$(this).find('.dropdown-menu').addClass('animated pulse');
	});

}


/*
|-------------------------------------------------------------------------------
|
| 幻灯片效果
|
|-------------------------------------------------------------------------------
*/
front.home.slider  = function(){

	$(document).on('mouseenter','.slider',function(){


		 $(this).find('.left-arrow').addClass('animated slideInLeft').show();
		 $(this).find('.right-arrow').addClass('animated slideInRight').show();

	}).on('mouseleave','.slider',function(){

		 $(this).find('.left-arrow').hide();
		 $(this).find('.right-arrow').hide();

	})
}



/*
|-------------------------------------------------------------------------------
|
| div的边框动画效果
|
|-------------------------------------------------------------------------------
*/
front.home.border_animate = function(){

	$(document).on('mouseenter','.ad-box .ad1',function(){

			$(this).animate({borderColor: '#2196f3'});

	}).on('mouseleave','.ad-box .ad1',function(){

		    $(this).animate({borderColor: "#1abc9c"});

	});
}

/*
|-------------------------------------------------------------------------------
|
| 商品详情页面 jetzoom效果
|
|-------------------------------------------------------------------------------
*/
front.goods.jetzoom = function(){

	$(document).on('mouseenter','ul.goods-thumb li.list',function(){

		    $(this).addClass('active').siblings('li.list').removeClass('active');
	});

	$(document).on('mouseenter','.jetzoom',function(){

		$('.jetzoom-blank').find('div').eq(2).remove();
    });

}

/*
|-------------------------------------------------------------------------------
|
| 登录验证
|
|-------------------------------------------------------------------------------
*/
front.login.validate 	= function(ajax_url){


	// validate signup form on keyup and submit
        $("#login-form").validate({

            success: function(label) {    label.addClass("valid").html('<i class="fa fa-check"></i>');  },
            rules: {

                        username: {
                                        required: true,
                                        minlength: 2,

                                    },
                        password:{

                        				required:true,
                        				minlength:6
                        },
                        captcha:{

                        				required:true,
																remote:{
																					 url:ajax_url,
																					 data:{
																										captcha:function(){ return $('#captcha').val();}
																					},
																					type:'post',
																},
											 }
										},

            messages: {

                        username: {
                            required: "*必须*",
                            minlength: "*2位以上*"
                        },

                        password:{

                        	required:"*必须*",
                        	minlength:"*6位以上*"
                        },

                        captcha:{
                        	required:"*必须*",
													remote:"验证码错误",

                        }


            }
        });

}

/*
|-------------------------------------------------------------------------------
|
| 注册验证
|
|-------------------------------------------------------------------------------
*/
front.register.validate 	= function(ajax_url,captcha_url){


	// validate signup form on keyup and submit
        $("#register-form").validate({

            success: function(label) {    label.addClass("valid").html('<i class="fa fa-check"></i>');  },
            rules: {

                        username: {
                                        required: true,
                                        minlength: 2,
                                        remote: {
        											url: ajax_url,
        											type: "post",
        											data: {
          													
          													username: function() {

            																		return $( "#username" ).val();

          															  }
        											}

                                    	},
                        },

                        phone: {
                                        required: true,
                                        minlength:11,
                                        maxlength:11,

                        },
                        password:{

                        				required:true,
                        				minlength:6,
                        },

                        password_confirmation:{

                        				required:true,
                        				equalTo:'#password',

                        },

                        captcha:{

                        				required:true,
																remote:{

																				type:'post',
																				url :captcha_url,
																				data:{
																								captcha:function(){  return $('#captcha').val(); }
																				}
																},
                        },

                    },
            messages: {

                        username: {
                            required: "*必须*",
                            minlength: "*2位以上*",
                            remote:"*已存在*"
                        },
                        phone:{

                        	required:"*必须*",
                        	minlength:"*11位*",
                        	maxlength:"*11位*",
                        },

                        password:{

                        	required:"*必须*",
                        	minlength:"*6位以上*"
                        },
                        password_confirmation:{
                        	required:"*必须*",
                        	equalTo:"*密码验证*",

                        },
                        captcha:{
                        	required:"*必须*",
													remote:"验证码错误",
                        }

            }
        });

}


/*
|-------------------------------------------------------------------------------
|
|  icheckbox插件设置
|
|-------------------------------------------------------------------------------
*/
front.icheckbox       = function(){

    $(function(){

        //iCheck设置
        $('input.mycheckbox').iCheck({

            checkboxClass: 'icheckbox_square-blue',  //每个风格都对应一个，这个不能写错哈。
            radioClass: 'iradio_square-blue',

        });

        $("input[type='checkbox'][name='select_all']").on('ifChecked', function(event){

                $('input.checkbox-item').iCheck('check');
        }).on('ifUnchecked',function(){

                $('input.checkbox-item').iCheck('uncheck');
        })

    });
}


/*
|-------------------------------------------------------------------------------
|
|  购物车页面 增加商品数量ajax操作
|
|-------------------------------------------------------------------------------
*/
front.cart.number  = function(ajax_url,_token){

    $(function(){


        $(document).on('click','.cart-num-btn span',function(){

                //获取cart记录编号
                var id      = $(this).data('id');
                var tag     = $(this).data('tag');

                //执行ajax操作

                $.ajax({

                    'url':ajax_url,
                    'type':'POST',
                    'data':'id='+id +'&_token=' + _token + '&tag='+tag,
                    'dataType':'json',
                    success:function(data){

                        //根据data来生成购物车列表
                        front.cart.toHTML(data);

                    }


                });


        })
    })
}



/*
|-------------------------------------------------------------------------------
|
|  购物车页面 商品被选中 或者取消 ajax
|
|-------------------------------------------------------------------------------
*/
front.cart.checked  = function(ajax_url){

    $(function(){

         //如果单个商品被选中
         $(document).on('click','.ls-checkbox-item',function(){

                var  id               = $(this).data('id');
                var  is_checked       = 1;

                if($(this).hasClass('ls-checkbox-on')){

                    is_checked   = 0;
                }

                //执行ajax
                front.cart.checked_ajax(ajax_url,id,is_checked);
         });

    })
}


/*
|-------------------------------------------------------------------------------
|
|  购物车页面 商品全部被选中 或者全部取消 ajax
|
|-------------------------------------------------------------------------------
*/
front.cart.checked_all  = function(ajax_url){

     //商品全部被选中 或者全部被取消
     $(document).on('click','#ls-checkbox-all',function(){

          var is_checked    = 1;

          if($(this).hasClass('ls-checkbox-on')){

             is_checked     = 0;
          }

          $.ajax({

              url:ajax_url,
              type:'POST',
              data:'is_checked=' + is_checked,
              dataType:'json',
              success:function(data){

                 front.cart.toHTML(data);
              }
          })

     })
}



/*
|-------------------------------------------------------------------------------
|
|  执行ajax操作
|
|-------------------------------------------------------------------------------
*/
front.cart.checked_ajax  = function(ajax_url, id ,is_checked){

       $.ajax({

           type:'POST',
           url:ajax_url,
           data:'id=' + id  + '&is_checked=' + is_checked,
           dataType:'json',
           success:function(data){

               front.cart.toHTML(data);
           }
       })
}


/*
|-------------------------------------------------------------------------------
|
|  购物车更新后 根据json格式的数据 生成新的购物车表格内容
|
|-------------------------------------------------------------------------------
*/
front.cart.toHTML = function(data){

    if(data == 'error'){

        exit;
    }

    var  cart_list      = data.cart_list;
    var  cart_total     = data.cart_total;
    var  cart_number    = data.cart_number;
    var  is_all_checked = data.is_all_checked;

    var  checked_tag    = '';
    var  is_all_checked_cls  = 'ls-checkbox';

    if(is_all_checked == 1){

         is_all_checked_cls  = 'ls-checkbox ls-checkbox-on';
    }

    var  str            = '<table class="table table-bordered table-hover table-striped cart-table">'
                         +'<tr>'
                         +'<th style="width:60px;">'
                         +'<div class="' + is_all_checked_cls + '" id="ls-checkbox-all"></div>'
                         +'</th>'
                         +'<th style="width:110px;">缩略图</th>'
                         +'<th>商品名称</th>'
                         +'<th>商品属性</th>'
                         +'<th>商品价格</th>'
                         +'<th>数量</th>'
                         +'<th>小计</th>'
                         +'<th>操作</th>'
                         +'</tr>';

    $.each(cart_list ,function(i,item){

            var  ls_checkbox_cls   = 'ls-checkbox ls-checkbox-item';

            if(item.is_checked == 1){

                  ls_checkbox_cls   = 'ls-checkbox ls-checkbox-on ls-checkbox-item';

            }
            str +=  '<tr>'
                   +'<td style="vertical-align:middle; text-align:center;">'
                   +'<div class="' + ls_checkbox_cls +'" data-id="' + item.id + '"></div>'
                   +'</td>'
                   +'<td>'
                   +'<a href="'+item.url+'" target="_blank">'
                   +'  <img src="'+item.thumb+'" class="cart-thumb img-thumbnail" />'
                   +'</a>'
                   +'</td>'
                   +'<td style="vertical-align:middle; text-align:center;">'
                   +'<a href="'+item.url+'" target="_blank">'+item.goods_name+'</a>'
                   +'</td>'
                   +'<td style="vertical-align:middle; text-align:center;">'+item.goods_attr+'</td>'
                   +'<td style="vertical-align:middle; text-align:center;">'+item.shop_price+'</td>'
                   +'<td style="vertical-align:middle; text-align:center;width:100px;">'
                   +'<div class="cart-num-btn">'
                   +'<span class="cart-add-btn glyphicon glyphicon-plus" data-id="'+item.id+'" data-tag="add"></span>'
                   +'<input type="text" class="form-control goods_number" name="goods_number" '
                   +' id="goods_number'+item.id+'" value="'+item.goods_number+'" />'
                   +'<span class="cart-sub-btn glyphicon glyphicon-minus" data-id="'+item.id+'" data-tag="sub"></span>'
                   +'</div>'
                   +'</td>'
                   +'<td style="vertical-align:middle; text-align:center;">'
                   +'<span id="cart-list-total-'+item.id+'" class="cart-list-total">'+item.total+'</span>'
                   +'</td>'
                   +'<td style="vertical-align:middle; text-align:center;">'
                   +'<span class="btn btn-danger del cart-del-btn" data-id="'+item.id+'">'
                   +'<i class="fa fa-times"></i>'
                   +'删除'
                   +'</span>'
                   +'</td>'
                   +'</tr>';
    });

    $('#table-btn').html(str);
    $('.cart-total .num').html(cart_total + '元');
    $('.cart-total .checked_number').html(data.cart_number);
    $('.cart-total .total_number').html(data.all_number);
    $('#cart-number-ajax-btn').html(cart_number);
    front.icheckbox();
}


/*
|-------------------------------------------------------------------------------
|
|  购物车删除ajax操作
|
|-------------------------------------------------------------------------------
*/
front.cart.delete = function(ajax_url,_token){

    $(function(){


            $(document).on('click','.cart-del-btn',function(){

                  var  id       = $(this).data('id');

                  $.ajax({

                        'url':ajax_url,
                        'type':'POST',
                        'data':'id='+id + '&_token='+ _token,
                        'dataType':'json',
                        success:function(data){

                            front.cart.toHTML(data);
                        }

                  });
            })

    })
}


/*
|-------------------------------------------------------------------------------
|
|  省会城市地区地址三级联查ajax
|
|-------------------------------------------------------------------------------
*/
front.cart.pcd      = function(ajax_url,_token){

        $(function(){

                $(document).on('change','.pcd-select',function(){


                    var  region_id      = $(this).val();
                    var  region_type    = $(this).data('type');
                    var  tag            = $(this).data('tag');

                    var  info           = {};

                    info.region_id      = region_id;
                    info.region_type    = region_type;
                    info.tag            = tag;

                    //执行ajax操作
                    $.ajax({

                            'url':ajax_url,
                            'type':'POST',
                            'data':'info='+$.toJSON(info) +'&_token='+_token,
                            'dataType':'json',
                            success:function(data){

                                front.cart.pcdHTML(data);
                            }

                    });

                });

        });
}

/*
|-------------------------------------------------------------------------------
|
|  三级联查 刷新函数
|
|-------------------------------------------------------------------------------
*/
front.cart.pcdHTML = function(data){

      var region_list       = data.data;
      var dom_tag           = data.tag;
      var str               = '<option value="0">请选择</option>';

      $.each(region_list ,function(i,item){

           str             += '<option value="'+item.region_id+'">' + item.region_name + '</option>';
      });

      $('#'+dom_tag).html(str);
}


/*
|-------------------------------------------------------------------------------
|
|  ajax添加地址
|
|-------------------------------------------------------------------------------
*/
front.cart.address = function(ajax_url,_token,redirect_url){

    $(function(){

        $(document).on('click','#address-ajax-btn',function(){

              var  info                     = {};

              info.province                 = $('#province').val();
              info.city                     = $('#city').val();
              info.district                 = $('#district').val();
              info.consignee                = $('#consignee').val();
              info.email                    = $('#email').val();
              info.address                  = $('#address').val();
              info.phone                    = $('#phone').val();

              //执行ajax操作
              $.ajax({

                    'url':ajax_url,
                    'type':'POST',
                    'data':'info='+$.toJSON(info) +'&_token='+_token,
                    'dataType':'json',
                    success:function(data){

                        if(data.info == 'ok'){

                            location.href   = redirect_url;
                        }

                        if(data.info == 'error'){

                          alert('请输入完整的数据');
                        }
                    }
              });
        })

    })


}


/*
|-------------------------------------------------------------------------------
|
|  ajax删除地址信息
|
|-------------------------------------------------------------------------------
*/
front.cart.del_address = function(ajax_url,_token ,redirect_url){

   $(function(){

      $(document).on('click','.address-btn-del',function(){

            var  id     = $(this).data('id');


            $.ajax({

                'url':ajax_url,
                'type':'POST',
                'data':'id=' + id + '&_token=' + _token,
                'dataType':'json',
                success:function(data){

                     if(data.info == 'ok'){

                        location.href = redirect_url;
                     }

                     if(data.info =='error'){

                        alert('删除地址失败');
                     }
                }

            })
      })

   });
}


/*
|-------------------------------------------------------------------------------
|
|  ajax设置默认地址
|
|-------------------------------------------------------------------------------
*/
front.cart.def_address = function(ajax_url,_token ,redirect_url){



            $(document).on('click','.address-btn-def',function(){

                  var id    = $(this).data('id');

                  $.ajax({

                      'url':ajax_url,
                      'type':'POST',
                      'data':'id=' + id + '&_token=' + _token,
                      'dataType':'json',
                      success:function(data){

                            if(data.info == 'ok'){

                                location.href = redirect_url;
                            }

                            if(data.info == 'error'){

                                alert('设置失败');
                            }
                      }

                  })
            })


}

/*
|-------------------------------------------------------------------------------
|
|  ajax shipping配送费用
|
|-------------------------------------------------------------------------------
*/
front.cart.shipping  = function(ajax_url ,_token){

   $(function(){

        $(document).on('change','#shipping_id',function(){

               var shipping_id    = $(this).val();
                   shipping_id    = parseInt(shipping_id);

               var address_id     = $("input[name='address_id']:checked").val();
                   address_id     = parseInt(address_id);
                   //alert(address_id);
                   if(!address_id){

                       //alert('请选择收货地址');
                   }

                   $.ajax({

                        'url':ajax_url,
                        'type':'POST',
                        'data':'shipping_id='+ shipping_id + '&_token=' + _token + '&address_id=' + address_id,
                        'dataType':'json',
                        success:function(data){

                            var  fee      = data.fee;
                            var  total    = data.total;
                            var  tag      = data.tag;

                            if(tag == 'error'){

                                alert(data.info);
                            }



                                $('#shipping_fee').html(fee);
                                $('#checkout-total').html(total);

                        }
                   })

        })

   });
}


/*
|-------------------------------------------------------------------------------
|
|  确认下单
|
|-------------------------------------------------------------------------------
*/
front.cart.done   = function(ajax_url ,_token,redirect_url){

   $(function(){

        $(document).on('click','#checkout-done',function(){


             var  address_id    = $('input[name="address_id"]').val();
             var  pay_id        = $('#pay_id').val();
             var  shipping_id   = $('#shipping_id').val();

                  address_id    = parseInt(address_id);
                  pay_id        = parseInt(pay_id);
                  shipping_id   = parseInt(shipping_id);

                  if(address_id == 0){

                      swal('请选择收货地址');
                      return false;
                  }

                  if(pay_id == 0){

                      swal('请选择支付方式');
                      return false;
                  }

                  if(shipping_id == 0){

                      swal('请选择配送方式');
                      return false;
                  }

              var info                = {};
                  info.address_id     = address_id;
                  info.pay_id         = pay_id;
                  info.shipping_id    = shipping_id;

                  $.ajax({

                      'url':ajax_url,
                      'type':'POST',
                      'data':'info='+$.toJSON(info) + '&_token='+ _token,
                      'dataType':'json',
                      success:function(data){

                           if(data.info == 'cart_empty'){

                              alert('购物车中无产品');
                           }

                           if(data.info == 'error'){

                              alert('请登录再购物');
                           }

                           if(data.info == 'order_error'){

                              alert('订单生成失败');
                           }

                           if(data.info == 'success'){

                               location.href = redirect_url + '?order_id=' + data.order_id;
                           }
                      }

                  })




        })

   })

}


/*
|-------------------------------------------------------------------------------
|
|  添加到收藏夹
|
|-------------------------------------------------------------------------------
*/
front.goods.collect = function(ajax_url ,_token){

    $(document).on('click','.collect-btn',function(){

        var  goods_id   = $(this).data('id');

        $.ajax({

            'url':ajax_url,
            'type':'POST',
            'data':'goods_id=' + goods_id + '&_token=' + _token,
            'dataType':'json',
            success:function(data){

                 if(data.info == 'error'){

                    alert('请您登录后再收藏');
                 }

                 if(data.info == 'success'){

                    alert('收藏成功');
                 }

                 if(data.info =='cancel'){

                   alert('您已经取消收藏');
                 }
            }
        })

    })

}


/*
|-------------------------------------------------------------------------------
|
| 供货商注册验证
|
|-------------------------------------------------------------------------------
*/
front.supplier.register  = function(ajax_url,_token){


  // validate signup form on keyup and submit
        $(".supplier-form").validate({

            success: function(label) {    label.addClass("valid").html('<i class="fa fa-check"></i>');  },
            rules: {

                        username: {
                                        required: true,
                                        minlength: 2,
                                        remote: {
                              url: ajax_url,
                              type: "post",
                              data: {
                                    _token :_token,
                                    username: function() {

                                                return $( "#username" ).val();

                                          }
                              }

                                      },
                        },

                        phone: {
                                        required: true,
                                        minlength:11,
                                        maxlength:11,

                        },
                        password:{

                                required:true,
                                minlength:6,
                        },

                        password_confirmation:{

                                required:true,
                                equalTo:'#password',

                        },

                        form_captcha:{

                                required:true
                        },

                        email:{
                                required:true,
                                email:true,

                        },

                    },
            messages: {

                        username: {
                            required: "*必须*",
                            minlength: "*2位以上*",
                            remote:"*已存在*"
                        },
                        phone:{

                          required:"*必须*",
                          minlength:"*11位*",
                          maxlength:"*11位*",
                        },

                        password:{

                          required:"*必须*",
                          minlength:"*6位以上*"
                        },
                        password_confirmation:{
                          required:"*必须*",
                          equalTo:"*密码不一致*",

                        },
                        form_captcha:{
                          required:"*必须*"
                        },
                        email:{
                          required:"*必须*",
                          email:"*邮箱格式*"
                        }

            }
        });

}

/*
|-------------------------------------------------------------------------------
|
| 商品页选项卡
|
|-------------------------------------------------------------------------------
*/
front.goods.tab       = function(){

     $(function(){

        $(document).on('click','.goods-nav-title div.item',function(){

              $(this).addClass('item-curr').siblings('div.item').removeClass('item-curr');

              var  index    = $('.goods-nav-title .item').index(this);

              $('.nav-content').eq(index).show().siblings('div.nav-content').hide();

        })

     })
}


/*
|-------------------------------------------------------------------------------
|
| 导航栏
|
|-------------------------------------------------------------------------------
*/
front.nav           = function(current_url){

     var  nav_list  = $('.main-nav li.item a');

     $.each(nav_list,function(i,item){

         var  item_url  = $(item).attr('href');

         if(current_url == item_url){

             $(item).parent('li.item').addClass('item-active');
         }
     })
}


/*
|-------------------------------------------------------------------------------
|
|  jquery confirm 组件配置文件
|
|-------------------------------------------------------------------------------
*/
front.confirm  =  function(){

  $(".del-confirm").confirm({
                title:"删除提醒",
                text: "您将从数据库中删除该记录！您确认删除吗？",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                    window.location.href=$(button).data('url');
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);

                },
                confirmButton: "确认删除",
                cancelButton: "取消",
        confirmButtonClass: "btn btn-success",
          cancelButtonClass: "btn btn-danger",
          dialogClass: "modal-dialog"
    });
}


/*
|-------------------------------------------------------------------------------
|
|  商品属性选择
|
|-------------------------------------------------------------------------------
*/
front.attr.select = function(ajax_url){


	 //普通文字属性 点击效果
	 $(document).on('click','.attr-value-btn span.attr-value',function(){

		 				//如果元素被屏蔽
		 				if($(this).hasClass('attr-value-disabled')){
				 				return ;
		 				}

						$(this).parent('.attr-value-btn').find('.attr-value').removeClass('attr-value-curr');
						$(this).addClass('attr-value-curr');

						var parent_btn 		= $('.attr-value-btn').index($(this).parent('.attr-value-btn'));
								parent_btn    = parseInt(parent_btn);

								var tag 			= 1;
								if(parent_btn == 1){
									  tag 			= 2;
								}


								var  goods_id  = $('#goods_id').val();

								//获取第一个结点的值
								var  id 			 = 0;
								var  id2 			 = 0;

								//如果点击的是主结点
								if(tag == 1){
									   id 		 = $(this).data('id');
								}

								//如果点击的是从结点
								if(tag == 2){

										id2 		= $(this).data('id');


										//如果是文字属性
										if($('.attr-value-btn').eq(0).find('.attr-value-curr').data('id')){

											   id = $('.attr-value-btn').eq(0).find('.attr-value-curr').data('id');
										}
										//如果是图片属性
										else{

												id    = $('.attr-value-btn').eq(0).find('.attr-value-img-curr').data('id');
										}

								}//从结点结束

								var info 			= {};
								info.id 			= id;
								info.id2      = id2;
								info.goods_id = goods_id;
								info.tag 			= tag;
  							//执行ajax操作
						    front.attr.ajax(ajax_url,info);


	 });

	 //图片属性点击效果
	 $(document).on('click','img.attr-value-img',function(){

		 			$(this).addClass('attr-value-img-curr').siblings('img.attr-value-img').removeClass('attr-value-img-curr');

					var id 						= $(this).data('id');
					var goods_id 			= $('#goods_id').val();
					var tag 					= 1;
					var info 					= {};
					var id2   	      = 0;

							if($('.attr-value-curr').eq(0)){

								  id2 		   = $('.attr-value-curr').eq(0).data('id');
									id2 			 = parseInt(id2);
							}

					    info.id 			= id;
							info.id2      = id2;
							info.goods_id = goods_id;
							info.tag 			= tag;

					front.attr.ajax(ajax_url,info);
	 });

}

/*
|-------------------------------------------------------------------------------
|
|  主属性组的ajax操作
|
|-------------------------------------------------------------------------------
*/
front.attr.ajax = function(ajax_url,info){


	$.ajax({

		'url':ajax_url,
		'type':'POST',
		'data':'info=' + $.toJSON(info),
		'dataType':'json',
		success:function(data){

			if(data.product_sn){
				$('#ajax_goods_sn').html(data.product_sn);
			}

			if(data.product_number){
				$('#ajax_goods_number').html(data.product_number);
			}



			if(data.arr && data.tag == 1){

				 var attr_value  = $('.attr-value-btn').eq(1).find('span.attr-value');

				 //判断哪些结点不在arr数组中 则屏蔽该结点
				 $.each(attr_value,function(i,item){

							var  id  = $(item).data('id');
									 id  = parseInt(id);

									 $(item).addClass('attr-value-disabled');
									 $(item).removeClass('attr-value-curr');

							//循环判断id值是否在返回的数组中
							$.each(data.arr , function(i2,item2){

										 item2     = parseInt(item2);
										 if(item2 == id){

											 $(item).removeClass('attr-value-disabled');
										 }

							})

				 })

			}
		}

	})


}


/*
|-------------------------------------------------------------------------------
|
|  商品数量改变
|
|-------------------------------------------------------------------------------
*/
front.goods.num 	= function(){

	 //购买数量减1
	 $(document).on('click','.sub-num',function(){

				 var  goods_number 		= $('#goods_number').val();
				 		  goods_number 	  = parseInt(goods_number);

							if(goods_number > 1){

								  goods_number 	 = goods_number - 1;

									$('#goods_number').val(goods_number);
							}
							else{

								  alert('最小购买数量');
							}
	 });

	 //购买数量加1
	 $(document).on('click','.add-num',function(){

				 var  goods_number 		= $('#goods_number').val();
				 		  goods_number 	  = parseInt(goods_number);

							if(goods_number < 11){

								  goods_number 	 = goods_number + 1;

									$('#goods_number').val(goods_number);
							}
							else{

								  alert('超出购买数量');
							}
	 });
}


/*
|-------------------------------------------------------------------------------
|
|  ajax直接购买商品
|
|-------------------------------------------------------------------------------
*/
front.goods.buy   = function(ajax_url){

		$(document).on('click','.buy-btn',function(){

				 var 	goods_id 					= $('#goods_id').val();
				 var  goods_number  		= $('#goods_number').val();
				 //获取商品的属性
				 var  goods_attr 			  = front.goods.get_attr();
				 var  info 							= {};

							info.goods_id     = goods_id;
							info.goods_number = goods_number;
							info.goods_attr 	= goods_attr;

							$.ajax({

									'type':'POST',
									'url':ajax_url,
									'data':'info='+$.toJSON(info),
									'dataType':'json',
									success:function(data){

										  var  tag  	= data.tag;
											var  url    = data.url;
											var  info 	= data.info;

											if(tag == 'nologin'){

												 //未登陆 则提示去登陆
												 front.goods.popbox(data);
											}

											if(tag == 'ok'){

												 location.href = data.url;
											}
									}

							});

		});

}


/*
|-------------------------------------------------------------------------------
|
|  ajax直接购买商品
|
|-------------------------------------------------------------------------------
*/
front.goods.cart   = function(ajax_url){

		$(document).on('click','.add-to-cart-btn',function(){

				 var 	goods_id 					= $('#goods_id').val();
				 var  goods_number  		= $('#goods_number').val();
				 //获取商品的属性
				 var  goods_attr 			  = front.goods.get_attr();
				 var  info 							= {};

							info.goods_id     = goods_id;
							info.goods_number = goods_number;
							info.goods_attr 	= goods_attr;

							$.ajax({

									'type':'POST',
									'url':ajax_url,
									'data':'info='+$.toJSON(info),
									'dataType':'json',
									success:function(data){

										  var  tag  	= data.tag;
											var  url    = data.url;
											var  info 	= data.info;

											if(tag == 'nologin'){

												 //未登陆 则提示去登陆
												 front.goods.popbox(data);
											}

											if(tag == 'ok'){

												 var  obj 			= {};
												 			obj.url   = data.str;
															obj.info 	= data.info;
												 //弹出提示框
												 front.goods.popbox(obj);
												 //更新购物车中商品总数量
												 $('#cart-number-ajax-btn').html(data.cart_num);
											}
									}

							});

		});

}

/*
|-------------------------------------------------------------------------------
|
|  获取商品的属性值
|
|-------------------------------------------------------------------------------
*/
front.goods.get_attr  = function(){

		var  attr_value_btn  = $('.attr-value-btn');
		var  str 						 = '';
		var  attr_value      = '';

		$.each(attr_value_btn ,function(i,item){

							if($(item).find('.attr-value-curr').html()){

								    attr_value  = $(item).find('.attr-value-curr').html();
										 str 				= str + attr_value + ' ';
							}

							if($(item).find('.attr-value-img-curr').attr('title')){

								    attr_value  = $(item).find('.attr-value-img-curr').attr('title');
										 str 				= str + attr_value + ' ';
							}
		})
		return str;
}

/*
|-------------------------------------------------------------------------------
|
|  jquery confirm 组件配置文件
|
|-------------------------------------------------------------------------------
*/
front.goods.popbox  =  function(data){

		var info 			= data.info;
		var url 		  = data.url;

		$('.pop-box-info').html(info);
		$('.pop-box-url').html(url);
		$('.pop-box').fadeIn();
		$('.row .col-md-9').css('opacity','0.3');
		$('.goods-form').css('opacity','0.3');


		$(document).on('click','.pop-box-close',function(){

			   $(this).parent('.pop-box-tit').parent('.pop-box').fadeOut();
				 $('.row .col-md-9').css('opacity','1');
				 $('.goods-form').css('opacity','1');

		})
}


/*
|-------------------------------------------------------------------------------
|
|  ajax添加标签
|
|-------------------------------------------------------------------------------
*/
front.goods.tag   = function(ajax_url){

	 $(document).on('click','.add-tag-btn',function(){

		 	 var  tag_name 		= $('#tag_name').val();
			 var  goods_id    = $('#goods_id').val();


			 $.ajax({

				  'type':'POST',
					'url':ajax_url,
					'data':'tag_name='+tag_name + '&goods_id=' + goods_id,
					'dataType':'json',
					success:function(data){

						  var tag 	= data.tag;
							var info 	= data.info;


							if(tag == 'ok'){

								$('.tag-list').html(data.tag_list);
							}
							else{

								 alert(info);
							}
					}
			 })

	 });
}


/*
|-------------------------------------------------------------------------------
|
|  用户中心资料编辑
|
|-------------------------------------------------------------------------------
*/
front.user.edit  = function(){

	$(document).on('click','.edit-user-profile',function(){

			if($('.user-profile-div').is(':hidden')){

				    $('.user-profile-div').fadeIn();
						$(this).html('<span class="glyphicon glyphicon-minus"></span>关闭编辑');
			}else{

				   $('.user-profile-div').fadeOut();
					 $(this).html('<span class="glyphicon glyphicon-plus"></span>展开编辑');
			}

	});

}


/*
|-------------------------------------------------------------------------------
|
|  颜色选择器
|
|-------------------------------------------------------------------------------
*/
front.color.select = function(domain){



  $(document).on('click','.open-close-btn',function(){

			if($(this).hasClass('color-close')){

				   $('.color-style-content').animate({left:"0"});
					 $(this).removeClass('color-close');
			}
			else{
					 $('.color-style-content').animate({left:"-210px"});
					 $(this).addClass('color-close');
			}

	})

	//加载cookie中的配色方案
	if($.cookie('color_css_file')){

		 $('#color-css-btn').attr('href',$.cookie('color_css_file'));

		 var color_item   = $('.color-grid-item');

		 $.each(color_item ,function(i,item){


				  var  curr_css_file 		= $(item).find('span.color-item-span').eq(0).data('style_css_file');

					if(curr_css_file == $.cookie('color_css_file')){

							 $(item).find('i').show();
					}

		 })
	}

	//点击色块的效果
	$(document).on('click','.color-item-span',function(){

		    $('.color-item-span i').hide();
				$(this).find('i').show();
				var style_css_file 	= $(this).data('style_css_file');

				//获取色块的排序
				var  curr_num 	 = $('.color-grid-item').index($(this).parent('.color-grid-item'));
						 curr_num    = parseInt(curr_num);
						 curr_num    += 1;

						 //把选中的css文件写入cookie中
						 $.cookie('color_css_file', style_css_file ,{ expires: 7, path: '/',domain:domain});


						 $('#color-css-btn').attr('href',$.cookie('color_css_file'));

	})

}


/*
|-------------------------------------------------------------------------------
|
|  ajax直接购买商品
|
|-------------------------------------------------------------------------------
*/
front.common.cart   = function(ajax_url){

		$(document).on('click','.cart-icon',function(){

				 var 	goods_id 					= $(this).data('goods_id');
				 var  goods_number  		= 1;
				 //获取商品的属性
				 var  goods_attr 			  = '';
				 var  info 							= {};

							info.goods_id     = goods_id;
							info.goods_number = goods_number;
							info.goods_attr 	= goods_attr;

							$.ajax({

									'type':'POST',
									'url':ajax_url,
									'data':'info='+$.toJSON(info),
									'dataType':'json',
									success:function(data){

										  var  tag  	= data.tag;
											var  url    = data.url;
											var  info 	= data.info;

											if(tag == 'nologin'){

												 //未登陆 则提示去登陆
												 //front.goods.popbox(data);
												 alert(data.info);
											}

											if(tag == 'ok'){

												 var  obj 			= {};
												 			obj.url   = data.str;
															obj.info 	= data.info;
												 //弹出提示框
												 //front.goods.popbox(obj);
												 alert(data.info);
												 //更新购物车中商品总数量
												 $('#cart-number-ajax-btn').html(data.cart_num);
											}
									}

							});

		});

}


/*
|-------------------------------------------------------------------------------
|
|  点击 显示验证码
|
|-------------------------------------------------------------------------------
*/
front.captcha  = function(ajax_url){

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

				 });
	})
}

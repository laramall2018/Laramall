
/*
|-------------------------------------------------------------------------------
|
|  设置当前页效果
|
|-------------------------------------------------------------------------------
*/

var  ps = {};
     ps.menu = {};


/*
|-------------------------------------------------------------------------------
|
|  设置当前页效果
|
|-------------------------------------------------------------------------------
*/

ps.menu.init 	= function(page , tag){


	  var li_one 			= $('.page-sidebar-menu li.one');

	  var li_two 			= $('.page-sidebar-menu ul.sub-menu li');

      li_one.eq(0).addClass('start');

	  $.each(li_one , function(i,item){

	  		if($(this).data('page') == page ){

	  			$(this).addClass('active').siblings('li.one').removeClass('active');
	  			$(this).find('span.right-span').removeClass('arrow').addClass('selected');
	  		}

	  });

	  $.each(li_two , function(i,item){

	  		if($(this).data('tag') == tag ){

	  			$(this).addClass('active').siblings('li').removeClass('active');
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
ps.icheckbox       = function(){

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
|  系统权限设置js
|
|-------------------------------------------------------------------------------
*/
ps.privi_checkbox  = function(){


    $(function(){

        //点击父权限结点 激活所有子结点权限
        $('input.privi_checkbox').on('ifChecked',function(event){

                var privi_code  = $(this).data('value');
                $('input.'+privi_code+'_item').iCheck('check');

        }).on('ifUnchecked',function(event){

               var privi_code  = $(this).data('value');
               $('input.' + privi_code + '_item').iCheck('uncheck');
        });

    })
}


/*
|-------------------------------------------------------------------------------
|
|  jquery confirm 组件配置文件
|
|-------------------------------------------------------------------------------
*/
ps.confirm  =  function(){

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
				confirmButtonClass: "btn blue",
    			cancelButtonClass: "btn red",
    			dialogClass: "modal-dialog"
    });
}



/*
|-------------------------------------------------------------------------------
|
|  批量删除按钮
|
|-------------------------------------------------------------------------------
*/
ps.batch   = function(){


	$('.del-btn').confirm({


				title:"批量操作提醒",
                text: "您正在批量删除相关数据，您确认执行此操作吗？",
                confirm: function(button) {
                	var del_type 		= $(button).data('value');
                	$('#del_type').val(del_type);
                	$('.common-form').submit();

                },
                cancel: function(button) {


                },
                confirmButton: "确认执行",
                cancelButton: "取消",
				confirmButtonClass: "btn blue",
    			cancelButtonClass: "btn red",
    			dialogClass: "modal-dialog"
	});
}


/*
|-------------------------------------------------------------------------------
|
|  用delete方式递交删除按钮
|
|-------------------------------------------------------------------------------
*/
ps.btn_delete   = function(){

    $('.span-btn-delete').confirm({


                title:"删除提醒",
                text: "您正在删除相关数据，您确认执行此操作吗？",
                confirm: function(button) {
                    var id              = $(button).data('id');
                    var _token          = $(button).data('_token');
                    var url             = $(button).data('url');
                    ps.delete_ajax(url,id,_token);

                },
                cancel: function(button) {


                },
                confirmButton: "确认执行",
                cancelButton: "取消",
                confirmButtonClass: "btn blue",
                cancelButtonClass: "btn red",
                dialogClass: "modal-dialog"
    });
}


/*
|-------------------------------------------------------------------------------
|
|  商品详情页 添加商品时候 选项卡操作
|
|-------------------------------------------------------------------------------
*/
ps.goods_tab    = function(){

    $(document).on('click','.ps-tab-title li',function(){

          var  num      = $('.ps-tab-title li').index(this);
          $(this).addClass('cur').siblings('li').removeClass('cur');

          $('.ps-tab-content-item').eq(num).fadeIn().siblings('.ps-tab-content-item').hide();

    })
}


/*
|-------------------------------------------------------------------------------
|
|  uploaify批量ajax上传商品图片
|
|-------------------------------------------------------------------------------
*/
ps.uploadify    = function(swf_url,ajax_url,del_url,timestamp,token,_token){



        $(function() {
            $('#file_upload').uploadify({
                'method'   : 'post',
                'buttonText' : '批量上传图片',
                'formData'     : {
                    'timestamp' : timestamp,
                    'token'     : token,
                    '_token'    :_token
                },
                'swf'      : swf_url,
                'uploader' : ajax_url,

                'onUploadSuccess' : function(file, data, response) {
                    //alert('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);

                    var row = $.evalJSON(data);



                    var str = '<div class="img-item">'
                             +'<input type="hidden" name="source_imgs[]" value="'+row.upload_img+'">'
                             +'<input type="hidden" name="goods_thumbs[]" value="'+row.goods_thumb+'">'
                             +'<input type="hidden" name="goods_imgs[]" value="'+row.goods_img+'">'
                             + '{{HTML::image("' + row.upload_img + '")}}'
                             + '<span class="img-del"'
                             + ' data-goods_thumb ="'+ row.goods_thumb + '"'
                             + ' data-goods_img="'+row.goods_img +'"'
                             + ' data-source_img="'+row.upload_img + '"'
                             +'>'
                             + '<i class="fa fa-times fa-2x"></i>删除图片</span>'
                             + '</div>';

                    $('#goods-img-list').append(str);



                },
                'onUploadError' : function(file, errorCode, errorMsg, errorString) {
                    alert('The file ' + file.name + ' could not be uploaded: ' + errorString+errorCode);
                }

            });

            //删除动态生成的图片
            $('#goods-img-list').on('click','span.img-del',function(){

                //ajax删除图片信息

                var goods_thumb = $(this).data('goods_thumb');
                var goods_img   = $(this).data('goods_img');
                var source_img  = $(this).data('source_img');

                var that = this;

                var goods = new Object();

                goods.goods_thumb = goods_thumb;
                goods.goods_img   = goods_img;
                goods.source_img  = source_img;

                $.ajax({
                    'Type':'POST',
                    'url':del_url,
                    'data':'goods='+$.toJSON(goods),
                    'dataType':'json',
                    success: function(data){

                        if(data.info == 'ok'){

                            $(that).parent('.img-item').remove();
                        }
                    }

                });


            });
        });
}


/*
|-------------------------------------------------------------------------------
|
|  商品详情页 添加商品属性动态生成dom元素
|
|-------------------------------------------------------------------------------
*/
ps.add_goods_attr       = function(attr_list){

    $(document).on('click','.add-attr-btn',function(){

            var  attr_id                = $('#attr_id').val();
                 attr_id                = parseInt(attr_id);

                 if(attr_id == 0){

                    alert('请选择属性');
                    return false;
                 }

                 if(attr_id > 0){

                    //获取属性名称值
                    var  attr_name       = ps.get_attr_name(attr_id,attr_list);
                    //生成字符串
                    var  str             = ps.create_goods_attr_list_dom(attr_id,attr_name);
                    $('.attr-div').append(str);
                    //删除btn的操作
                    ps.del_goods_attr();
                 }

    })

}

/*
|-------------------------------------------------------------------------------
|
|  商品详情页 添加商品属性动态生成dom元素 生成商品属性值和属性价格添加表单
|
|-------------------------------------------------------------------------------
*/
ps.create_goods_attr_list_dom       = function(attr_id, attr_name){

     var str        = '<div class="form-group">'
                     +'<label class="col-md-3 control-label">'
                     + attr_name
                     +'</label>'
                     +'<div class="col-md-2">'
                     +'<input type="text" name="attr_value_list[]" id="attr_value_list" class="form-control">'
                     +'</div>'
                     +'<label class="col-md-1 control-label">属性价格</label>'
                     +'<div class="col-md-2">'
                     +'<input type="text" name="attr_price_list[]" id="attr_price_list" class="form-control">'
                     +'</div>'
                     +'<input type="hidden" name="attr_ids[]" value="' + attr_id +'">'
                     +'<div class="col-md-1"><span class="btn red attr-del-btn"><i class="fa fa-times"></i>删除</span></div>';
    return str;
}

/*
|-------------------------------------------------------------------------------
|
|  获取商品属性的名称
|
|-------------------------------------------------------------------------------
*/
ps.get_attr_name    = function(attr_id,attr_list){


     var  row       = $.parseJSON(attr_list);
     var  attr_name = '';

     $.each(row ,function(i,item){


         if(parseInt(item.attr_id) == parseInt(attr_id)){

             attr_name    = item.attr_name;
         }

     });

     return  attr_name;
}


/*
|-------------------------------------------------------------------------------
|
|  删除属性dom元素
|
|-------------------------------------------------------------------------------
*/
ps.del_goods_attr   = function(){

   $(document).on('click','span.attr-del-btn',function(){

      $(this).parent('.col-md-1').parent('.form-group').remove();

   });
}

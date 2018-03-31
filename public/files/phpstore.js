/*
|-------------------------------------------------------------------------------
|
| 后台相关js组件
|
|-------------------------------------------------------------------------------
*/
var  ps           = {};
     ps.menu      = {};
     ps.goods     = {};
     ps.article   = {};
     ps.gallery   = {};
     ps.image     = {};
     ps.relation  = {};



/*
|-------------------------------------------------------------------------------
|
| 激活后台菜单当前状态
|
|-------------------------------------------------------------------------------
*/

ps.menu.init      = function(page,tag){

     var  ul_list   = $('ul.panel-list li.one');

     $.each(ul_list , function(i,item){

          var  item_page    = $(item).data('page');

          if(item_page  == page ){

               $(item).addClass('active');
          }
     });

     var  li_list     = $('ul.panel-list li.two');

     $.each(li_list , function(i,item){

          var item_tag  = $(item).data('tag');

          if(item_tag == tag){

              $(item).addClass('active');
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


        //iCheck设置
        $('input.privi_checkbox').iCheck({

              checkboxClass: 'icheckbox_square-blue',  //每个风格都对应一个，这个不能写错哈。
              radioClass: 'iradio_square-blue',

        });


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
        confirmButtonClass: "btn btn-success",
          cancelButtonClass: "btn btn-danger",
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
                text: "您正在进行批量相关操作，您确认执行此操作吗？",
                confirm: function(button) {
                	var del_type 		= $(button).data('value');
                	$('#del_type').val(del_type);
                	//$('.common-form').submit();
                  $(button).parent('.form-group').parent('form').submit();

                },
                cancel: function(button) {


                },
                confirmButton: "确认执行",
                cancelButton: "取消",
				        confirmButtonClass: "btn btn-danger",
    			      cancelButtonClass: "btn btn-info",
    			      dialogClass: "modal-dialog"
	});
}





/*
|-------------------------------------------------------------------------------
|
|  国家省会城市地区三级联查ajax
|
|-------------------------------------------------------------------------------
*/
ps.province_city_district_ajax = function(ajax_url,_token){

    //通过省会获取省会下面的城市
    $(document).on('change','#province',function(){

          var region_id     = $('#province').val();
          var region_type   = 2;

          $.ajax({

             'type':'POST',
             'url' :ajax_url,
             'data':'region_id='+ region_id + '&_token=' + _token + '&region_type=' + region_type,
             'dataType':'json',
              success:function(data){

                  var region_list         = data.data;
                  var city_option_list    = ps.get_option(region_list);

                  $('#city').html(city_option_list);
              }

          })

    });

    //通过城市 获取城市下面的地区
    $(document).on('change','#city',function(){

          var region_id     = $('#city').val();
          var region_type   = 3;

          $.ajax({

             'type':'POST',
             'url' :ajax_url,
             'data':'region_id='+ region_id + '&_token=' + _token + '&region_type=' + region_type,
             'dataType':'json',
              success:function(data){

                  var region_list         = data.data;
                  var city_option_list    = ps.get_option(region_list);

                  $('#district').html(city_option_list);
              }

          })

    })

}


/*
|-------------------------------------------------------------------------------
|
|  把json格式的数据转化成 select表单所需要的下拉字符串
|
|-------------------------------------------------------------------------------
*/
ps.get_option  = function(data){

  var  str = '<option value="0">请选择</option>';

  $.each(data , function(i,item){

       str  += '<option value="'+ item.id+'">' + item.region_name + '</option>';
  });

   return str;

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

/*
|-------------------------------------------------------------------------------
|
|  点击按钮生成图片上传表单控件
|
|-------------------------------------------------------------------------------
*/
ps.create_upload_img_form = function(){

    $(document).on('click','.add-goods-img-btn',function(){


          var  str      = '<div class="form-group">'
                        + '<div class="col-md-3">'
                        + '<input type="file" name="original_imgs[]" data-buttonName="btn-primary"  />'
                        + '</div>'
                        + '<div class="col-md-3">'
                        + '<input type="text" name="img_descs[]" class="form-control" placeholder="图片说明" />'
                        + '</div>'
                        + '<div class="col-md-3">'
                        + '<span class="btn btn-default del-img-btn"><i class="fa fa-times"></i>删除</span>'
                        + '</div>'
                        + '</div>';

          $('.upload-img-div').append(str);
          $(":file").filestyle({buttonText: "上传图片"});

    });


    $(document).on('click','.del-img-btn',function(){

        $(this).parent('.col-md-3').parent('.form-group').remove();
    })
}


/*
|-------------------------------------------------------------------------------
|
|  点击商品类型 激活ajax操作 生成属性输入表单
|
|-------------------------------------------------------------------------------
*/
ps.goods_attr_ajax = function(ajax_url ,_token){

    $(document).on('change','#type_id',function(){

          var  type_id    = $(this).val();
               type_id    = parseInt(type_id);

               if(type_id == 0){

                  alert('请重新选择');
                  return false;
               }

          $.ajax({

                'type':'POST',
                'url' :ajax_url,
                'data':'type_id=' + type_id + '&_token=' + _token,
                'dataType':'json',
                 success:function(data){

                      //生成属性输入dom元素
                      var  str  = ps.get_goods_attr_list(data);
                      $('.goods-attr-div').html(str);
                 }

          });

    });
}


/*
|-------------------------------------------------------------------------------
|
|  根据返回的元素 输出属性添加表单
|
|-------------------------------------------------------------------------------
*/
ps.get_goods_attr_list = function(data){

    var row     = data.data;
    var str     = '';

    $.each(row , function(i,item){

         str  += '<div class="form-group">'
               + '<label class="col-md-3 control-label">' + item.attr_name + '</label>'
               + '<div class="col-md-2">'
               + '<input type="text" name="attr_values[]" class="form-control" />'
               + '</div>'
               + '<label class="col-md-1 control-label">属性价格</label>'
               + '<div class="col-md-2">'
               + '<input type="text" name="attr_prices[]" class="form-control" />'
               + '</div>'
               + '<div class="col-md-2">'
               + '<span class="btn btn-success add-attr-btn" data-attr_id="'+ item.id+'" data-attr_name="'+item.attr_name+'"><i class="fa fa-plus"></i>添加</span>'
               + '&nbsp;'
               + '<span class="btn btn-default del-attr-btn"><i class="fa fa-times"></i>删除</span>'
               + '</div>'
               + '<input type="hidden" name="attr_ids[]" value="' + item.id + '" />'
               + '<input type="hidden" name="goods_attr_ids[]" value="0" />'
               + '</div>';
    });

    return str;

}


/*
|-------------------------------------------------------------------------------
|
|  复制添加属性表单
|
|-------------------------------------------------------------------------------
*/
ps.add_attr_form      = function(){

        //生成的属性再次点击添加按钮 会再次生成属性输入表单
        $(document).on('click','.add-attr-btn',function(){

              var  attr_id      = $(this).data('attr_id');
              var  attr_name    = $(this).data('attr_name');
              var  str          = ps.create_attr_form(attr_id,attr_name);
              $(this).parent('.col-md-2').parent('.form-group').after(str);

        })
};


/*
|-------------------------------------------------------------------------------
|
|  生成属性添加表单
|
|-------------------------------------------------------------------------------
*/
ps.create_attr_form  = function(attr_id , attr_name){

     var str   = '<div class="form-group">'
               + '<label class="col-md-3 control-label">' + attr_name + '</label>'
               + '<div class="col-md-2">'
               + '<input type="text" name="attr_values[]" class="form-control" />'
               + '</div>'
               + '<label class="col-md-1 control-label">属性价格</label>'
               + '<div class="col-md-2">'
               + '<input type="text" name="attr_prices[]" class="form-control" />'
               + '</div>'
               + '<div class="col-md-2">'
               + '<span class="btn btn-success add-attr-btn" data-attr_id="'+ attr_id+'" data-attr_name="'+attr_name+'"><i class="fa fa-plus"></i>添加</span>'
               + '&nbsp;'
               + '<span class="btn btn-default del-attr-btn"><i class="fa fa-times"></i>删除</span>'
               + '</div>'
               + '<input type="hidden" name="attr_ids[]" value="' + attr_id + '" />'
               + '<input type="hidden" name="goods_attr_ids[]" value="0" />'
               + '</div>';
    return str;

}


/*
|-------------------------------------------------------------------------------
|
|  删除添加属性表单
|
|-------------------------------------------------------------------------------
*/
ps.del_attr_form = function(){

    $(document).on('click','.del-attr-btn',function(){

          $(this).parent('.col-md-2').parent('.form-group').remove();

    })

}


/*
|-------------------------------------------------------------------------------
|
|  点击商品类型 激活ajax操作 生成规格输入表单
|
|-------------------------------------------------------------------------------
*/
ps.goods_field_ajax = function(ajax_url ,_token){

    $(document).on('change','#field_type_id',function(){

          var  type_id    = $(this).val();
               type_id    = parseInt(type_id);

               if(type_id == 0){

                  alert('请重新选择');
                  return false;
               }

          $.ajax({

                'type':'POST',
                'url' :ajax_url,
                'data':'type_id=' + type_id + '&_token=' + _token,
                'dataType':'json',
                 success:function(data){

                      //生成属性输入dom元素
                      var  str  = ps.get_goods_field_list(data);
                      $('.goods-field-div').html(str);
                 }

          });

    });
}


/*
|-------------------------------------------------------------------------------
|
|  生成规格的输入表单dom元素
|
|-------------------------------------------------------------------------------
*/
ps.get_goods_field_list = function(data){

    var str     = '';
    var row     = data.data;

    $.each(row , function(i,item){

        str  += '<div class="form-group">'
              + '<label class="col-md-3 control-label">' + item.field_name+ '</label>'
              + '<div class="col-md-4">'
              + '<input type="text" name="field_values[]" class="form-control" />'
              + '</div>'
              + '<input type="hidden" name="field_ids[]" value="' +item.id + '">'
              + '</div>';

    });

    return str;

}

/*
|-------------------------------------------------------------------------------
|
|  商品ajax搜查
|
|-------------------------------------------------------------------------------
*/
ps.goods.search  = function(ajax_url,_token){


    //点击激活ajax操作
    $(document).on('click','#search-goods-btn',function(){

      var  cat_id       = $('#search_cat_id').val();
      var  brand_id     = $('#search_brand_id').val();
      var  keywords     = $('#search_keywords').val();
      var  info         = {};

      info.cat_id       = cat_id;
      info.brand_id     = brand_id;
      info.keywords     = keywords;
          $.ajax({

              'type':'POST',
              'url' :ajax_url,
              'data':'info=' + $.toJSON(info) + '&_token=' + _token,
              'dataType':'json',
              success:function(data){

                   var  table   = ps.goods.get_table(data.data);
                   $('#search-goods-list').html(table);
                   ps.icheckbox();
              }

          });
    });
}


/*
|-------------------------------------------------------------------------------
|
|  获取商品列表
|
|-------------------------------------------------------------------------------
*/
ps.goods.get_table  = function(data){

     var  str = '<table class="table table-striped table-bordered table-hover ajax-sort-tab">'
              + '<tr>'
              + '<th><input type="checkbox" class="icheck mycheckbox" name="select_all">商品编号</th>'
              + '<th>商品名称</th>'
              + '</tr>';

      $.each(data,function(i,item){

           str += '<tr>'
                + '<td><input type="checkbox" class="icheck mycheckbox checkbox-item" name="ids[]" value="' + item.id + '">' + item.id + '</td>'
                + '<td>' + item.goods_name + '</td>'
                + '</tr>';
      })

          str   += '</table>';
          return str;
}



/*
|-------------------------------------------------------------------------------
|
|  ajax搜索文章列表
|
|-------------------------------------------------------------------------------
*/
ps.article.search  = function(ajax_url,_token){


    //点击激活ajax操作
    $(document).on('click','#search-article-btn',function(){

      var  cat_id       = $('#search_article_cat_id').val();
      var  keywords     = $('#article_keywords').val();
      var  info         = {};

      info.cat_id       = cat_id;
      info.keywords     = keywords;
          $.ajax({

              'type':'POST',
              'url' :ajax_url,
              'data':'info=' + $.toJSON(info) + '&_token=' + _token,
              'dataType':'json',
              success:function(data){

                   var  table   = ps.article.get_table(data.data);
                   $('#search-article-list').html(table);
                   ps.icheckbox();
              }

          });
    });
}


/*
|-------------------------------------------------------------------------------
|
|  获取商品列表
|
|-------------------------------------------------------------------------------
*/
ps.article.get_table  = function(data){

     var  str = '<table class="table table-striped table-bordered table-hover ajax-sort-tab">'
              + '<tr>'
              + '<th><input type="checkbox" class="icheck mycheckbox" name="select_all">文章编号</th>'
              + '<th>文章标题</th>'
              + '</tr>';

      $.each(data,function(i,item){

           str += '<tr>'
                + '<td><input type="checkbox" class="icheck mycheckbox checkbox-item" name="article_ids[]" value="' + item.id + '">' + item.id + '</td>'
                + '<td>' + item.title + '</td>'
                + '</tr>';
      })

          str   += '</table>';
          return str;
}


/*
|-------------------------------------------------------------------------------
|
|  ajax删除商品相册
|
|-------------------------------------------------------------------------------
*/
ps.gallery.delete  = function(ajax_url,_token){

   $(document).on('click','.del-img-btn-ajax',function(){

        var  id       = $(this).data('id');

        $.ajax({

          'type':'POST',
          'url':ajax_url,
          'data':'id=' + id + '&_token=' + _token,
          'dataType':'json',
          success:function(data){

              var  str  = ps.gallery.image(data.data);
              $('.goods-img-list').html(str);
          }

        })

})

/*
|-------------------------------------------------------------------------------
|
|  用json格式的数据 重新生成商品图片列表
|
|-------------------------------------------------------------------------------
*/
ps.gallery.image = function(data){

    var  str  = '';
    $.each(data ,function(i,item){

          str += '<div class="img-item">'
         	     + '<img src="'+ item.thumb +'" class="img-thumbnail" />'
               + '<span class="del-img-btn-ajax btn btn-danger" data-id="' + item.id + '">'
               + '<i class="fa fa-times"></i>删除</span>'
               + '</div>';

    });

    return str;
}



}


/**
 * 权限的panel 盒子 点击折叠功能
 *
 */
ps.panel  = function(){

    $(document).on('click','.panel-privi-box .panel-heading',function(){

        if($(this).parent('.panel-privi-box').find('.panel-body').is(':hidden')){

            $(this).parent('.panel-privi-box').find('.panel-body').show();

        }
        else{

            $(this).parent('.panel-privi-box').find('.panel-body').hide();
        }
    })
}


/*
|-------------------------------------------------------------------------------
|
|  省会城市地区三级ajax联查js
|
|-------------------------------------------------------------------------------
*/
ps.pcd      = function(ajax_url,_token){

  $(function(){

      $(document).on('change','.pcd-select',function(){

              var  region_id            = $(this).val();
              var  region_type          = $(this).data('type');
              var  tag                  = $(this).data('tag');

              var  info                 = {};
                   info.region_id       = region_id;
                   info.region_type     = region_type;
                   info.tag             = tag;


                   $.ajax({

                      'url':ajax_url,
                      'type':'POST',
                      'data':'info='+$.toJSON(info) + '&_token=' + _token,
                      'dataType':'json',
                      success:function(data){

                            var  row        = data.data;
                            var  dom_tag    = data.tag;
                            var  str        = '<option value="">请选择</option>';

                            $.each(row,function(i,item){

                                  str   +='<option value="' + item.region_id + '">' + item.region_name + '</option>';
                            })

                            $('#'+dom_tag).html(str);
                      }

                   })


      })

  })

}


/*
|-------------------------------------------------------------------------------
|
|  颜色属性图片ajax删除
|
|-------------------------------------------------------------------------------
*/
ps.color_del  = function(ajax_url){

    $(function(){

       $(document).on('click','#color-img-del-btn',function(){

            var  id       = $(this).data('id');

            $.ajax({

                'url':ajax_url,
                'type':'POST',
                'data':'id=' + id,
                'dataType':'json',
                success:function(data){

                    var  info       = data.info
                    var  message    = data.message;

                    if(info == 'off'){

                       alert(message);
                    }

                    if(info == 'ok'){

                       $('#color-img-content').remove();
                    }

                }

            })

       })
    })
}


/*
|-------------------------------------------------------------------------------
|
|  重新生成新尺寸的商品图片
|
|-------------------------------------------------------------------------------
*/
ps.image.resize   = function(ajax_url,current_page ,last_page ,per_page ,total){

     $(function(){

          $(document).on('click','#image-redo-btn',function(){

                ps.image.ajax(ajax_url,current_page ,last_page ,per_page ,total);
          });

     })
}


/*
|-------------------------------------------------------------------------------
|
|  重新生成新尺寸的商品图片
|
|-------------------------------------------------------------------------------
*/
ps.image.ajax  = function(ajax_url,current_page ,last_page ,per_page ,total){



      var  info                   = {};
           info.current_page      = current_page;
           info.last_page         = last_page;
           info.per_page          = per_page;
           info.total             = total;

           $.ajax({

                    'url':ajax_url,
                    'type':'POST',
                    'data':'info='+$.toJSON(info),
                    'dataType':'json',
                    success:function(data){

                         var  count             = parseInt(data.count);
                         var  current_page      = parseInt(data.current_page);
                         var  last_page         = parseInt(data.last_page);
                         var  per_page          = parseInt(data.per_page);
                         var  total             = parseInt(data.total);

                         
                         //显示状态
                         ps.image.status(current_page,count); 

                         if(current_page < last_page){

                             current_page       = parseInt(current_page)  + 1;
                             ps.image.ajax(ajax_url,current_page ,last_page ,per_page ,total);
                            

                         }else{


                           ps.image.last(total);
                              
                         }

                    }
              });

}



/*
|-------------------------------------------------------------------------------
|
|  刷新状态
|
|-------------------------------------------------------------------------------
*/
ps.image.status  = function(current_page,count){

      var  alert_div    =  ps.image.alert(current_page , count);

      $('#redo-btn').show();
      $('#redo-ajax-btn').append(alert_div);
}

/*
|-------------------------------------------------------------------------------
|
|  最后提示
|
|-------------------------------------------------------------------------------
*/
ps.image.last   = function(total){


     var  str     = '<div class="alert alert-success">'
                  + '<span>您已经处理完所有产品图片，共计：' + total + '个</span>'
                  + '&nbsp;&nbsp;<a href="" class="btn btn-info">返回</a>'
                  + '</div>';
      $('#redo-ajax-btn').append(str);
}


/*
|-------------------------------------------------------------------------------
|
|  生成提示alert的div
|
|-------------------------------------------------------------------------------
*/
ps.image.alert  = function(current_page , count){


    var  str            = '<div class="alert alert-info">'
                        + '<span>成功处理第:'+current_page +'页的产品</span>'
                        + '<span>商品数量:'+count + '</span>'
                        + '</div>';
    return str;
}


/*
|-------------------------------------------------------------------------------
|
|  删除关联商品信息
|
|-------------------------------------------------------------------------------
*/
ps.relation.delete   = function(){

   $(document).on('click','span.relation-del-btn',function(){

        var  ajax_url   = $(this).data('url');

        $.ajax({

           type:'POST',
           url:ajax_url,
           dataType:'json',
           success:function(data){

               if(data.tag =='error'){

                  alert(data.info);
               }

               if(data.tag == 'success'){

                  ps.relation.createHTML(data.list);
               }
           }
        })
   })
}

/*
|-------------------------------------------------------------------------------
|
|  重新生成关联商品的html元素
|
|-------------------------------------------------------------------------------
*/
ps.relation.createHTML  = function(row){

     var  str     = '<table class="table table-bordered table-hover table-striped">'
                  + '<tr>'
                  + '<th>商品名称</th>'
                  + '<th style="width: 80px;">商品图片</th>'
                  + '<th style="width: 100px;">相关操作</th>'
                  + '</tr>';
         $.each(row,function(i,item){

            str  += '<tr>'
                  + '<td>'+ item.goods_name +'</td>'
                  + '<td><img class="thumb" src="' + item.thumb+ '"></td>'
                  + '<td>'
                  + '<span class="btn btn-danger del-btn relation-del-btn" data-url="'+item.url+'">'
                  + '<i class="fa fa-times"></i>'
                  + '删除'
                  + '</span>'
                  + '</td>'
                  + '</tr>';
          });
            
            str += '</table>';

        $('#goods-relationed-list').html(str);
}


/*
|-------------------------------------------------------------------------------
|
|  ajax删除商品属性值
|
|-------------------------------------------------------------------------------
*/
ps.goods_attr_delete  = function(ajax_url){

    $(document).on('click','span.del-attr-btn-ajax',function(){

         var  goods_attr_id     = $(this).data('goods_attr_id');

         $.ajax({

              url:ajax_url,
              type:'DELETE',
              data:'goods_attr_id=' + goods_attr_id,
              dataType:'json',
              success:function(data){

                  if(data.tag == 'error'){

                     alert(data.info);
                  }
              }
         })
    })
}


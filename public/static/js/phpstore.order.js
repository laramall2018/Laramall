
/*
|------------------------------------------------------------------------------- 
|   phpstore商城系统后 grid操作js封装
|   系统表格ajax分页排序grid相关操作js文件
|   网址：www.phpstore.cn
|   技术支持QQ：179536444
|------------------------------------------------------------------------------- 
*/

//var ps = {};
 ps.ui = {};


/*
|-------------------------------------------------------------------------------
|
|  ajax排序算法
|
|-------------------------------------------------------------------------------
*/
ps.ui.grid  = function(ajax_url,_token){

    //点击th切换排序
    ps.ui.sort(ajax_url , _token);
    
    //per_page选择 选择每页个数 激活ajax刷新
    ps.ui.page_select(ajax_url,_token);

    //点击分页 激活ajax操作 并刷新表单数据
    ps.ui.page_click(ajax_url , _token);

    //输入关键字 进行关键字搜索
    ps.ui.search(ajax_url , _token);

    //选择订单状态搜索
    //ps.ui.order_status(ajax_url , _token);

}


/*
|-------------------------------------------------------------------------------
|
| 点击th项目 执行ajax排序 并通过返回的json数据 刷新新的table和分页信息
|
|-------------------------------------------------------------------------------
*/
ps.ui.sort = function(ajax_url , _token){

    $(document).on('click','span.ajax-sort',function(){

        var sort_name      = $(this).parent('th.tit').data('sort_name');
        var sort_value     = $(this).parent('th.tit').data('sort_value');
        var per_page       = $('#per_page').val();
        var keywords       = ps.ui.keywords();
        var page           = 1;

        //新添加的几个搜索参数
        var fieldRow       = ps.ui.fieldRow();

        //如果page不存在 默认设置为1

        if($('ul.pagination li.active span').length > 0){

            page            = $('ul.pagination li.active span').html();

        }



        //激活ajax操作 并刷新页面
        ps.ui.ajax(ajax_url , sort_name , sort_value , _token , page , per_page , fieldRow , keywords);
        
    
    });


}


/*
|-------------------------------------------------------------------------------
|
| 选择分页大小 并返回json数据 刷新table数据和分页信息
|
|-------------------------------------------------------------------------------
*/

ps.ui.page_select = function(ajax_url , _token){

    $(document).on('change','#per_page',function(){

        var sort_name           = $('table.ajax-sort-tab th.active').data('sort_name');
        var sort_value_var      = $('table.ajax-sort-tab th.active').data('sort_value');
        var page                = 1;
        var per_page            = $('#per_page').val();
        var keywords            = ps.ui.keywords();
        var fieldRow            = ps.ui.fieldRow();
       


        if($('ul.pagination li.active span').length > 0){

            page            = $('ul.pagination li.active span').html();
            
        }

        if(sort_value_var  == 'desc'){

            sort_value = 'asc';
        }

        if(sort_value_var == 'asc'){

            sort_value = 'desc';
        }


        //激活ajax操作 根据返回的json数据生成table表格和分页信息
        ps.ui.ajax(ajax_url , sort_name , sort_value , _token , page , per_page , fieldRow , keywords);


    });
}



/*
|-------------------------------------------------------------------------------
|
| 点击分页的链接 激活ajax操作 并刷新表格数据和分页数据信息
|
|-------------------------------------------------------------------------------
*/
ps.ui.page_click = function(ajax_url , _token){

    //ajax的分页效果

    $(document).on('click','ul.pagination li a.ajax-a', function (){
                
               
                var sort_name           = $('table.ajax-sort-tab th.active').data('sort_name');
                var sort_value_var      = $('table.ajax-sort-tab th.active').data('sort_value');
                var page                = $(this).data('page');
                var per_page            = $('#per_page').val();
                var keywords            = ps.ui.keywords();
                var fieldRow            = ps.ui.fieldRow();

                if(sort_value_var  == 'desc'){

                    sort_value = 'asc';
                }

                if(sort_value_var == 'asc'){

                    sort_value = 'desc';
                }

            //ajax搜索 并返回json数据 刷新table数据和分页信息
           ps.ui.ajax(ajax_url , sort_name , sort_value , _token , page , per_page , fieldRow , keywords);

            
    });

}



/*
|-------------------------------------------------------------------------------
|
| 关键字ajax搜索
|
|-------------------------------------------------------------------------------
*/
ps.ui.search = function(ajax_url , _token){

    //ajax递交表单
    $(document).on('click','#order-status-btn',function(){



        

        var sort_name           = $('table.ajax-sort-tab th.active').data('sort_name');
        var sort_value_var      = $('table.ajax-sort-tab th.active').data('sort_value');
        var page                = 1;
        var per_page            = $('#per_page').val();
        var sort_value          = '';
        var keywords            = ps.ui.keywords();
        var fieldRow            = ps.ui.fieldRow();

        

        if($('ul.pagination li.active span').length > 0){

            page            = $('ul.pagination li.active span').html();
            
        }

        if(sort_value_var  == 'desc'){

                    sort_value = 'asc';
        }

        if(sort_value_var == 'asc'){

                    sort_value = 'desc';
        }

        //激活ajax操作 并刷新页面
        ps.ui.ajax(ajax_url , sort_name , sort_value , _token , page , per_page , fieldRow , keywords);


    });
}




/*
|-------------------------------------------------------------------------------
|
|  根据返回的json数据 生成全新的数组
|
|-------------------------------------------------------------------------------
*/

ps.ui.create = function(data){

    var str = '<table cellpadding="0" cellspacing="0" class="my-tab ajax-sort-tab">';

    var col = data.col;
    var sort_name = data.sort_name;
    var sort_value = data.sort_value;
    
    //先生成th
    var table_th = ps.ui.th(data);
    //循环生成table的主要数据
    var table_data = ps.ui.main(data);

    

    str += table_th;
    str += table_data;
    str += '</table>';


    return str;

     
}

/*
|-------------------------------------------------------------------------------
|
|  根据返回的json数据 生成table的th项
|
|-------------------------------------------------------------------------------
*/

ps.ui.th = function(data){

    var str             = '<tr>'
    var col             = data.col;
    var sort_name       = data.sort_name;
    var sort_value      = data.sort_value;
    

    str += '<th class="tit" style="width:80px;"> <input class="checkbox" type="checkbox" name="select_all" /> 选择</th>';

    $.each(col , function(i,item){

        


        if(item.col_name == sort_name){

            if(sort_value == 'desc'){


                str += '<th class="tit active" data-sort_name="'+item.col_name +  '" data-sort_value="asc" style="width:' + item.width + '">';

                str  += '<span class="ajax-sort">'+ item.col_value +'</span>'
                     +  '<i class="fa fa-sort-desc" style="padding:0 5px;"></i>'
                     +  '</th>';

            }
            else{

                str += '<th class="tit active" data-sort_name="'+item.col_name +  '" data-sort_value="desc" style="width:' + item.width + '">';

                str  += '<span class="ajax-sort">'+ item.col_value +'</span>'
                     +  '<i class="fa fa-sort-asc" style="padding:0 5px;"></i>'
                     +  '</th>';


            }
        }

        else{

                str += '<th class="tit" data-sort_name="'+item.col_name +  '" data-sort_value="desc" style="width:' + item.width +  '">';

                str  += '<span class="ajax-sort">'+ item.col_value +'</span>'
                     +  '</th>';
            
        }

    });

    str += '<th class="tit" style="width:100px;">相关操作</th>'
        +  '</tr>';

    return str;


}

/*
|-------------------------------------------------------------------------------
|
|  根据返回的json数据 生成table的主要数据项目
|
|-------------------------------------------------------------------------------
*/
ps.ui.main = function(data){

    var col             = data.col;
    var sort_name       = data.sort_name;
    var sort_value      = data.sort_value;
    var row             = data.data;
    var str             = '';

    

    $.each(row ,function(i,item){

        str += '<tr>';
        str += '<td><input class="checkbox" type="checkbox" name="ids[]" value="'+ item[col[0].col_name] + '" /></td>';
        $.each(col, function(j,item2){

            str +='<td>' + item[item2.alias_name] + '</td>';

        });

        var edit_url        = item['edit_url'];
        var del_url         = item['del_url'];
        
        str += '<td style="width:150px;">'+ edit_url +'|'+del_url +'</td>';
       

        str +='</tr>';
    });

    //返回数据
    return str;

}


/*
|-------------------------------------------------------------------------------
|
| 系统初始化
|
|-------------------------------------------------------------------------------
*/

ps.ui.table_init = function(){

        $('table.my-tab tr:last').addClass('last');
        $('table.my-tab tr td:last-child').addClass('td-last');
        $('table.my-tab tr th:last-child').addClass('th-last');
        $('table.my-tab').on('mouseenter','tr',function(){

            $(this).addClass('tr-hover');
        }).on('mouseleave','tr',function(){

            $(this).removeClass('tr-hover');
        });

        $('table.my-tab tr:even').addClass('tr-even');


        //checkbox选择

        $("input[name='select_all']").click(function(){

            if($("input[name='select_all']").prop('checked')){
                
                 $("input[type='checkbox'][name='ids[]']").prop('checked',true);
            }
            else{

                $("input[type='checkbox'][name='ids[]']").prop('checked',false);
            }
        })

}


/*
|-------------------------------------------------------------------------------
|
| 执行ajax操作 并通过json返回table数据和分页数据信息
|
|-------------------------------------------------------------------------------
*/
ps.ui.ajax = function(ajax_url , sort_name , sort_value , _token , page , per_page ,fieldRow , keywords){

    var info = {};

    info.ajax_url           = ajax_url;
    info.sort_name          = sort_name;
    info.sort_value         = sort_value;
    info._token             = _token;
    info.page               = page;
    info.per_page           = per_page;
    info.fieldRow           = fieldRow;
    info.keywords           = keywords;
    
    //ajax搜索 并返回json数据 刷新table数据和分页信息
            $.ajax({

                'url':ajax_url,
                'type':'POST',
                'data':'info=' + $.toJSON(info),
                'dataType':'json',
                 success:function(data){

                    //更加返回的json数据生成table表格
                     var str = ps.ui.create(data);
                     $('#ajax-box').html(str);
                    //根据json数据 生成分页数据
                    var page_str   = data.links;
                    $('#ajax-page').html(page_str);
                    $('#ajax-page-bar .ajax-total').html('总记录为：' + data.page.total);

                    //初始化生成的表格数据
                    ps.ui.table_init();
                 }


            });
}


/*
|-------------------------------------------------------------------------------
|
| 点击 切换显示状态 ajax
|
|-------------------------------------------------------------------------------
*/
ps.ui.is_show = function(ajax_url , _token){

    
    ps.ui.is_tag_click(ajax_url , _token ,'is_new');
    ps.ui.is_tag_click(ajax_url , _token ,'is_best');
    ps.ui.is_tag_click(ajax_url , _token ,'is_hot');
    ps.ui.is_tag_click(ajax_url , _token ,'is_on_sale');
    
}



/*
|-------------------------------------------------------------------------------
|
| 是否是新品
|
|-------------------------------------------------------------------------------
*/
ps.ui.is_tag_click  = function(ajax_url , _token , tag){

     $(document).on('click','span.'+ tag ,function(){

        var goods_id = $(this).data('goods_id');

        ps.ui.is_show_ajax(ajax_url , _token , goods_id , tag );
    })
}


/*
|-------------------------------------------------------------------------------
|
| 最终执行的ajax
|
|-------------------------------------------------------------------------------
*/
ps.ui.is_show_ajax  = function(ajax_url , _token , goods_id , tag){


     var  info              = {};

          info._token       = _token;
          info.goods_id     = goods_id;
          info.tag          = tag;

          $.ajax({

              'url':ajax_url,
              'type':'POST',
              'data':'info='+$.toJSON(info),
              'dataType':'json',
               success: function(data){

                  var str       = data.str;
                  var tag       = data.tag;
                  var goods_id  = parseInt(data.goods_id);

                  var span_tag  = $('span.' +tag);

                  $.each(span_tag , function(i,item){

                        var item_goods_id = $(item).data('goods_id');

                            item_goods_id = parseInt(item_goods_id);

                            if(goods_id == item_goods_id){

                                $(item).html(str);
                            }

                  })


              }

          })

    
}


/*
|-------------------------------------------------------------------------------
|
|  生成搜索数组 like搜索
|
|-------------------------------------------------------------------------------
*/
ps.ui.keywords = function(){

    var  keywords       = {};

    var order_sn        = $('#order_sn').val();
    var consignee       = $('#consignee').val();

    keywords.order_sn   = order_sn;
    keywords.consignee  = consignee;

    return keywords;

}

/*
|-------------------------------------------------------------------------------
|
|  生成等于搜索 fieldRow 
|
|-------------------------------------------------------------------------------
*/
ps.ui.fieldRow = function(){

    var fieldRow            = {};
    var code                = $('#code').val();
    code                    = parseInt(code);

    if(code >= 0 && code <=4){

        fieldRow.order_status   = code;
    }

    if(code == 5){

        fieldRow.pay_status     = 1;
    }

    if(code == 6){

        fieldRow.pay_status     = 0;
    }

    return fieldRow;
}



/*
|-------------------------------------------------------------------------------
|
|  添加订单 选择用户
|
|-------------------------------------------------------------------------------
*/
ps.ui.user_select = function(){


    $(document).on('change','input[type="radio"]',function(){

        if($(this).val() == 0){

            $('#content-div').hide();
        }

        if($(this).val() == 1){

            $('#content-div').show();
        }

    })
}



/*
|-------------------------------------------------------------------------------
|
|  用户ajax搜索
|
|-------------------------------------------------------------------------------
*/
ps.ui.user_search = function(ajax_url , _token){

    $(document).on('click','span.s-btn',function(){


            var     username            = $('#username').val();
            var     info                = {};
                    info.username       = username;
                    info._token         = _token;

            $.ajax({

                'url':ajax_url,
                'type':'POST',
                'data':'info=' + $.toJSON(info),
                'dataType':'json',
                success:function(data){


                    var tag         = parseInt(data.tag);
                    var user_id     = data.user_id;
                    var user_name   = data.user_name;

                    if(tag == 1){

                        var str     = '<option value="'+ user_id + '" selected="selected" >' + user_name + '</option>';

                        $('#user_id').html(str);

                    }


                }
            })

    })


}


/*
|-------------------------------------------------------------------------------
|
|  商品ajax搜索
|
|-------------------------------------------------------------------------------
*/
ps.ui.goods_search = function(ajax_url , _token){

     $(document).on('click','#goods-search-btn',function(){

            var  info               = {};
            var  goods_name         = $('#goods_name').val();
                 info.goods_name    = goods_name;

                 if(!goods_name){

                    alert('请输入关键词！');
                 }

            $.ajax({

                'url':ajax_url,
                'type':'POST',
                'data':'info=' + $.toJSON(info) +'&_token=' + _token,
                'dataType':'json',
                success:function(data){

                    var option_list     = ps.ui.option_list(data.row);

                    $('#goods_id').html(option_list);

                    //用第一条记录的json刷新展开的商品信息
                    ps.ui.goods_show(data.row);
                }

            });

     })
}


/*
|-------------------------------------------------------------------------------
|
|  生成商品下拉列表
|
|-------------------------------------------------------------------------------
*/
ps.ui.option_list    = function(row){


    if(!row){

        return '';
    }

    var str  = '';

    $.each(row , function(i,item){

        str += '<option value="'+item.goods_id + '">' + item.goods_name + '</option>';
    })


    return str;
}


/*
|-------------------------------------------------------------------------------
|
|  用返回的json商品列表第一条记录刷新展开的商品信息
|
|-------------------------------------------------------------------------------
*/
ps.ui.goods_show  = function(row){

    if(row){

        var goods               = row[0];

        var goods_name_str      = goods.goods_name + '<input type="hidden" value="'+ goods.goods_id +'" name="goods_id">';

        $('#json-goods_name').html(goods_name_str);
        $('#json-goods_sn').html(goods.goods_sn);
        $('#json-cat_id').html(goods.cat_name);
        $('#json-brand_id').html(goods.brand_name);
        $('#json-shop_price').html(goods.shop_price);
        $('#json-goods_attr').html(goods.goods_attr);

    }


}


/*
|-------------------------------------------------------------------------------
|
|  点击下拉选项 激活ajax 用json数据刷新展开的商品的部分
|
|-------------------------------------------------------------------------------
*/
ps.ui.goods_select = function(ajax_url , order_id , _token){


        $(document).on('change','#goods_id',function(){

                var goods_id        = $('#goods_id').val();

                $.ajax({

                    'url':ajax_url,
                    'type':'POST',
                    'data':'goods_id='+ goods_id + '&order_id='+ order_id  +'&_token=' + _token,
                    'dataType':'json',
                    success:function(data){

                        var goods                 = data.row;
                        var goods_name_str        = goods.goods_name + '<input type="hidden" value="'+ goods.goods_id +'" name="goods_id">';

                        $('#json-goods_name').html(goods_name_str);
                        $('#json-goods_sn').html(goods.goods_sn);
                        $('#json-cat_id').html(goods.cat_name);
                        $('#json-brand_id').html(goods.brand_name);
                        $('#json-shop_price').html(goods.shop_price);
                        $('#json-goods_attr').html(goods.goods_attr);


                    }

                });

        })

}



/*
|-------------------------------------------------------------------------------
|
|  省会-城市-地区 三级联查 ajax
|
|-------------------------------------------------------------------------------
*/
ps.ui.province_city_district_ajax = function(ajax_url , _token){


      $(document).on('change','#province',function(){


             var    region_id       = $(this).val();
             var    next_id         = 'city';
             var    region_type     = 2;

             //激活ajax操作
             ps.ui.pcd_ajax(ajax_url , _token ,region_id ,next_id, region_type);

      });


      $(document).on('change','#city',function(){


             var    region_id       = $(this).val();
             var    next_id         = 'district';
             var    region_type     = 3;

             //激活ajax操作
             ps.ui.pcd_ajax(ajax_url , _token ,region_id ,next_id, region_type);

      })
}


/*
|-------------------------------------------------------------------------------
|
|  省会-城市-地区 三级联查 ajax
|
|-------------------------------------------------------------------------------
*/
ps.ui.pcd_ajax = function(ajax_url , _token , region_id , next_id,region_type){


    var info                    = {};

    info.region_id              = region_id;
    info.next_id                = next_id;
    info._token                 = _token;
    info.region_type            = region_type;


      $.ajax({

        'url':ajax_url,
        'type':'POST',
        'data':'info='+ $.toJSON(info),
        'dataType':'json',
        success:function(data){

            var  next_id            = data.next_id;
            var  region_list        = data.region_list;

            var  str                = '<option value="0">请选择</option>';

            if(region_list){


                $.each(region_list ,function(i,item){


                     str += '<option value="'+ item.region_id +'">' + item.region_name  + '</option>';
                });
            }

            $('#'+next_id).html(str);



        }

      })
}


/*
|-------------------------------------------------------------------------------
|
|  主动订单选择器
|
|-------------------------------------------------------------------------------
*/
ps.ui.from_to_select  = function(){

    $(document).on('change','#to_order_sn_select',function(){

          var order_sn      = $(this).val();

           $('#to_order_sn').val(order_sn);

    });

    $(document).on('change','#from_order_sn_select',function(){

          var order_sn      = $(this).val();

           $('#from_order_sn').val(order_sn);

    })


}






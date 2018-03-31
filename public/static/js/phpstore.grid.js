
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
ps.ui.grid  = function(ajax_url,_token,searchInfo){

    //点击th切换排序
    ps.ui.sort(ajax_url , _token,searchInfo);

    //per_page选择 选择每页个数 激活ajax刷新
    ps.ui.page_select(ajax_url,_token,searchInfo);

    //点击分页 激活ajax操作 并刷新表单数据
    ps.ui.page_click(ajax_url , _token,searchInfo);

    //输入关键字 进行关键字搜索
    ps.ui.search(ajax_url , _token,searchInfo);

}


/*
|-------------------------------------------------------------------------------
|
| 点击th项目 执行ajax排序 并通过返回的json数据 刷新新的table和分页信息
|
|-------------------------------------------------------------------------------
*/
ps.ui.sort = function(ajax_url , _token,searchInfo){

    $(document).on('click','span.ajax-sort',function(){

        var sort_name      = $(this).parent('th.tit').data('sort_name');
        var sort_value     = $(this).parent('th.tit').data('sort_value');
        var per_page       = $('#per_page').val();
        var keywords       = ps.ui.keywords(searchInfo);
        var page           = 1;

        //新添加的几个搜索参数
        var fieldRow       = ps.ui.fieldRow(searchInfo);

        //获取whereIn搜索字段
        var whereIn        = ps.ui.whereIn(searchInfo);

        //如果page不存在 默认设置为1

        if($('ul.pagination li.active span').length > 0){

            page            = $('ul.pagination li.active span').html();

        }


        //激活ajax操作 并刷新页面
        ps.ui.ajax(ajax_url , sort_name , sort_value , _token , page , per_page , fieldRow , keywords,whereIn);


    });


}


/*
|-------------------------------------------------------------------------------
|
| 选择分页大小 并返回json数据 刷新table数据和分页信息
|
|-------------------------------------------------------------------------------
*/

ps.ui.page_select = function(ajax_url , _token,searchInfo){

    $(document).on('change','#per_page',function(){

        var sort_name           = $('table.ajax-sort-tab th.active').data('sort_name');
        var sort_value_var      = $('table.ajax-sort-tab th.active').data('sort_value');
        var page                = 1;
        var per_page            = $('#per_page').val();
        var keywords            = ps.ui.keywords(searchInfo);
        var fieldRow            = ps.ui.fieldRow(searchInfo);
        //获取whereIn搜索字段
        var whereIn             = ps.ui.whereIn(searchInfo);



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
        ps.ui.ajax(ajax_url , sort_name , sort_value , _token , page , per_page , fieldRow , keywords,whereIn);


    });
}



/*
|-------------------------------------------------------------------------------
|
| 点击分页的链接 激活ajax操作 并刷新表格数据和分页数据信息
|
|-------------------------------------------------------------------------------
*/
ps.ui.page_click = function(ajax_url , _token,searchInfo){

    //ajax的分页效果

    $(document).on('click','ul.pagination li a.ajax-a', function (){


                var sort_name           = $('table.ajax-sort-tab th.active').data('sort_name');
                var sort_value_var      = $('table.ajax-sort-tab th.active').data('sort_value');
                var page                = $(this).data('page');
                var per_page            = $('#per_page').val();
                var keywords            = ps.ui.keywords(searchInfo);
                var fieldRow            = ps.ui.fieldRow(searchInfo);
                //获取whereIn搜索字段
                var whereIn             = ps.ui.whereIn(searchInfo);

                if(sort_value_var  == 'desc'){

                    sort_value = 'asc';
                }

                if(sort_value_var == 'asc'){

                    sort_value = 'desc';
                }

            //ajax搜索 并返回json数据 刷新table数据和分页信息
           ps.ui.ajax(ajax_url , sort_name , sort_value , _token , page , per_page , fieldRow , keywords,whereIn);


    }); 

}



/*
|-------------------------------------------------------------------------------
|
| 关键字ajax搜索
|
|-------------------------------------------------------------------------------
*/
ps.ui.search = function(ajax_url , _token,searchInfo){

    //ajax递交表单
    $(document).on('click','#search-btn',function(){





        var sort_name           = $('table.ajax-sort-tab th.active').data('sort_name');
        var sort_value_var      = $('table.ajax-sort-tab th.active').data('sort_value');
        var page                = 1;
        var per_page            = $('#per_page').val();
        var sort_value          = '';
        var keywords            = ps.ui.keywords(searchInfo);
        var fieldRow            = ps.ui.fieldRow(searchInfo);
        //获取whereIn搜索字段
        var whereIn             = ps.ui.whereIn(searchInfo);



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
        ps.ui.ajax(ajax_url , sort_name , sort_value , _token , page , per_page , fieldRow , keywords,whereIn);


    });
}



/*
|-------------------------------------------------------------------------------
|
|  给返回的json数据 重新排序和加样式 同时加上 portlet box的样式
|
|-------------------------------------------------------------------------------
*/
ps.ui.portlet  = function(tab){


        var str      = '<div class="panel panel-primary box blue">'
                     + '<div class="panel-heading">'
                     + '<div class="caption">'
                     + '<i class="fa fa-cogs"></i>'
                     + '<span>列表</span>'
                     + '</div>'

                     + '</div>'
                     + '<div class="panel-body">'
                     + '<div class="table-scrollable table-responsive">'
                     + tab
                     + '</div>'
                     + '</div>'
                     + '</div>';
        return str;
}




/*
|-------------------------------------------------------------------------------
|
|  根据返回的json数据 生成全新的数组
|
|-------------------------------------------------------------------------------
*/

ps.ui.create = function(data){

    var str = '<table  class="table table-striped table-bordered table-hover ajax-sort-tab">';

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


    //用portlet box包装好
    str  = ps.ui.portlet(str);
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

    var str             = '<tr>';
    var col             = data.col;
    var sort_name       = data.sort_name;
    var sort_value      = data.sort_value;


    str += '<th scope="col" class="tit" style="width:50px;"> <input class="icheck mycheckbox" type="checkbox" name="select_all" /></th>';

    $.each(col , function(i,item){




        if(item.col_name == sort_name){

            if(sort_value == 'desc'){


                str += '<th scope="col" class="tit active" data-sort_name="'+item.col_name +  '" data-sort_value="asc" style="width:' + item.width + '">';

                str  += '<span class="ajax-sort">'+ item.col_value +'</span>'
                     +  '<i class="fa fa-sort-desc" style="padding:0 5px;"></i>'
                     +  '</th>';

            }
            else{

                str += '<th scope="col" class="tit active" data-sort_name="'+item.col_name +  '" data-sort_value="desc" style="width:' + item.width + '">';

                str  += '<span class="ajax-sort">'+ item.col_value +'</span>'
                     +  '<i class="fa fa-sort-asc" style="padding:0 5px;"></i>'
                     +  '</th>';


            }
        }

        else{

                str += '<th scope="col" class="tit" data-sort_name="'+item.col_name +  '" data-sort_value="desc" style="width:' + item.width +  '">';

                str  += '<span class="ajax-sort">'+ item.col_value +'</span>'
                     +  '</th>';

        }

    });

    str += '<th scope="col" class="tit" style="width:250px;">相关操作</th>'
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
        str += '<td style="text-align:center;vertical-align:middle;">'
             + '<input class="icheck mycheckbox checkbox-item" type="checkbox" name="ids[]" value="'
             + item[col[0].col_name]
             + '" /></td>';
        $.each(col, function(j,item2){

            str +='<td>' + item[item2.alias_name] + '</td>';

        });

        var edit_url        = item['edit_url'];
        var del_url         = item['del_url'];
        var preview_url     = item['preview_url'];

        str += '<td style="text-align:center;vertical-align:middle;width:250px;">'
               + edit_url + '&nbsp;&nbsp;' +  del_url + '&nbsp;&nbsp;' + preview_url + '</td>';


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
ps.ui.ajax = function(ajax_url , sort_name , sort_value , _token , page , per_page ,fieldRow , keywords,whereIn){

    var info = {};

    info.ajax_url           = ajax_url;
    info.sort_name          = sort_name;
    info.sort_value         = sort_value;
    info._token             = _token;
    info.page               = page;
    info.per_page           = per_page;
    info.fieldRow           = fieldRow;
    info.keywords           = keywords;
    info.whereIn            = whereIn;

    //ajax搜索 并返回json数据 刷新table数据和分页信息
            $.ajax({

                'url':ajax_url,
                'type':'POST',
                'data':'info=' + $.toJSON(info) + '&_token=' + _token,
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
                    ps.icheckbox();
                    ps.confirm();

                 }


            });
}












/*
|-------------------------------------------------------------------------------
|
|  生成搜索数组 like搜索
|
|-------------------------------------------------------------------------------
*/
ps.ui.keywords = function(searchInfo){

    var  keywords       = {};

    var  data = $.parseJSON(searchInfo);


        var  row    = data.keywords;



        if(row){

            $.each(row , function(i,item){

                keywords[item.field]     = $('#'+item.field).val();
            })
        }


    return keywords;

}

/*
|-------------------------------------------------------------------------------
|
|  生成等于搜索 fieldRow
|
|-------------------------------------------------------------------------------
*/
ps.ui.fieldRow = function(searchInfo){

    var  fieldRow            = {};
    var  data                = $.parseJSON(searchInfo);
    var row                  = data.fieldRow;

    //如果设置了等于搜索字段
    if(row){

        $.each(row, function(i,item){

            var value              = $('#'+item.field).val();
                value              = parseInt(value);
                if(value != 99999){

                    fieldRow[item.field]    = value;
                 }


        });
    }

    return fieldRow;
}


/*
|-------------------------------------------------------------------------------
|
|  生成whereIn搜索的字段
|
|-------------------------------------------------------------------------------
*/
ps.ui.whereIn  = function(searchInfo){

     var whereIn    = {};
     var data       = $.parseJSON(searchInfo);
     var row        = data.whereIn;

     if(row){

        whereIn.in_field    = row.field;
        whereIn.in_value    = $('#' + row.field).val();
     }

     return whereIn;
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

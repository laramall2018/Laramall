/*
|-------------------------------------------------------------------------------
|
| 商品分类页 ajax筛选 排序 分页相关js
|
| +++  价格区间的筛选     ++++
| +++  商品属性的筛选     ++++
| +++  商品品牌的筛选     ++++
| +++  排序条件的筛选     ++++
| +++  分页的条件筛选     ++++
|
|-------------------------------------------------------------------------------
*/

var cat    			= {};



/*
|-------------------------------------------------------------------------------
|
| 商品分类页激活ajax操作
|
|-------------------------------------------------------------------------------
*/
cat.select        = function(ajax_url,cat_id){


      //点击价格区间 激活价格ajax筛选
      cat.price(ajax_url,cat_id);
      //点击品牌 激活品牌ajax筛选
      cat.brand(ajax_url,cat_id);

      //点击属性 激活属性筛选
      cat.attr(ajax_url,cat_id);

      //点击排序 激活排序ajax筛选
      cat.sort(ajax_url,cat_id);

      //点击分页 激活分页ajax操作
      cat.page(ajax_url,cat_id);

}


/*
|-------------------------------------------------------------------------------
|
| 价格区间 ajax操作
|
|-------------------------------------------------------------------------------
*/
cat.price    = function(ajax_url,cat_id){

    $(document).on('click','.row .price-btn',function(){

           var  min     = $(this).data('min');
           var  max     = $(this).data('max');

           $(this).removeClass('grey').addClass('blue selected').siblings('.price-btn').removeClass('blue selected').addClass('grey');

           //获取ajax传递的参数
           var  info    = cat.info(cat_id);

           //激活ajax操作
           cat.ajax(ajax_url,info);

    })
}

/*
|-------------------------------------------------------------------------------
|
| 品牌筛选
|
|-------------------------------------------------------------------------------
*/
cat.brand   = function(ajax_url,cat_id){

   $(document).on('click','.row .brand-btn',function(){

          $(this).removeClass('grey').addClass('blue selected').siblings('.brand-btn').removeClass('blue selected').addClass('grey');

          var  brand_id    = $(this).data('brand_id');
          var  info        = cat.info(cat_id);

          //激活ajax
          cat.ajax(ajax_url,info);

   })
}


/*
|-------------------------------------------------------------------------------
|
| 属性筛选
|
|-------------------------------------------------------------------------------
*/
cat.attr    = function(ajax_url,cat_id){

   $(document).on('click','.row .attr-btn',function(){


         $(this).parent('p').find('.attr-btn').removeClass('blue selected').addClass('grey');
         $(this).removeClass('grey').addClass('blue selected');

         var info       = cat.info(cat_id);
         //激活ajax操作
         cat.ajax(ajax_url,info);
   })
}


/*
|-------------------------------------------------------------------------------
|
| 排序筛选
|
|-------------------------------------------------------------------------------
*/
cat.sort   = function(ajax_url,cat_id){

    $(document).on('click','.row .sort-btn',function(){

          $(this).addClass('blue selected').removeClass('grey').siblings('.sort-btn').removeClass('blue selected').addClass('grey');

          var  sort_name      = $(this).data('sort_name');
          var  sort_value     = $(this).data('sort_value');


          if(sort_value == 'desc'){

               $(this).find('i.material-icons').html('<i class="material-icons left">arrow_upward</i>');
               $(this).data('sort_value','asc');
          }
          else{

               $(this).find('i.material-icons').html('<i class="material-icons left">arrow_downward</i>');
               $(this).data('sort_value','desc');
          }

          var  info     = cat.info(cat_id);

          //激活ajax
          cat.ajax(ajax_url,info);


    })
}

/*
|-------------------------------------------------------------------------------
|
| 点击分页 生成新的商品列表
|
|-------------------------------------------------------------------------------
*/
cat.page    = function(ajax_url,cat_id){

    //ajax的分页效果

    $(document).on('click','ul.pagination li a.ajax-a', function (){


             var  current_page        = $(this).data('page');
             var  info                = cat.info(cat_id);

                  info.current_page   = current_page;

             //激活ajax操作
             cat.ajax(ajax_url,info);

    });
}


/*
|-------------------------------------------------------------------------------
|
| 获取参数
|
|-------------------------------------------------------------------------------
*/
cat.info      = function(cat_id){

    var  info               = {};
         info.cat_id        = cat_id;

    var  price_item         = $('.row .price-btn');
    var  min                = 0;
    var  max                = 0;

    $.each(price_item , function(i,item){

         if($(item).hasClass('selected')){

             min            = parseInt($(item).data('min'));
             max            = parseInt($(item).data('max'));
         }
    });

    //设置当前页
    var  current_page       = 1;
    //如果有当前页
    if($('ul.pagination li.active span').length > 0){

         current_page       = $('ul.pagination li.active span').html();
    }
         current_page       = parseInt(current_page);

         info.min           = min;
         info.max           = max;
         info.current_page  = current_page;

    //获取品牌编号

    var brand_item          = $('.row .brand-btn');
    var brand_id            = 0;

    $.each(brand_item,function(i,item){

        if($(item).hasClass('selected')){

          brand_id          = $(item).data('brand_id');
        }
    })


    //获取属性筛选
    var attr_item           =$('.row .attr-btn');
    var attr                = new Array();

    $.each(attr_item,function(i,item){

         if($(item).hasClass('selected')){
              var goods_attr_id   = $(item).data('goods_attr_id');
                  goods_attr_id   = parseInt(goods_attr_id);

                  if(goods_attr_id > 0)
                  {
                    attr.push(goods_attr_id);
                  }
         }
    })

    //获取排序的参数
    var  sort_item          = $('.row .sort-btn');
    var  sort_name          = 'g.id';
    var  sort_value         = 'asc';

    $.each(sort_item ,function(i,item){

          if($(item).hasClass('selected')){

                sort_name   = $(item).data('sort_name');
                sort_value  = $(item).data('sort_value');
          }
    })

         info.brand_id      = brand_id;
         info.attr          = attr;
         info.sort_name     = sort_name;
         info.sort_value    = sort_value;
         return info;


}


/*
|-------------------------------------------------------------------------------
|
| 激活ajax操作
|
|-------------------------------------------------------------------------------
*/
cat.ajax      = function(ajax_url,info){

     $.ajax({

        'url':ajax_url,
        'type':'POST',
        'data':'info='+$.toJSON(info),
        'dataType':'json',
         success:function(data){

            var  goods_list   = data.goods_list_mobile;
            var  links        = data.links;

            $('#ajax-goods-list').html(goods_list);
            $('#page-ajax-btn').html(links);
        }

     })
}



/*
|-------------------------------------------------------------------------------
|
| 相册页面切换相册
|
|-------------------------------------------------------------------------------
*/
cat.thumb     = function(){

    $(document).on('click','.thumb-list img',function(){


        $(this).addClass('thumb-curr').siblings('img').removeClass('thumb-curr');

        var img_url       = $(this).attr('src');

        $(this).parent('.thumb-list').parent('.item-bb').find('.pic a img.goods-thumb').attr('src',img_url);

    })
}

/*
|-------------------------------------------------------------------------------
|   phpstore商城系统后 后台添加属性货品的ajax文件
|   网址：www.phpstore.cn
|   技术支持QQ：179536444
|-------------------------------------------------------------------------------
*/

product   = {};


/*
|-------------------------------------------------------------------------------
|   激活ajax操作 选择商品下拉框
|-------------------------------------------------------------------------------
*/
product.select  = function(ajax_url){


    $(document).on('change','#goods_id',function(){

           var  goods_id    = $(this).val();

           $.ajax({

              'type':'POST',
              'url' :ajax_url,
              'data':'goods_id=' + goods_id,
              'dataType':'json',
              success:function(data){

                  if(data.str){
                    $('#goods_attr').html(data.str);
                    ps.icheckbox();
                  }
              }

           })
    })

}

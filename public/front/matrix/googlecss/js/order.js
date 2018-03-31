var  order = {};
var  ps    = {};

//选择不同版本切换价格

order.price  = function(){
    
    $(document).on('change','#ecsvip_ver',function(){
        
        var ecsvip_ver  = $(this).val();
        var price       = 20000;
        
        if(ecsvip_ver == 'wap版'){
            
            price       = 10000;
        }
        
        if(ecsvip_ver == 'b2c一站式解决方案'){
            
            price       = 30000;
        }
        
        $('#price').val(price);
        
    })
}


/*
|-------------------------------------------------------------------------------
|
| 菜单的当前页
|
|-------------------------------------------------------------------------------
*/
ps.menu  = function(url){

    var li_item  = $('#left-menu ul li');

    $.each(li_item, function (i,item) {
  
      if($(item).find('a').attr('href') == url){

          $(item).addClass('blue');
          $(item).find('a').addClass('white-text bold');
      }

  });

}
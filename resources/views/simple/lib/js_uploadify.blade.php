<script type="text/javascript">
<?php $timestamp = time();?>
$(function() {
            $('#file_upload').uploadify({
                'method'   : 'post',
                'buttonText' : '批量上传图片',
                'formData'     : {
                    'timestamp' : '<?php echo $timestamp;?>',
                    'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
                    '_token'    :"{!!csrf_token()!!}"
                },
                'swf'      : "{!!$swf_url!!}",
                'uploader' : "{!!$uploadify_url!!}",
                
                'onUploadSuccess' : function(file, data, response) {
                    //alert('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);
					  var row 	= jQuery.parseJSON(data);
					
					


                    
                    var str = '<div class="img-item">'
                             +'<input type="hidden" name="source_imgs[]" value="'+row.upload_img+'">'
                             +'<input type="hidden" name="goods_thumbs[]" value="'+row.goods_thumb+'">'
                             +'<input type="hidden" name="goods_imgs[]" value="'+row.goods_img+'">'
                             + '{!!HTML::image("' + row.upload_img + '")!!}'
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
                    alert('The file ' + file.name + ' could not be uploaded: ' + errorCode);
                } 
                
            });
            
            //删除动态生成的图片
            $(document).on('click','span.img-del',function(){
                
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
                    'type':'POST',
                    'url':"{!!$uploadify_del_url!!}",
                    'data':'goods='+$.toJSON(goods) + '&_token=' + '{!!csrf_token()!!}',
                    'dataType':'json',
                    success: function(data){
                        
                        if(data.info == 'ok'){
                            
                            $(that).parent('.img-item').remove();
                        }
                    }
                    
                });
                
                
            });
        });
</script>

<script type="text/javascript">

  $(function(){
	 
	 ps.add_goods_attr('{!!$attr_list!!}');
	 ps.del_goods_attr();
	 ps.goods_tab();
  });

</script>
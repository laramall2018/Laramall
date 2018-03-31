<script type="text/javascript" src="{!!url('files/bootstrap-filestyle.min.js')!!}"></script>
<div class="ps-tab-content-item">
	<div class="alert alert-info" role="alert">上传图片系统会自动生成三组图片尺寸</div>
    
     @if($goods_gallery)
    <div class="goods-img-list">
    	@foreach($goods_gallery as $item)
         <div class="img-item">
         	<img src="{{$item->thumb()}}" class="img-thumbnail" />
            <span class="del-img-btn-ajax btn btn-danger" data-id="{!!$item->id!!}"><i class="fa fa-times"></i>删除</span>
         </div>
         
        @endforeach
    </div><!--/goods-img-list-->
    @endif
    
    <div class="form-group">
    	
        <div class="col-md-4">
        	
            <span class="btn btn-success add-goods-img-btn">
            	<i class="fa fa-plus"></i>添加图片
            </span>
        </div>
    </div><!--/form-group-->
    
    <div class="upload-img-div">
    	
        	
        
    </div><!--/form-div-->
    
    
</div><!--/ps-tab-content-item-->
<script type="text/javascript">
$(function(){
	ps.create_upload_img_form();
	$(":file").filestyle({buttonText: "上传图片"});
	
	//ajax删除商品图片信息
	ps.gallery.delete("{!!url('admin/goods/gallery/delete')!!}","{!!csrf_token()!!}");

});
</script>
<script type="text/javascript" src="{!!url('files/bootstrap-filestyle.min.js')!!}"></script>
<div class="ps-tab-content-item">
	<div class="alert alert-info" role="alert">上传图片系统会自动生成三组图片尺寸</div>
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

});
</script>
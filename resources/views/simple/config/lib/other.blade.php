
<div class="ps-tab-content-item">
	
    <div class="form-group">
    	<label class="col-md-3 control-label">后台路径</label>
        <div class="col-md-4">
        	<input type="text" name="admin_url" id="admin_url" value="{!!$row['admin_url']!!}"  class="form-control" />
        </div>
    </div><!--/form-group-->
    
     <div class="form-group">
    	<label class="col-md-3 control-label">开启wap</label>
        <div class="col-md-4">
        	<input type="radio" class="mycheckbox" name="wap_opened" value="0" checked="checked" />不开启
            <input type="radio" class="mycheckbox" name="wap_opened" value="1" />开启
        </div>
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-3 control-label">wap站点logo</label>
        <div class="col-md-4">
        	<input type="file" name="wap_logo" id="wap_logo" />
        </div>
    </div><!--/form-group-->
    @if($row['wap_logo'])
    <div class="form-group">
    	<div class="col-md-offset-3 col-md-2">
        	<img src="{!!url($row['wap_logo'])!!}" class="img-thumbnail" />
        </div>
    </div>
    @endif
    
   
    
      
</div><!--/ps-tab-content-item -->
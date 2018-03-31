
<div class="ps-tab-content-item">
	
    <div class="form-group">
    	<label class="col-md-3 control-label">语言包</label>
        <div class="col-md-4">
        	<select name="lang" class="form-control">
            	<option value="">请选择</option>
            	<option value="cn" @if($row['lang'] =='cn') selected="selected" @endif >中文</option>
                <option value="en" @if($row['lang'] =='en') selected="selected" @endif>英文</option>
            </select>
        </div>
    </div><!--/form-group-->
    
     <div class="form-group">
    	<label class="col-md-3 control-label">备案号</label>
        <div class="col-md-4">
        	<input type="text" name="icp" id="icp" class="form-control" value="{!!$row['icp']!!}" />
        </div><!--/col-md-4-->
     </div><!--/form-group -->
     
     <div class="form-group">
    	<label class="col-md-3 control-label">水印文件</label>
        <div class="col-md-4">
        	<input type="file" name="watermark" id="watermark" />
        </div>
    </div><!--/form-group-->
    
    @if($row['watermark'])
    <div class="form-group">
    	<div class="col-md-offset-3 col-md-2">
        	<img src="{!!url($row['watermark'])!!}" class="img-thumbnail" />
        </div>
    </div>
    @endif

    
    <div class="form-group">
    	<label class="col-md-3 control-label">市场价格比例</label>
        <div class="col-md-4">
        	<input type="text" name="market_price_rate" id="market_price_rate" class="form-control" value="{!!$row['market_price_rate']!!}" />
        </div><!--/col-md-4-->
     </div><!--/form-group -->
     
     <div class="form-group">
    	<label class="col-md-3 control-label">网站统计代码</label>
        <div class="col-md-4">
    		<textarea class="form-control" name="stats_code" id="stats_code" rows="5">{!!$row['stats_code']!!}</textarea>
        </div><!--/col-md-4-->
    </div>
    
    <div class="form-group">
    	<label class="col-md-3 control-label">商品默认图片</label>
        <div class="col-md-4">
        	<input type="file" name="goods_default_img" id="goods_default_img" />
        </div>
    </div><!--/form-group-->
    @if($row['goods_default_img'])
    <div class="form-group">
    	<div class="col-md-offset-3 col-md-2">
        	<img src="{!!url($row['goods_default_img'])!!}" class="img-thumbnail" />
        </div>
    </div>
    @endif
    
    <div class="form-group">
    	<label class="col-md-3 control-label">首页搜索关键词</label>
        <div class="col-md-4">
        	<input type="text" name="search_keywords" id="search_keywords" class="form-control" value="{!!$row['search_keywords']!!}" />
        </div>
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-3 control-label">缩略图宽度</label>
        <div class="col-md-4">
        	<input type="text" name="thumb_width" id="thumb_width" class="form-control" value="{!!$row['thumb_width']!!}" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">缩略图高度</label>
        <div class="col-md-4">
        	<input type="text" name="thumb_height" id="thumb_height" class="form-control" value="{!!$row['thumb_height']!!}" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">详情页图片宽度</label>
        <div class="col-md-4">
        	<input type="text" name="img_width" id="img_width" class="form-control" value="{!!$row['img_width']!!}" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">详情页图片高度</label>
        <div class="col-md-4">
        	<input type="text" name="img_height" id="img_height" class="form-control" value="{!!$row['img_height']!!}" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">列表页商品个数</label>
        <div class="col-md-4">
        	<input type="text" name="list_page_size" id="list_page_size" class="form-control" value="{!!$row['list_page_size']!!}" />
        </div>
    </div><!--/form-group-->
    
   
    
      
</div><!--/ps-tab-content-item -->
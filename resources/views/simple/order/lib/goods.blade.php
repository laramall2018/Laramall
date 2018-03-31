
<div class="ps-tab-content-item">
	
    
    <div class="alert alert-info"><span>先通过分类，品牌或者关键词搜索出商品列表 然后和当前商品关联。关联产品不宜超过20个</span></div>
    <div class="form-group">
    	<label class="col-md-1 control-label">商品分类</label>
        <div class="col-md-4">
        	<select name="search_cat_id" class="form-control" id="search_cat_id">
                <option value="0">请选择</option>
				{!!$cat_option_list!!}        
            </select>
        </div><!--/col-md-4-->
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-1 control-label">商品品牌</label>
        <div class="col-md-4">
        	<select name="search_brand_id" class="form-control" id="search_brand_id">
                <option value="0">请选择</option>
				{!!$brand_option_list!!}        
            </select>
        </div><!--/col-md-4-->
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-1 control-label">关键词</label>
        <div class="col-md-4">
        	<input type="text" name="search_keywords" id="search_keywords" class="form-control" />
        </div><!--/col-md-4-->
    </div><!--/form-group-->
    <div class="form-group">
    	<div class="col-md-offset-1 col-md-4">
        	<span class="btn btn-success search-btn" id="search-goods-btn">搜索</span>
        </div>
    </div>
    
    <div id="search-goods-list">
    
    </div><!--/search-goods-list-->
</div><!--/ps-tab-content-item-->
<script type="text/javascript">
	$(function(){
		
		ps.goods.search("{!!url('admin/goods/search')!!}","{!!csrf_token()!!}");
			
	});
</script>

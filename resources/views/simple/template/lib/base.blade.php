
<div class="ps-tab-content-item">
	
     <div class="form-group">
    	<label class="col-md-3 control-label">新品数量</label>
        <div class="col-md-4">
        	<input type="text" name="new_goods_number" id="new_goods_number" class="form-control" value="{!!$row['new_goods_number']!!}" />
        </div><!--/col-md-4-->
     </div><!--/form-group -->
     
     <div class="form-group">
    	<label class="col-md-3 control-label">热卖数量</label>
        <div class="col-md-4">
        	<input type="text" name="hot_goods_number" id="hot_goods_number" class="form-control" value="{!!$row['hot_goods_number']!!}" />
        </div><!--/col-md-4-->
     </div><!--/form-group -->
     
     <div class="form-group">
    	<label class="col-md-3 control-label">精品数量</label>
        <div class="col-md-4">
        	<input type="text" name="best_goods_number" id="best_goods_number" class="form-control" value="{!!$row['best_goods_number']!!}" />
        </div><!--/col-md-4-->
     </div><!--/form-group -->
     <div class="form-group">
    	<label class="col-md-3 control-label">促销商品数量</label>
        <div class="col-md-4">
        	<input type="text" name="promote_goods_number" id="promote_goods_number" class="form-control" value="{!!$row['promote_goods_number']!!}" />
        </div><!--/col-md-4-->
     </div><!--/form-group -->
     <div class="form-group">
    	<label class="col-md-3 control-label">分类下商品数量</label>
        <div class="col-md-4">
        	<input type="text" name="cat_goods_number" id="cat_goods_number" class="form-control" value="{!!$row['cat_goods_number']!!}" />
        </div><!--/col-md-4-->
     </div><!--/form-group -->
     
     <div class="form-group">
    	<label class="col-md-3 control-label">页脚文字描述</label>
        <div class="col-md-4">
        	<textarea name="footer_desc" rows="5" class="form-control">{!!$row['footer_desc']!!}</textarea>
        </div><!--/col-md-4-->
     </div><!--/form-group -->
    <div class="form-group">
        <div class="col-md-offset-3 col-md-9">
        <input type="submit" name="submit" class="btn btn-primary" value="确认添加" />                        
    </div>
</div><!--/form-group-->  
    
      
</div><!--/ps-tab-content-item --> 
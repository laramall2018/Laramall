
<div class="ps-tab-content-item">
	
    
    <div class="form-group">
    	<label class="col-md-3 control-label">商品重量</label>
        <div class="col-md-4">
        	<input type="text" name="goods_weight" class="form-control" id="goods_weight" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">报警库存</label>
        <div class="col-md-4">
        	<input type="text" name="warn_number" class="form-control" id="warn_number" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">新品</label>
        <div class="col-md-4">
        	<input type="radio" name="is_new" value="0" class="mycheckbox" checked="checked"  />不是
            <input type="radio" name="is_new" value="1" class="mycheckbox"  />是
        </div>
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-3 control-label">精品</label>
        <div class="col-md-4">
        	<input type="radio" name="is_best" value="0" class="mycheckbox" checked="checked"  />不是
            <input type="radio" name="is_best" value="1" class="mycheckbox"  />是
        </div>
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-3 control-label">热卖</label>
        <div class="col-md-4">
        	<input type="radio" name="is_hot" value="0" class="mycheckbox" checked="checked"  />不是
            <input type="radio" name="is_hot" value="1" class="mycheckbox"  />是
        </div>
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-3 control-label">关键词</label>
        <div class="col-md-4">
        	<textarea name="keywords" cols="20" rows="5" class="form-control"></textarea>
        </div>
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-3 control-label">简单描述</label>
        <div class="col-md-4">
        	<textarea name="goods_brief" cols="20" rows="5" class="form-control"></textarea>
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">商家备注</label>
        <div class="col-md-4">
        	<textarea name="seller_note" cols="20" rows="5" class="form-control"></textarea>
        </div>
    </div><!--/form-group-->
   <div class="form-group">
        <label class="col-md-3 control-label">排序</label>
        <div class="col-md-4">
            <input type="text" name="sort_order" class="form-control" id="sort_order" />
        </div>
    </div><!--/form-group-->
    
    
    
</div><!--/ps-tab-content-item-->
<script type="text/javascript">
	ps.icheckbox();
</script>
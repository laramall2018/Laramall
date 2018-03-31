
<div class="ps-tab-content-item">
	
    
    <div class="form-group">
    	<label class="col-md-3 control-label">商品重量</label>
        <div class="col-md-4">
        	<input type="text" name="goods_weight" class="form-control" id="goods_weight" value="{!!$model->goods_weight!!}" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">报警库存</label>
        <div class="col-md-4">
        	<input type="text" name="warn_number" class="form-control" id="warn_number" value="{!!$model->warn_number!!}" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">新品</label>
        <div class="col-md-4">  
        	<input type="radio" name="is_new" value="0" class="mycheckbox" @if($model->is_new == 0)  checked="checked" @endif  />不是
            <input type="radio" name="is_new" value="1" class="mycheckbox" @if($model->is_new == 1)  checked="checked" @endif  />是
        </div>
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-3 control-label">精品</label>
        <div class="col-md-4">
        	<input type="radio" name="is_best" value="0" class="mycheckbox" @if($model->is_best == 0)  checked="checked" @endif  />不是
            <input type="radio" name="is_best" value="1" class="mycheckbox" @if($model->is_best == 1)  checked="checked" @endif />是
        </div>
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-3 control-label">热卖</label>
        <div class="col-md-4">
        	<input type="radio" name="is_hot" value="0" class="mycheckbox" @if($model->is_hot == 0)  checked="checked" @endif  />不是
            <input type="radio" name="is_hot" value="1" class="mycheckbox" @if($model->is_hot == 1)  checked="checked" @endif />是
        </div>
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-3 control-label">关键词</label>
        <div class="col-md-4">
        	<textarea name="keywords" cols="20" rows="5" class="form-control">{!!$model->keywords!!}</textarea>
        </div>
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-3 control-label">简单描述</label>
        <div class="col-md-4">
        	<textarea name="goods_brief" cols="20" rows="5" class="form-control">{!!$model->goods_brief!!}</textarea>
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">商家备注</label>
        <div class="col-md-4">
        	<textarea name="seller_note" cols="20" rows="5" class="form-control">{!!$model->seller_note!!}</textarea>
        </div>
    </div><!--/form-group-->
   <div class="form-group">
        <label class="col-md-3 control-label">排序</label>
        <div class="col-md-4">
            <input type="text" name="sort_order" class="form-control" id="sort_order" value="{!!$model->sort_order!!}" />
        </div>
    </div><!--/form-group-->
    
    
    
</div><!--/ps-tab-content-item-->
<script type="text/javascript">
	ps.icheckbox();
</script>
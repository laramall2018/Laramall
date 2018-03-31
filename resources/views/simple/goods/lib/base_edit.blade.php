
<div class="ps-tab-content-item cur">
	
    <div class="form-group">
    	<label class="col-md-3 control-label">商品名称</label>
        <div class="col-md-4">
        	<input type="text" name="goods_name" class="form-control" id="goods_name" value="{!!$model->goods_name!!}" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">商品货号</label>
        <div class="col-md-4">
        	<input type="text" name="goods_sn" class="form-control" id="goods_sn" value="{!!$model->goods_sn!!}" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">商品库存</label>
        <div class="col-md-4">
        	<input type="text" name="goods_number" class="form-control" id="goods_number" value="{!!$model->goods_number!!}" />
        </div>
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-3 control-label">商品分类</label>
        <div class="col-md-4">
        	<select name="cat_id" class="form-control">
                <option value="{!!$model->cat_id!!}" selected="selected">{!!$model->category->cat_name!!}</option>
                {!!$cat_option_list!!}
            </select>
        </div>
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-3 control-label">商品品牌</label>
        <div class="col-md-4">
        	<select name="brand_id" class="form-control">
                @if($model->brand)
            	<option value="{!!$model->brand_id!!}" selected="selected">{!!$model->brand->brand_name!!}</option>
                @endif
                {!!$brand_option_list!!}
            </select>
        </div>
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-3 control-label">市场价格</label>
        <div class="col-md-4">
        	<input type="text" name="market_price" class="form-control" id="market_price" value="{!!$model->market_price!!}" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">销售价格</label>
        <div class="col-md-4">
        	<input type="text" name="shop_price" class="form-control" id="shop_price" value="{!!$model->shop_price!!}" />
        </div>
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-3 control-label">缩略图</label>
        <div class="col-md-4">
        	<input type="file" name="goods_thumb" id="goods_thumb" />
        </div>
    </div>
    @if($model->goods_thumb)
    <div class="form-group">
    
    	<div class="col-md-offset-3 col-md-4">
        	<img class="thumb" src="{!!url($model->goods_thumb)!!}" />
        </div><!--/col-md-4-->
    </div>
    @endif
    
    <div class="form-group">
    	<label class="col-md-3 control-label">促销价格</label>
        <div class="col-md-4">
        	<input type="text" name="promote_price" class="form-control" id="promote_price" value="{!!$model->promote_price!!}" />
        </div>
    </div><!--/form-group-->
    <div class="form-group" style="z-index:99999;">
    	<label class="col-md-3 control-label">促销开始日期</label>
        <div class="col-md-4">
        	<input type="text" name="promote_start_date" class="form-control" id="promote_start_date" 
            @if($model->promote_start_date > 0)
            value="<?php echo date('Y-m-d',$model->promote_start_date);?>" @endif/>
        </div>
    </div><!--/form-group-->
    <div class="form-group" style="z-index:9999;">
    	<label class="col-md-3 control-label">促销结束日期</label>
        <div class="col-md-4">
        	<input type="text" name="promote_end_date" class="form-control" id="promote_end_date"
            @if($model->promote_end_date > 0)
            value="<?php echo date('Y-m-d',$model->promote_end_date);?>" @endif />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">消费积分</label>
        <div class="col-md-4">
        	<input type="text" name="give_integral" class="form-control" id="give_integral" value="{!!$model->give_integral!!}" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">自定义链接</label>
        <div class="col-md-4">
        	<input type="text" name="diy_url" class="form-control" id="diy_url" value="{!!$model->diy_url!!}" />
        </div>
    </div><!--/form-group-->
    
</div><!--/ps-tab-content-item-->
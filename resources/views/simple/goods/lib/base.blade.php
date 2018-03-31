
<div class="ps-tab-content-item cur">
	
    <div class="form-group">
    	<label class="col-md-3 control-label">商品名称</label>
        <div class="col-md-4">
        	<input type="text" name="goods_name" class="form-control" id="goods_name" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">商品货号</label>
        <div class="col-md-4">
        	<input type="text" name="goods_sn" class="form-control" id="goods_sn" value="{{$goods_sn}}" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">商品库存</label>
        <div class="col-md-4">
        	<input type="text" name="goods_number" class="form-control" id="goods_number" />
        </div>
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-3 control-label">商品分类</label>
        <div class="col-md-4">
        	<select name="cat_id" class="form-control">
                {!!$cat_option_list!!}
            </select>
        </div>
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-3 control-label">商品品牌</label>
        <div class="col-md-4">
        	<select name="brand_id" class="form-control">
                {!!$brand_option_list!!}
            </select>
        </div>
    </div><!--/form-group-->
    
    <div class="form-group">
    	<label class="col-md-3 control-label">市场价格</label>
        <div class="col-md-4">
        	<input type="text" name="market_price" class="form-control" id="market_price" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">销售价格</label>
        <div class="col-md-4">
        	<input type="text" name="shop_price" class="form-control" id="shop_price" />
        </div>
    </div><!--/form-group-->
     <div class="form-group">
    	<label class="col-md-3 control-label">缩略图</label>
        <div class="col-md-4">
        	<input type="file" name="goods_thumb" id="goods_thumb" />
        </div>
    </div>
    <div class="form-group">
    	<label class="col-md-3 control-label">促销价格</label>
        <div class="col-md-4">
        	<input type="text" name="promote_price" class="form-control" id="promote_price" />
        </div>
    </div><!--/form-group-->
    <div class="form-group" style="z-index:99999;">
    	<label class="col-md-3 control-label">促销开始日期</label>
        <div class="col-md-4">
        	<input type="text" name="promote_start_date" class="form-control" id="promote_start_date" />
        </div>
    </div><!--/form-group-->
    <div class="form-group" style="z-index:9999;">
    	<label class="col-md-3 control-label">促销结束日期</label>
        <div class="col-md-4">
        	<input type="text" name="promote_end_date" class="form-control" id="promote_end_date" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">消费积分</label>
        <div class="col-md-4">
        	<input type="text" name="give_integral" class="form-control" id="give_integral" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">自定义链接</label>
        <div class="col-md-4">
        	<input type="text" name="diy_url" class="form-control" id="diy_url" />
        </div>
    </div><!--/form-group-->
   
    
    
    
</div><!--/ps-tab-content-item-->
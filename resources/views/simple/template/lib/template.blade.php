
<div class="ps-tab-content-item">
	
    <div class="form-group">
    	<label class="col-md-3 control-label">底部帮助中心</label>
        <div class="col-md-4">
        	<select name="help_1" class="form-control">
            	<option value="">请选择新闻分类</option>
            	@if($article_cat_id)
                @foreach($article_cat_id as $item)
                 <option value="{!!$item->id!!}" @if($row['help_1'] ==$item->id ) selected="selected" @endif >{!!$item->cat_name!!}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">底部帮助中心</label>
        <div class="col-md-4">
        	<select name="help_2" class="form-control">
            	<option value="">请选择新闻分类</option>
            	@if($article_cat_id)
                @foreach($article_cat_id as $item)
                 <option value="{!!$item->id!!}" @if($row['help_2'] ==$item->id ) selected="selected" @endif >{!!$item->cat_name!!}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">底部帮助中心</label>
        <div class="col-md-4">
        	<select name="help_3" class="form-control">
            	<option value="">请选择新闻分类</option>
            	@if($article_cat_id)
                @foreach($article_cat_id as $item)
                 <option value="{!!$item->id!!}" @if($row['help_3'] ==$item->id ) selected="selected" @endif >{!!$item->cat_name!!}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">底部帮助中心</label>
        <div class="col-md-4">
        	<select name="help_4" class="form-control">
            	<option value="">请选择新闻分类</option>
            	@if($article_cat_id)
                @foreach($article_cat_id as $item)
                 <option value="{!!$item->id!!}" @if($row['help_4'] ==$item->id ) selected="selected" @endif >{!!$item->cat_name!!}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">底部帮助中心</label>
        <div class="col-md-4">
        	<select name="help_5" class="form-control">
            	<option value="">请选择新闻分类</option>
            	@if($article_cat_id)
                @foreach($article_cat_id as $item)
                 <option value="{!!$item->id!!}" @if($row['help_5'] ==$item->id ) selected="selected" @endif >{!!$item->cat_name!!}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div><!--/form-group-->
      
</div><!--/ps-tab-content-item -->
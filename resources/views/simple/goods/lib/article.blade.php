
<div class="ps-tab-content-item">
	
    
    <div class="alert alert-info"><span>先通过分类，或者关键词搜索出新闻列表 然后和当前商品关联。关联新闻不宜超过20个</span></div>
    <div class="form-group">
    	<label class="col-md-1 control-label">新闻分类</label>
        <div class="col-md-4">
        	<select name="search_article_cat_id" class="form-control" id="search_article_cat_id">
                
				{!!$article_option_list!!}        
            </select>
        </div><!--/col-md-4-->
    </div><!--/form-group-->
    
    
    <div class="form-group">
    	<label class="col-md-1 control-label">关键词</label>
        <div class="col-md-4">
        	<input type="text" name="article_keywords" id="article_keywords" class="form-control" />
        </div><!--/col-md-4-->
    </div><!--/form-group-->
    <div class="form-group">
    	<div class="col-md-offset-1 col-md-4">
        	<span class="btn btn-success search-btn" id="search-article-btn">搜索</span>
        </div>
    </div>
    
    <div id="search-article-list">
    
    </div><!--/search-goods-list-->
</div><!--/ps-tab-content-item-->
<script type="text/javascript">
	$(function(){
		
		ps.article.search("{!!url('admin/goods/article')!!}","{!!csrf_token()!!}");
			
	});
</script>

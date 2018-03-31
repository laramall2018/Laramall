<script type="text/javascript" src="{!!url('files/bootstrap-filestyle.min.js')!!}"></script>
<div class="ps-tab-content-item">
	<div class="alert alert-info" role="alert">请选择商品类型，系统会自动调取该类型下的属性</div>
    
    <div class="form-group">
    	<label class="col-md-3 control-label">选择商品类型</label>
        <div class="col-md-4">
        	<select name="type_id" class="form-control" id="type_id">
            	{!!$goods_type_option_list!!}
            </select>
        </div>
    </div><!--/form-group-->
    <div class="goods-attr-div">
    
    	
    
    </div><!--/goods-attr-div-->
    
    
    
    
</div><!--/ps-tab-content-item-->
<script type="text/javascript">
  $(function(){
	  
	  ps.goods_attr_ajax("{!!url('admin/goods/attribute/ajax')!!}","{!!csrf_token()!!}");
	  ps.add_attr_form();
	  ps.del_attr_form();
  });
</script>
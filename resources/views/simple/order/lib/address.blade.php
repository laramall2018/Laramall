
<div class="ps-tab-content-item">
	
    
    <div class="alert alert-info">
    	<span>添加收货地址信息</span>
    </div>
    
    
    
     		<div class="form-group">
            	<label class="control-label col-sm-2">{!!trans('front.diqu')!!}</label>
                <div class="col-sm-2">
                	<select name="province" id="province" class="form-control pcd-select" data-type="2" data-tag="city">
                    	<option value="0">{!!trans('front.select')!!}</option>
                        @if($province_list)
                        @foreach($province_list as $item)
                        <option value="{!!$item->region_id!!}">{!!$item->region_name!!}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-sm-2">
                	<select name="city" id="city" class="form-control pcd-select" data-type="3" data-tag="district">
                    	<option value="0">{!!trans('front.select')!!}</option>
                    </select>
                </div>
                <div class="col-sm-2">
                	<select name="district" id="district" class="form-control">
                    	<option value="0">{!!trans('front.select')!!}</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
            	<label class="control-label col-sm-2">{!!trans('front.consignee')!!}</label>
                <div class="col-sm-4">
                	<input type="text" name="consignee" id="consignee" class="form-control" />
                </div>
            </div>
            
            <div class="form-group">
            	<label class="control-label col-sm-2">{!!trans('front.email')!!}</label>
                <div class="col-sm-4">
                	<input type="text" name="email" id="email" class="form-control" />
                </div>
            </div>
            
            <div class="form-group">
            	<label class="control-label col-sm-2">{!!trans('front.address')!!}</label>
                <div class="col-sm-4">
                	<input type="text" name="address" id="address" class="form-control" />
                </div>
            </div>
            
            <div class="form-group">
            	<label class="control-label col-sm-2">{!!trans('front.phone')!!}</label>
                <div class="col-sm-4">
                	<input type="text" name="phone" id="phone" class="form-control" />
                </div>
            </div>
    
</div><!--/ps-tab-content-item-->
<script type="text/javascript">
	$(function(){
		
		ps.pcd("{!!url('admin/pcd')!!}","{!!csrf_token()!!}");
			
	});
</script>

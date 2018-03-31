<!-- Button trigger modal -->
<button type="button" class="btn btn-success  address-btn-add btn-lg" data-toggle="modal" data-target="#myModal">
  <i class="fa fa-chevron-circle-right"></i>
  {!!trans('front.add_address')!!}
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{!!trans('front.add_address')!!}</h4>
      </div>
      <div class="modal-body">
         {!!Form::open(['url'=>'checkout-add-address','method'=>'post','class'=>'form-horizontal'])!!}
         	
            <div class="form-group">
            	<label class="control-label col-sm-3">{!!trans('front.diqu')!!}</label>
                <div class="col-sm-3">
                	<select name="province" id="province" class="form-control pcd-select" data-type="2" data-tag="city">
                    	<option value="0">{!!trans('front.select')!!}</option>
                        @if($province_list)
                        @foreach($province_list as $item)
                        <option value="{!!$item->region_id!!}">{!!$item->region_name!!}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-sm-3">
                	<select name="city" id="city" class="form-control pcd-select" data-type="3" data-tag="district">
                    	<option value="0">{!!trans('front.select')!!}</option>
                    </select>
                </div>
                <div class="col-sm-3">
                	<select name="district" id="district" class="form-control">
                    	<option value="0">{!!trans('front.select')!!}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-3">{!!trans('front.consignee')!!}</label>
                <div class="col-sm-9">
                	<input type="text" name="consignee" id="consignee" class="form-control" />
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-3">{!!trans('front.email')!!}</label>
                <div class="col-sm-9">
                	<input type="text" name="email" id="email" class="form-control" />
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-3">{!!trans('front.address')!!}</label>
                <div class="col-sm-9">
                	<input type="text" name="address" id="address" class="form-control" />
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-3">{!!trans('front.phone')!!}</label>
                <div class="col-sm-9">
                	<input type="text" name="phone" id="phone" class="form-control" />
                </div>
            </div>
            
         {!!Form::close()!!}
      </div>
      <div class="modal-footer">
       
        <span class="btn btn-success" id="address-ajax-btn">{!!trans('front.submit')!!}</span>
        <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('front.close')!!}</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(function(){
	
	front.cart.pcd("{!!url('checkout-pcd')!!}","{!!csrf_token()!!}");
	front.cart.address("{!!url('checkout-add-address')!!}","{!!csrf_token()!!}","{!!url('checkout')!!}");
});
</script>



<div class="payment-list">
	
    <div class="panel panel-success">
    	<div class="panel-heading">
        	<h5>{!!trans('front.shipping_list')!!}</h5>
        </div>
        <div class="panel-body">
        	<form class="form-horizontal">
  				<div class="form-group">
    				<label  class="col-sm-2 control-label">{!!trans('front.select_shipping')!!}</label>
    				<div class="col-sm-4">
      				<select name="shipping_id" id="shipping_id" class="form-control">
                    	<option value="0">{!!trans('front.select')!!}</option>
                        @if($shipping_list)
                        @foreach($shipping_list as $item)
                        <option value="{!!$item->id!!}">{!!$item->shipping_name!!}</option>
                        @endforeach
                        @endif
                    </select>
    				</div>
  				</div>
            </form>
        </div><!--/panel-body-->
    </div><!--/panel-->    
</div><!--/payment-list-->
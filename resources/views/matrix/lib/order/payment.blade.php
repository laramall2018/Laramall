
<div class="payment-list">
	
    <div class="panel panel-success">
    	<div class="panel-heading">
        	<h5>{!!trans('front.payment_list')!!}</h5>
        </div>
        <div class="panel-body">
        	<form class="form-horizontal">
  				<div class="form-group">
    				<label  class="col-sm-2 control-label">{!!trans('front.select_payment')!!}</label>
    				<div class="col-sm-4">
      				<select name="pay_id" id="pay_id" class="form-control">
                    	<option value="0">{!!trans('front.select')!!}</option>
                        @if($payment_list)
                        @foreach($payment_list as $item)
                        <option value="{!!$item->id!!}">{!!$item->pay_name!!}</option>
                        @endforeach
                        @endif
                    </select>
    				</div>
  				</div>
            </form>
        </div><!--/panel-body-->
    </div><!--/panel-->    
</div><!--/payment-list-->
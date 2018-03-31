
<div class="panel panel-success">
	
    <div class="panel-heading">
    	<h5>{!!trans('front.address_list')!!}</h5>
    </div>
    <div class="panel-body">
        @include('matrix.lib.order.add_address')
    	<div class="address_list">
        		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  					
                    @if($address_list)
                    @foreach($address_list as $key=>$item)
                    	
                        <div class="panel panel-default">
    						<div class="panel-heading" role="tab" id="heading{!!$key!!}">
      							<h4 class="panel-title">
                                
                                <input type="radio" name="address_id" value="{!!$item->id!!}" @if($item->id == Auth::user()->address_id) checked="checked" @endif />
                                
        	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{!!$key!!}" aria-expanded="false" aria-controls="collapse{!!$key!!}">
          {!!$item->address!!}
          </a>
      </h4>
    </div>
    <div id="collapse{!!$key!!}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{!!$key!!}">
      <div class="panel-body">
          @include('matrix.lib.order.address_form')
      </div>
    </div>
  </div>
                        
                    @endforeach
                    @endif
                    
                    
  					
                    
        		</div>
         </div><!--/address_list-->
       </div><!--/body-->

</div><!--/panel-->
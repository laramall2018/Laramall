<!--获取用户的所有地址列表-->
<div class="row">
<div class="col s12">
<div class="card-panel">
@if(Auth::user('user')->address()->get())
	<table class="table bordered">
		@foreach(Auth::user('user')->address()->get() as $address)
		<tr>
			<td>
				<input type="radio" name="address_id" 
					   @if(Auth::user('user')->address_id == $address->id)
					  checked="checked" 
					  @endif
					  id="address_id{!!$address->id!!}" 
					  value="{!!$address->id!!}">
				<label for="address_id{!!$address->id!!}"></label>
			</td>
			<td>
				
				<a href="{!!url('mobile/address/'.$address->id)!!}">
					{!!$address->consignee!!}-{!!$address->address()!!}
				</a>
				
			</td>
		</tr>
		@endforeach
	</table>

@endif

<a href="{!!url('mobile/address/create')!!}" class="btn red" style="margin-top:10px;">
	<i class="material-icons left">mode_edit</i>
	添加地址
</a>


</div>
</div>
</div>
<!--地址列表结束-->





<script type="text/javascript">
	
  $(document).ready(function(){
    
    $('.modal-trigger').leanModal();
    $('select').material_select();
  });
          
</script>
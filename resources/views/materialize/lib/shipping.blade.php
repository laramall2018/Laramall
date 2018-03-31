<div class="row">
	<div class="col s12">
		<div class="card-panel">
			<table class="table bordered">
				<tr>
					<th>选择</th>
					<th>配送方式</th>
				</tr>
				@foreach(App\Models\Shipping::all() as $shipping)
				<tr>
					<th>
					    <input type="radio" name="shipping_id" class="shipping_id" id="shipping_id{!!$shipping->id!!}" value="{!!$shipping->id!!}">
					    <label for="shipping_id{!!$shipping->id!!}"></label>
					</th>
					<th>
						{!!$shipping->shipping_name!!}-[{!!$shipping->fee!!}]
					</th>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>


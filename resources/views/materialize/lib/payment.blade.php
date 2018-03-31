<div class="row">
	<div class="col s12">
		<div class="card-panel">
			<table class="table bordered">
				<tr>
					<th>选择</th>
					<th>支付名称</th>
				</tr>
				@foreach(App\Models\Payment::all() as $payment)
				<tr>
					<th>
					    <input type="radio" name="pay_id" id="pay_id{!!$payment->id!!}" value="{!!$payment->id!!}">
					    <label for="pay_id{!!$payment->id!!}"></label>
					</th>
					<th>
						{!!$payment->pay_name!!}
					</th>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>
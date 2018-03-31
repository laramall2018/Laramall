@if(count($goods->field()->get()) > 0)
<div class="row">
	<div class="panel panel-goods">
		<div class="panel-heading">
			<h4>商品规格</h4>
		</div><!--/panel-heading-->
		<div class="panel-body" style="padding: 10px;">
			<table class="table table-bordered table-striped table-hover order-tab">
				@foreach($goods->field()->get() as $field)
				<tr>
					<td>{{$field->field->field_name}}</td>
					<td>{{$field->field_value}}</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>
@endif
<h4 class="tit">
	退货单基本信息
</h4>
<table class="table table-bordered table-hover table-striped order-tab">
	<tr>
		<th>订单号</th>
		<td>{{$model->presenter()->order_sn}}</td>
		<th>退货人</th>
		<td>{{$model->username}}</td>
	</tr>
	<tr>
		<th>退货类型</th>
		<td>{{$model->type}}</td>
		<th>退货说明</th>
		<td>{{$model->return_note}}</td>
	</tr>
	<tr>
		<th>银行名称</th>
		<td>{{$model->bank_name}}</td>
		<th>银行账户</th>
		<td>{{$model->bank_account}}</td>
	</tr>
	<tr>
		<th>退款金额</th>
		<td class="price">{{$model->presenter()->return_amount_format}}</td>
		<th>退货状态</th>
		<td>{{$model->status()}}</td>
	</tr>
	<tr>
		<th>申请时间</th>
		<td>{{$model->createTime}}</td>
		<th>申请来源</th>
		<td>{{$model->reg_from}}</td>
	</tr>
</table><!--/table-->
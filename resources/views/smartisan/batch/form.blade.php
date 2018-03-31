

<form v-if="order_list.length == 0 && orders.length == 0">
	
	<div class="form-group">
		<textarea v-model="orderStr" cols="30" rows="15" class="form-control"></textarea>
	</div><!--/form-group-->

	<div class="form-group">
	<span class="ls-btn-info" v-on:click="createForm">
		<i class="fa fa-check"></i>
		确认下单
	</span>
	</div>
</form>
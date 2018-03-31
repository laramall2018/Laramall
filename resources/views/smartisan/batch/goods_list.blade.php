
<div class="goods-list-content" v-if="order_list.length > 0 && orders.length == 0">
	
	
	{!!Form::open(['url'=>'api/batch-order/done','method'=>'post','class'=>'form-horizontal'])!!}

		<div class="order-list" v-for="(order,index) in order_list">
			
			<div class="alert alert-info">
				<p>订单 @{{index + 1}}</p>
			</div>
			
			<input type="hidden" name="keys[]" v-bind:value="index">

			<div class="goods-list-item" v-for="item in order.order.goods">
				
			<div class="form-group" v-for="(goods,key) in item">
				<div class="col-md-4">
					<label for="" class="col-md-3 control-label">商品名称</label>
					<div class="col-md-9">

						<select class="form-control"
								v-bind:name="'goods_ids' + index +'[]'">
							<option v-bind:value="gItem.id"
									v-for="gItem in goods.goods_list">@{{gItem.goods_name}}</option>
						</select>

					</div>
				</div><!--/col-md-4-->

				<div class="col-md-4">
					<label for="" class="col-md-3 control-label">商品属性</label>
					<div class="col-md-9">
						<input type="text" class="form-control" v-model="goods.attr" v-bind:name="'attrs'+index+'[]'">
					</div>
				</div><!--/col-md-4-->

				<div class="col-md-3">
					<label for="" class="col-md-3 control-label">数量</label>
					<div class="col-md-9">
						<input type="text" class="form-control" v-model="goods.number" v-bind:name="'goods_numbers'+index+'[]'">
					</div>
				</div><!--/col-md-4-->

				<div class="col-md-1">
					<span class="btn btn-danger" v-on:click="delItem">
						<i class="fa fa-times"></i>
					</span>
				</div>
			</div><!--/form-group-->

  			</div><!--/goods-list-item-->

  			<div class="form-group">
  				<div class="col-md-4">
  				    <label for="" class="col-md-3 control-label">收货姓名</label>
  				    <div class="col-md-9">
  				    		<input type="text" 
  				    			   v-model="order.order.address.username" 
  				    			   v-bind:name="'usernames'+index+'[]'" 
  				    			   class="form-control">
  				    </div>
  				</div><!--/col-md-4-->
  				<div class="col-md-4">
  					<label for="" class="col-md-3 control-label">联系手机</label>
  					<div class="col-md-9">
  						<input type="text" 
  							   v-model="order.order.address.phone" 
  							   v-bind:name="'phones'+index+'[]'" 
  							   class="form-control">
  					</div>
  				</div><!--/col-md-4-->
  				<div class="col-md-3">
  					<label for="" class="col-md-3 control-label">地址</label>
  					<div class="col-md-9">
  						<input type="text" 
  						       v-model="order.order.address.address" 
  						       v-bind:name="'address'+index+'[]'" 
  						       class="form-control">
  					</div>
  				</div>
  			</div><!--/form-group-->

		</div><!--/order-list-->
    		
  		<div class="form-group">
    		<div class="col-sm-12">
      			<span class="ls-btn-info" v-on:click="orderDone">确认下单</span>

      			<span class="ls-btn-default" v-on:click="resetInput">重新输入</span>
    		</div>
  		</div>

	{!!Form::close()!!}
</div><!--/goods-list-content-->
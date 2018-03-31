
	<div class="col-md-6">
	<div class="gift-card-item">
		<span>礼品卡</span>
		<select v-model="card_sn" class="form-control card-input">
			<option v-bind:value="card.card_sn" v-for="card in rows.card_list">
				@{{card.card_sn}} (￥@{{card.price}})
			</option>
		</select>
		<button class="btn btn-success" v-on:click="checkGiftCard">
			立即使用
		</button>
	</div><!--/gift-card-item-->
    </div><!--/col-md-6-->

    <div class="col-md-6">
		<span class="ls-btn-info order-done-btn" v-on:click="orderDone">
			确认下单
		</span>
	</div><!--/col-md-6-->
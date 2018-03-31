<div class="row" id="fpapp">
	<div class="panel panel-goods">
		<div class="panel-heading">
			<h4>发票信息</h4>
		</div><!--/panel-heading-->
		<div class="panel-body">
			<div class="fp-content padding20">
			<div class="fp-item">
						<span class="tit">发票类型</span>
						<span class="checked-btn"
							  v-on:click="changeType(0)"
							  v-bind:class="{'checked-on':fp_type == 0}"></span>
						<span>纸质发票</span>
						<span class="checked-btn"
							  v-on:click="changeType(1)"
							  v-bind:class="{'checked-on':fp_type == 1}"></span>
						<span>电子发票</span>
			</div><!--/fp-item-->
			<div class="fp-item">
						<span class="tit">发票抬头</span>
						<span class="checked-btn"
							  v-on:click="changeTag(0)"
						      v-bind:class="{'checked-on':fp_tag == 0}"></span>
						<span>个人</span>
						<span class="checked-btn"
						      v-on:click="changeTag(1)" 
							  v-bind:class="{'checked-on':fp_tag == 1}"></span>
						<span>公司</span>
						<input type="text" v-model="fp_title" class="form-control" v-if="fp_tag == 1">
			</div><!--/fp-item-->
			<div class="fp-item">
						<span class="tit">发票内容</span>
						<span>商品明细</span>
			</div>
			<div class="fp-item-desc">
				*电子发票是税务局认可的有效收付款凭证，可作为售后服务凭据。电子发票打印后可以用于企业报销。 
			</div>
			</div><!--/fp-content-->
		</div><!--/panel-body-->
	</div>
</div><!--/row-->
@include('smartisan.vue.fp')
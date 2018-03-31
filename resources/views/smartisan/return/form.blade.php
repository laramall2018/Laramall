<form class="form-horizontal" role="form">

  <div class="form-group">
    <label  class="col-sm-2 control-label">选择订单</label>
    <div class="col-sm-10">
      <select v-model="order_id" class="form-control">
          <option value="">请选择</option>
          <option v-bind:value="order.id" v-for="order in rows.order_list">
            @{{order.order_sn}}
          </option>
      </select>
    </div>
  </div><!--/form-group-->
  
  <div class="form-group">
    <label  class="col-sm-2 control-label">退货类型</label>
    <div class="col-sm-10">
      <select v-model="type" class="form-control">
         <option value="全部退货">全部退货</option>
         <option value="部分退货">部分退货</option>
         <option value="换货">换货</option>
      </select>
    </div>
  </div><!--/form-group-->

  <div class="form-group">
    <label  class="col-sm-2 control-label">退货姓名</label>
    <div class="col-sm-10">
      <input v-model="username" class="form-control">
    </div>
  </div><!--/form-group-->

  <div class="form-group">
    <label class="col-sm-2 control-label">退货说明</label>
    <div class="col-sm-10">
      <textarea v-model="return_note" cols="30" rows="10" class="form-control"></textarea>
    </div>
  </div><!--/form-group-->

  <div class="form-group">
    <label  class="col-sm-2 control-label">银行名称</label>
    <div class="col-sm-10">
      <input v-model="bank_name" class="form-control">
    </div>
  </div><!--/form-group-->

  <div class="form-group">
    <label  class="col-sm-2 control-label">银行账号</label>
    <div class="col-sm-10">
      <input v-model="bank_account" class="form-control">
    </div>
  </div><!--/form-group-->

  <div class="form-group">
    <label  class="col-sm-2 control-label">退款金额</label>
    <div class="col-sm-10">
      <input v-model="return_amount" class="form-control">
    </div>
  </div><!--/form-group-->

</form><!--/form-->

  
<form class="form-horizontal" role="form">

  <div class="form-group">
    <label  class="col-sm-2 control-label">操作类型</label>
    <div class="col-sm-10">
      <select v-model="type" class="form-control">
         <option value="0">充值</option>
         <option value="1">提现</option>
      </select>
    </div>
  </div><!--/form-group-->
  
  <div class="form-group">
    <label  class="col-sm-2 control-label">操作金额</label>
    <div class="col-sm-10">
      <input v-model="amount" class="form-control">
    </div>
  </div><!--/form-group-->

  <div class="form-group">
    <label  class="col-sm-2 control-label">支付方式</label>
    <div class="col-sm-10">
      <input v-model="payment" class="form-control">
    </div>
  </div><!--/form-group-->

  <div class="form-group">
    <label class="col-sm-2 control-label">用户备注</label>
    <div class="col-sm-10">
      <textarea v-model="user_note" cols="30" rows="10" class="form-control"></textarea>
    </div>
  </div><!--/form-group-->

</form><!--/form-->

  
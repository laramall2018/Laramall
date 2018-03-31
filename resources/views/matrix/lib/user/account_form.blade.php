{!!Form::open(['url'=>'auth/money','method'=>'post','class'=>'form-horizontal'])!!}
    <div class="form-group">
        <label for="consignee" class="col-sm-3 control-label">{!!trans('front.type')!!}</label>
          <div class="col-sm-9">
            <input type="radio" name="type" class="icheck mycheckbox" value="0" checked="checked">{!!trans('front.chongzhi')!!}
            <input type="radio" name="type" class="icheck mycheckbox" value="1">{!!trans('front.tixian')!!}
         </div>
    </div>
    <div class="form-group">
        <label for="consignee" class="col-sm-3 control-label">{!!trans('front.amount')!!}</label>
          <div class="col-sm-9">
          <input type="text" class="form-control" id="amount" name="amount" >
         </div>
    </div>
    <div class="form-group">
        <label for="consignee" class="col-sm-3 control-label">{!!trans('front.payment')!!}</label>
          <div class="col-sm-9">
          <input type="text" class="form-control" id="payment" name="payment">
         </div>
    </div>
    <div class="form-group">
        <label for="consignee" class="col-sm-3 control-label">{!!trans('front.user_note')!!}</label>
          <div class="col-sm-9">
          <input type="text" class="form-control" id="user_note" name="user_note" >
         </div>
    </div>



   <div class="form-group">
      <div class="col-sm-9 col-sm-offset-3">

          <button type="submit" class="btn btn-success">
              <span class="glyphicon glyphicon-ok"></span>
              {!!trans('front.submit')!!}
          </button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">
            <i class="fa fa-times"></i>
            {!!trans('front.close')!!}
          </button>
      </div>
   </div>
{!!Form::close()!!}
<script type="text/javascript">
	$(function(){
      front.icheckbox();
	});
</script>

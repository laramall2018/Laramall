{!!Form::open(['url'=>'auth/address','method'=>'post','class'=>'form-horizontal'])!!}
    <div class="form-group">
        <label for="consignee" class="col-sm-3 control-label">{!!trans('front.consignee')!!}</label>
          <div class="col-sm-9">
          <input type="text" class="form-control" id="consignee" name="consignee" >
         </div>
    </div>
    <div class="form-group">
        <label for="consignee" class="col-sm-3 control-label">{!!trans('front.email')!!}</label>
          <div class="col-sm-9">
          <input type="text" class="form-control" id="email" name="email" >
         </div>
    </div>
    <div class="form-group">
        <label for="consignee" class="col-sm-3 control-label">{!!trans('front.phone')!!}</label>
          <div class="col-sm-9">
          <input type="text" class="form-control" id="phone" name="phone">
         </div>
    </div>
    <div class="form-group">
        <label for="consignee" class="col-sm-3 control-label">{!!trans('front.zipcode')!!}</label>
          <div class="col-sm-9">
          <input type="text" class="form-control" id="zipcode" name="zipcode" >
         </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">{!!trans('front.pcd')!!}</label>
        <div class="col-sm-3">
            <select name="province" id="province" class="form-control pcd-select" data-type="2" data-tag="city">
                <option value="">选择</option>
                @foreach($province_list as $item)
                <option value="{!!$item->region_id!!}">{!!$item->region_name!!}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3">
            <select name="city" id="city" class="form-control pcd-select" data-type="3" data-tag="district">
                <option value="">选择</option>

            </select>
        </div>
        <div class="col-sm-3">
            <select name="district" id="district" class="form-control">
                <option value="">选择</option>

            </select>
        </div>
    </div><!--/form-group-->
    <div class="form-group">
        <label class="col-sm-3 control-label">{!!trans('front.address')!!}</label>
        <div class="col-sm-9">
          <input type="text" name="address" id="address" class="form-control" >
        </div><!--col-sm-5-->
   </div><!--/form-group-->
   <div class="form-group">
      <div class="col-sm-9 col-sm-offset-3">

          <button type="submit" class="btn btn-success">
              <span class="glyphicon glyphicon-ok"></span>
              {!!trans('front.edit_submit')!!}
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

	front.cart.pcd("{!!url('checkout-pcd')!!}","{!!csrf_token()!!}");
});
</script>

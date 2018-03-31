<div class="col-md-9">

<div class="panel panel-default">
<div class="panel-heading">

	<h5>
    	<span class="glyphicon glyphicon-th-list"></span>
        <span class="tit">{!!trans('front.address_list')!!}</span>
    </h5>
 </div>

<div class="panel-body">

  {!!Form::open(['url'=>'auth/address/'.$model->id,'method'=>'post','class'=>'form-horizontal'])!!}
      <div class="form-group">
          <label for="consignee" class="col-sm-2 control-label">{!!trans('front.consignee')!!}</label>
            <div class="col-sm-5">
            <input type="text" class="form-control" id="consignee" name="consignee" value="{!!$model->consignee!!}">
           </div>
      </div>
      <div class="form-group">
          <label for="consignee" class="col-sm-2 control-label">{!!trans('front.email')!!}</label>
            <div class="col-sm-5">
            <input type="text" class="form-control" id="email" name="email" value="{!!$model->email!!}">
           </div>
      </div>
      <div class="form-group">
          <label for="consignee" class="col-sm-2 control-label">{!!trans('front.phone')!!}</label>
            <div class="col-sm-5">
            <input type="text" class="form-control" id="phone" name="phone" value="{!!$model->phone!!}">
           </div>
      </div>
      <div class="form-group">
          <label for="consignee" class="col-sm-2 control-label">{!!trans('front.zipcode')!!}</label>
            <div class="col-sm-5">
            <input type="text" class="form-control" id="zipcode" name="zipcode" value="{!!$model->zipcode!!}">
           </div>
      </div>

      <div class="form-group">
          <label class="col-sm-2 control-label">{!!trans('front.pcd')!!}</label>
          <div class="col-sm-3">
              <select name="province" id="province" class="form-control pcd-select" data-type="2" data-tag="city">
                  <option value="">选择</option>
                  @foreach($province_list as $item)
                  <option value="{!!$item->region_id!!}" @if($model->province == $item->region_id) selected="selected" @endif>{!!$item->region_name!!}</option>
                  @endforeach
              </select>
          </div>
          <div class="col-sm-3">
              <select name="city" id="city" class="form-control pcd-select" data-type="3" data-tag="district">
                  <option value="">选择</option>
                  <option value="{!!$model->city!!}" selected="selected">{!!$city_str!!}</option>
              </select>
          </div>
          <div class="col-sm-3">
              <select name="district" id="district" class="form-control">
                  <option value="">选择</option>
                  <option value="{!!$model->district!!}" selected="selected">{!!$district_str!!}</option>
              </select>
          </div>
      </div><!--/form-group-->
      <div class="form-group">
          <label class="col-sm-2 control-label">{!!trans('front.address')!!}</label>
          <div class="col-sm-5">
            <input type="text" name="address" id="address" class="form-control" value="{!!$model->address!!}">
          </div><!--col-sm-5-->
     </div><!--/form-group-->
     <div class="form-group">
        <div class="col-sm-5 col-sm-offset-2">
            <input type="hidden" name="_method"  value="PUT">
            <input type="hidden" name="id" value="{!!$model->id!!}">
            <button type="submit" class="btn btn-success">
                <span class="glyphicon glyphicon-ok"></span>
                {!!trans('front.edit_submit')!!}
            </button>
            <a href="{!!$back_url!!}" class="btn btn-info">
                {!!trans('front.back_url')!!}
            </a>
        </div>
     </div>



  {!!Form::close()!!}

</div><!--/panel-body-->
</div><!--/panel-->
</div><!--/col-md-9-->

<script type="text/javascript">
$(function(){

	front.cart.pcd("{!!url('checkout-pcd')!!}","{!!csrf_token()!!}");
});
</script>

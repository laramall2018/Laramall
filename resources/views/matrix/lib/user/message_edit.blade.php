<div class="col-md-9">

<div class="panel panel-default">
<div class="panel-heading">

	<h5>
    	<span class="glyphicon glyphicon-th-list"></span>
        <span class="tit">{!!trans('front.message_list')!!}</span>
    </h5>
 </div>

<div class="panel-body">

  {!!Form::open(['url'=>'auth/message/'.$model->id,'method'=>'post','class'=>'form-horizontal'])!!}
  <div class="form-group">
      <label for="tag_name" class="col-sm-3 control-label">{!!trans('front.type')!!}</label>
        <div class="col-sm-9">
          <select name="type" id="type" class="form-control">
              <option value="{!!$model->type!!}" selected="selected">{!!$model->type!!}</option>
              <option value="{!!trans('front.message_type')!!}">{!!trans('front.message_type')!!}</option>
              <option value="{!!trans('front.opinion_type')!!}">{!!trans('front.opinion_type')!!}</option>
              <option value="{!!trans('front.proposal_type')!!}">{!!trans('front.proposal_type')!!}</option>
              <option value="{!!trans('front.comment_type')!!}">{!!trans('front.comment_type')!!}</option>

          </select>
       </div>
  </div>


  <div class="form-group">
      <label for="consignee" class="col-sm-3 control-label">{!!trans('front.email')!!}</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="email" name="email" value="{!!$model->email!!}">
       </div>
  </div>

  <div class="form-group">
      <label class="col-sm-3 control-label">{!!trans('front.goods_name')!!}</label>
      <div class="col-sm-9">
          <select name="id_value" id="id_value" class="form-control">
              <option value="">{!!trans('front.select')!!}</option>
              @foreach($goods_list as $item)
              <option value="{!!$item->id!!}" @if($item->id == $model->id_value) selected="selected" @endif>{!!$item->goods_name!!}</option>
              @endforeach
          </select>
      </div>
  </div><!--/form-group-->
  <div class="form-group">
      <label class="col-sm-3 control-label">{!!trans('front.rank')!!}</label>
      <div class="col-sm-9">
          <input type="radio" name="rank" value="1" class="icheck mycheckbox" @if($model->rank == 1) checked="checked" @endif>1
          <input type="radio" name="rank" value="2" class="icheck mycheckbox" @if($model->rank == 2) checked="checked" @endif>2
          <input type="radio" name="rank" value="3" class="icheck mycheckbox" @if($model->rank == 3) checked="checked" @endif>3
          <input type="radio" name="rank" value="4" class="icheck mycheckbox" @if($model->rank == 4) checked="checked" @endif>4
          <input type="radio" name="rank" value="5" class="icheck mycheckbox" @if($model->rank == 5) checked="checked" @endif>5
      </div>
  </div><!--/form-group-->
  <div class="form-group">
      <label for="content" class="col-sm-3 control-label">{!!trans('front.content')!!}</label>
        <div class="col-sm-9">
        <textarea class="form-control" id="content" name="content" rows="10">{!!$model->content!!}</textarea>
       </div>
  </div>
  @if($model->reply)
  <div class="form-group">
      <label for="content" class="col-sm-3 control-label">{!!trans('front.admin_reply')!!}</label>
        <div class="col-sm-9">
        <textarea class="form-control" id="content" name="content" rows="10" disabled>{!!$model->reply!!}</textarea>
       </div>
  </div>
  @endif

  <div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
      <input type="hidden" name="_method"  value="PUT">
      <input type="hidden" name="id" value="{!!$model->id!!}">
        <button type="submit" class="btn btn-success">
            <span class="glyphicon glyphicon-ok"></span>
            {!!trans('front.edit_submit')!!}
        </button>
        <a href="{!!url($back_url)!!}" class="btn btn-info">{!!trans('front.back_url')!!}</a>
    </div>
 </div>
  {!!Form::close()!!}

</div><!--/panel-body-->
</div><!--/panel-->
</div><!--/col-md-9-->
<script type="text/javascript">
	$(function(){
      front.icheckbox();
	});
</script>

<div class="col-md-9">

<div class="panel panel-default">
<div class="panel-heading">

	<h5>
    	<span class="glyphicon glyphicon-th-list"></span>
        <span class="tit">{!!trans('front.tag_list')!!}</span>
    </h5>
 </div>

<div class="panel-body">

  {!!Form::open(['url'=>'auth/tag/'.$model->id,'method'=>'post','class'=>'form-horizontal'])!!}
  <div class="form-group">
      <label for="tag_name" class="col-sm-3 control-label">{!!trans('front.tag_name')!!}</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="tag_name" name="tag_name" value="{!!$model->tag_name!!}" >
       </div>
  </div>


  <div class="form-group">
      <label for="consignee" class="col-sm-3 control-label">{!!trans('front.sort_order')!!}</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="sort_order" name="sort_order" value="{!!$model->sort_order!!}">
       </div>
  </div>

  <div class="form-group">
      <label class="col-sm-3 control-label">{!!trans('front.goods_name')!!}</label>
      <div class="col-sm-9">
          <select name="goods_id" id="goods_id" class="form-control">
              <option value="">{!!trans('front.select')!!}</option>
              @foreach($goods_list as $item)
              <option value="{!!$item->id!!}" @if($item->id == $model->goods_id) selected="selected" @endif>{!!$item->goods_name!!}</option>
              @endforeach
          </select>
      </div>


  </div><!--/form-group-->

 <div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">

			{{method_field('PATHCH')}}
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

{!!Form::open(['url'=>'auth/tag','method'=>'post','class'=>'form-horizontal'])!!}
    <div class="form-group">
        <label for="tag_name" class="col-sm-3 control-label">{!!trans('front.tag_name')!!}</label>
          <div class="col-sm-9">
          <input type="text" class="form-control" id="tag_name" name="tag_name" >
         </div>
    </div>


    <div class="form-group">
        <label for="consignee" class="col-sm-3 control-label">{!!trans('front.sort_order')!!}</label>
          <div class="col-sm-9">
          <input type="text" class="form-control" id="sort_order" name="sort_order" value="0">
         </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">{!!trans('front.goods_name')!!}</label>
        <div class="col-sm-9">
            <select name="goods_id" id="goods_id" class="form-control">
                <option value="">{!!trans('front.select')!!}</option>
                @foreach($goods_list as $item)
                <option value="{!!$item->id!!}">{!!$item->goods_name!!}</option>
                @endforeach
            </select>
        </div>


    </div><!--/form-group-->

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

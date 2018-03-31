{!!Form::open(['url'=>'auth/message','method'=>'post','class'=>'form-horizontal'])!!}
    <div class="form-group">
        <label for="tag_name" class="col-sm-3 control-label">{!!trans('front.type')!!}</label>
          <div class="col-sm-9">
            <select name="type" id="type" class="form-control">
                <option value="">{!!trans('front.select')!!}</option>
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
          <input type="text" class="form-control" id="email" name="email" value="{!!Auth::user('user')->email!!}">
         </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">{!!trans('front.goods_name')!!}</label>
        <div class="col-sm-9">
            <select name="id_value" id="id_value" class="form-control">
                <option value="">{!!trans('front.select')!!}</option>
                @foreach($goods_list as $item)
                <option value="{!!$item->id!!}">{!!$item->goods_name!!}</option>
                @endforeach
            </select>
        </div>
    </div><!--/form-group-->
    <div class="form-group">
        <label class="col-sm-3 control-label">{!!trans('front.rank')!!}</label>
        <div class="col-sm-9">
            <input type="radio" name="rank" value="1" class="icheck mycheckbox" checked="checked">1
            <input type="radio" name="rank" value="2" class="icheck mycheckbox">2
            <input type="radio" name="rank" value="3" class="icheck mycheckbox">3
            <input type="radio" name="rank" value="4" class="icheck mycheckbox">4
            <input type="radio" name="rank" value="5" class="icheck mycheckbox">5
        </div>
    </div><!--/form-group-->
    <div class="form-group">
        <label for="content" class="col-sm-3 control-label">{!!trans('front.content')!!}</label>
          <div class="col-sm-9">
          <textarea class="form-control" id="content" name="content" rows="10"></textarea>
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

<div class="col-md-9">

<div class="panel panel-default">
<div class="panel-heading">

	<h5>
    	<span class="glyphicon glyphicon-th-list"></span>
        <span class="tit">{!!trans('front.sms_list')!!}</span>
    </h5>
 </div>

<div class="panel-body">

 @if($sms_list)
 @foreach($sms_list as $sms)
 <div class="row">
     <div class="col-md-2 text-center">
         @if(Auth::user('user')->user_icon)
         <img src="{!!url(Auth::user('user')->user_icon)!!}" class="img-circle" style="width:60px;">
         @else
         <img src="{!!url('front/matrix/images/user-icon-def.png')!!}" class="img-circle" style="width:60px;">
         @endif
         <p>{!!Auth::user('user')->username!!}</p>
     </div><!--/col-md-1-->
     <div class="col-md-8">
           <div class="alert alert-info">
               <div class="row">
                     <div class="col-md-8">
                     {!!$sms->sms_content!!}
                     <p>{!!$sms->ip!!}</p>
                    </div>
                    <div class="col-md-4 text-right">
                      <?php echo date('Y-m-d H:i:s',$sms->post_time);?>

                        <a href="{!!url('auth/sms/delete/'.$sms->id)!!}"  data-url="{!!url('auth/sms/delete/'.$sms->id)!!}" class="del-confirm">
                          <i class="fa fa-times"></i>
                        </a>

                    </div><!--/col-md-2-->
               </div><!--/row-->
           </div>

      </div><!--/col-md-8-->
 </div><!--/row-->

 @if($sms->reply_content)
 <div class="row">

     <div class="col-md-8 col-md-offset-2">
           <div class="alert alert-danger ">
               <div class="row">
                     <div class="col-md-8">
                     {!!$sms->reply_content!!}
                    </div>
                    <div class="col-md-3 text-right">
                      <?php echo date('Y-m-d H:i:s',$sms->reply_time);?>
                    </div><!--/col-md-2-->
               </div><!--/row-->
           </div>
      </div><!--/col-md-8-->
      <div class="col-md-2 text-left">
				  @if($sms['admin'])
          @if($sms['admin']->user_icon)
          <img src="{!!url($sms['admin']->user_icon)!!}" class="img-circle" style="width:60px;">
          @else
          <img src="{!!url('front/matrix/images/admin-icon-def.png')!!}" class="img-circle" style="width:60px;">
          @endif
          <p>{!!trans('front.administrator')!!} {!!$sms['admin']->username!!}</p>
					@endif
      </div><!--/col-md-1-->
 </div><!--/row-->
 @endif
 @endforeach
 {!!$sms_list->render()!!}
 @endif

  {!!Form::open(['url'=>'auth/sms','method'=>'post','class'=>'form-horizontal'])!!}
      <div class="form-group">
          <div class="col-md-10">
            <input type="text" name="sms_content" id="sms_content" class="form-control">
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-success">
              <span class="glyphicon glyphicon-ok"></span>
              {!!trans('front.send')!!}
            </button>
          </div>
      </div>
  {!!Form::close()!!}



</div><!--/panel-body-->
</div><!--/panel-->
</div><!--/col-md-9-->
<script type="text/javascript">
	$(function(){
			front.confirm();
	});
</script>

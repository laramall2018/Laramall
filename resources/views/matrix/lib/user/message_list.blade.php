<div class="col-md-9">

<div class="panel panel-default">
<div class="panel-heading">

	<h5>
    	<span class="glyphicon glyphicon-th-list"></span>
        <span class="tit">{!!trans('front.message_list')!!}</span>
    </h5>
 </div>

<div class="panel-body">
	<span class="btn btn-success add-address-btn" data-toggle="modal" data-target="#auth-address-model">
			<span class="glyphicon glyphicon-plus"></span>
			{!!trans('front.add_message')!!}
	</span>
	<table class="table table-bordered table-hover">

        <tr>
        	<th>{!!trans('front.id')!!}</th>
            <th>{!!trans('front.type')!!}</th>
            <th>{!!trans('front.content')!!}</th>
            <th>{!!trans('front.status')!!}</th>
            <th>{!!trans('front.add_time')!!}</th>
            <th style="width:180px;">{!!trans('front.operation')!!}</th>
        </tr>

        @if($message_list)
        @foreach($message_list as $item)
        <tr>
           <td>{!!$item->id!!}</td>
           <td>{!!$item->type!!}</td>
           <td>{!!$item->content!!}</td>
           <td>
             @if($item->status == 1)
             {!!trans('front.enabled')!!}
             @else
             {!!trans('front.disabled')!!}
             @endif
           </td>
           <td><?php echo date('Y-m-d',$item->add_time);?></td>
           <td>
              <a href="{!!url('auth/message/'.$item->id.'/edit')!!}" class="btn btn-primary">
                <span class="glyphicon glyphicon-pencil"></span>
                {!!trans('front.edit')!!}
              </a>
              <a href="{!!url('auth/message/delete/'.$item->id)!!}" class="btn btn-danger del-confirm"
								data-url="{!!url('auth/message/delete/'.$item->id)!!}"
								>
                  <i class="fa fa-times"></i>
                  {!!trans('front.delete')!!}
              </a>
           </td>
        </tr>
        @endforeach
        @endif
  </table>
  {!!$message_list->render()!!}


	<!-- Modal -->
<div class="modal fade" id="auth-address-model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-body">
        @include('matrix.lib.user.message_form')
      </div><!--/model-body-->
    </div>
  </div>
</div>

</div><!--/panel-body-->
</div><!--/panel-->
</div><!--/col-md-9-->
<script type="text/javascript">
	$(function(){
			front.confirm();
      front.icheckbox();
	});
</script>

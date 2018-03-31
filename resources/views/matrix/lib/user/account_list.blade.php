<div class="col-md-9">

<div class="panel panel-default">
<div class="panel-heading">

	<h5>
    	<span class="glyphicon glyphicon-th-list"></span>
        <span class="tit">{!!trans('front.account_list')!!}</span>
    </h5>
 </div>

<div class="panel-body">
	<span class="btn btn-success add-address-btn" data-toggle="modal" data-target="#auth-address-model">
			<span class="glyphicon glyphicon-plus"></span>
			{!!trans('front.add_account')!!}
	</span>
	<table class="table table-bordered table-hover">

        <tr>
        	  <th>{!!trans('front.id')!!}</th>
            <th>{!!trans('front.type')!!}</th>
            <th>{!!trans('front.ip')!!}</th>
            <th>{!!trans('front.add_time')!!}</th>
            <th>{!!trans('front.status')!!}</th>
            <th>{!!trans('front.user_note')!!}</th>
            <th>{!!trans('front.amount')!!}</th>

        </tr>

        @if($account_list)
        @foreach($account_list as $item)
        <tr>
           <td>{!!$item->id!!}</td>
           <td>
              @if($item->type == 0)
              {!!trans('front.chongzhi')!!}
              @else
              {!!trans('front.tixian')!!}
              @endif
           </td>
           <td>{!!$item->ip!!}</td>
           <td><?php echo date('Y-m-d',$item->add_time);?></td>
           <td>
              @if($item->pay_tag ==1)
              {!!trans('front.enabled')!!}
              @else
              {!!trans('front.disabled')!!}
              @endif
           </td>
           <td>{!!$item->user_note!!}</td>
           <td>{!!$item->amount!!}</td>

        </tr>
        @endforeach
        @endif

        <tr>
            <td colspan="6">{!!trans('front.user_account_amount')!!}</td>
            <td class="org">{!!$total_amount!!}</td>
       </tr>
  </table>
 {!!$account_list->render()!!}

	<!-- Modal -->
<div class="modal fade" id="auth-address-model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-body">
         @include('matrix.lib.user.account_form')
      </div>
    </div>
  </div>
</div>

</div><!--/panel-body-->
</div><!--/panel-->
</div><!--/col-md-9-->
<script type="text/javascript">
	$(function(){
			front.confirm();
	});
</script>

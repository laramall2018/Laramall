<div class="col-md-9">

<div class="panel panel-default">
<div class="panel-heading">

	<h5>
    	<span class="glyphicon glyphicon-th-list"></span>
        <span class="tit">{!!trans('front.address_list')!!}</span>
    </h5>
 </div>

<div class="panel-body">
	<span class="btn btn-success add-address-btn" data-toggle="modal" data-target="#auth-address-model">
			<span class="glyphicon glyphicon-plus"></span>
			{!!trans('front.add_address')!!}
	</span>
	<table class="table table-bordered table-hover">

        <tr>
        	<th>{!!trans('front.id')!!}</th>
            <th>{!!trans('front.consignee')!!}</th>
            <th>{!!trans('front.email')!!}</th>
            <th>{!!trans('front.phone')!!}</th>
            <td>{!!trans('front.address')!!}</th>
            <th style="width:180px;">{!!trans('front.operation')!!}</th>
        </tr>

        @if($address_list)
        @foreach($address_list as $item)
        <tr>
           <td>{!!$item->id!!}</td>
           <td>{!!$item->consignee!!}</td>
           <td>{!!$item->email!!}</td>
           <td>{!!$item->phone!!}</td>
           <td>{!!$item->address!!}</td>
           <td>
              <a href="{!!url('auth/address/'.$item->id.'/edit')!!}" class="btn btn-primary">
                <span class="glyphicon glyphicon-pencil"></span>
                {!!trans('front.edit')!!}
              </a>
              <a href="{!!url('auth/address/delete/'.$item->id)!!}" class="btn btn-danger del-confirm"
								data-url="{!!url('auth/address/delete/'.$item->id)!!}"
								>
                  <i class="fa fa-times"></i>
                  {!!trans('front.delete')!!}
              </a>
           </td>
        </tr>
        @endforeach
        @endif
  </table>


	<!-- Modal -->
<div class="modal fade" id="auth-address-model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-body">
        @include('matrix.lib.user.address_form')
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

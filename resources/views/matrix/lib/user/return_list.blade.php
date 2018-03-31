<div class="col-md-9">

<div class="panel panel-default">
<div class="panel-heading">
	 
	<h5>
    	<span class="glyphicon glyphicon-th-list"></span>
        <span class="tit">{!!trans('front.order_return_list')!!}</span>
    </h5>
 </div>

<div class="panel-body">
    
    <div class="alert alert-info">
    <a href="{!!url('auth/return/send')!!}" class="btn btn-success">
    		<span class="glyphicon glyphicon-hand-up"></span>
    		申请退货
    </a>
    </div><!--/alert-->
    
	<table class="table table-bordered table-hover">
    	
        <tr>
        	<th style="width: 50px;">{!!trans('front.id')!!}</th>
        	<th>{!!trans('front.order_sn')!!}</th>
            <th>{!!trans('front.add_time')!!}</th>
            <th style="width:180px;">{!!trans('front.operation')!!}</th>
        </tr>
       
        @foreach($user->order_return()->get() as $item)
        <tr>
        	<td>{!!$item->id!!}</td>
            <td>{!!$item->order->order_sn!!}</td>
            <td>{{$item->time()}} </td>
            <td>
            	<a class="btn btn-success" href="{!!url('auth/return/preview/'.$item->id)!!}">
            	<i class="fa fa-eye"></i>
                查看
            	</a>
            	<a class="btn btn-danger del-confirm"
            		 data-url = "{!!url('auth/return/cancel/'.$item->id)!!}"
            		 href="{!!url('auth/return/cancel/'.$item->id)!!}">
                <i class="fa fa-times"></i>
                删除
                </a>
            </td>
        </tr>
        @endforeach
        
        
    
    </table>
    
    <div>
    	{!!$return_list->render()!!}
    </div>

</div><!--/panel-body-->
</div><!--/panel-->
</div><!--/col-md-9-->
<script type="text/javascript">
$(function(){
	front.confirm();
});
</script>

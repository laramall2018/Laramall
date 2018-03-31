
<div class="col-md-9">

<div class="panel panel-default">
<div class="panel-heading">
	 
	<h5>
    	<span class="glyphicon glyphicon-th-list"></span>
        <span class="tit">{!!trans('front.collect')!!}</span>
    </h5>
 </div>

<div class="panel-body">

	<table class="table table-bordered table-hover">
    	
        <tr>
        	<th>{!!trans('front.goods_name')!!}</th>
            <th>{!!trans('front.add_time')!!}</th>
            <th style="width:100px;">{!!trans('front.operation')!!}</th>
        </tr>
        @if($collect_goods)
        @foreach($collect_goods as $item)
        <tr>
        	<td>
            	<a href="{!!url('goods/'.$item->goods_id)!!}">
            	{!!$item->goods_name!!}
                </a>
            </td>
          
            <td><?php echo date('Y-m-d',$item->add_time);?></td>
            <td>
            	<a class="btn btn-danger btn-cancel" href="{!!url('auth/collect/del/'.$item->id)!!}">
                <i class="fa fa-times"></i>
                删除
                </a>
            </td>
        </tr>
        @endforeach
        @endif
        
    
    </table>
    
    <div>
    	{!!$collect_goods->render()!!}
    </div>

</div><!--/panel-body-->
</div><!--/panel-->
</div><!--/col-md-9-->



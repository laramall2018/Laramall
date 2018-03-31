@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<div class="container">
	<table class="table table-striped table-bordered table-hover test-tab">
	<tr>
		<th>方法</th>
		<th>名称</th>
		<th>路径</th>
		<th>控制器名称</th>
	</tr>
	@foreach($route_list as $item)

	
	<tr style="line-height:40px;">
			<td style="line-height:40px;">{!!$item->getMethods()[0]!!}</td>
			<td style="line-height:40px;">{!!$item->getName()!!}</td>
			<td style="line-height:40px;">{!!$item->getPath()!!}</td>
			<td style="line-height:40px;">{!!$item->getActionName()!!}</td>
	</tr>
	
	@endforeach
	</table>
</div>
@stop
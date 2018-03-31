@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />

   @include('matrix.lib.breadcrumb')
   
   @if($article_list)
   <div class="container">
   		<table class="table table-hover table-striped table-bordered">
        	<tr>
        		<th>编号</th>
            	<th>标题</th>
            	<th>作者</th>
            	<th>时间</th>
            	
             </tr>
             
             @foreach($article_list as $item)
             	<tr>
                	<td>{!!$item->id!!}</td>
                    <td><a href="{!!$item['url']!!}" target="_blank">{!!$item->title!!}</a></td>
                    <td>{!!$item->author!!}</td>
                    <td><?php echo date('Y-m-d',$item->add_time);?></td>
                </tr>
             @endforeach
        </table>
   </div>
   @endif
@stop
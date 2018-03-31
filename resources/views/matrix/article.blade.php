@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />

   @include('matrix.lib.breadcrumb')
   
   @if($article_info)
   <div class="container">
   		<h3 class="tit">
        	{!!$article_info->title!!}
            <small><?php echo date('Y-m-d',$article_info->add_time);?></small>
        </h3>
        <div class="content">
        	{!!$article_info->content!!}
        </div>
   </div>
   @endif
@stop
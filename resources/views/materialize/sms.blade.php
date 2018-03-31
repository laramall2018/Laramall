@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')

@include('materialize.lib.breadcrumb')

<div class="row">
<div class="col s12">
<a href="{{$back_url}}" class="btn offset-top10">返回</a>
<a href="{{url('auth/mobile/sms/create')}}" class="btn red offset-top10">添加</a>
<div class="card-panel">
		
		<ul class="collection">
		@foreach($user->sms()->paginate(20) as $sms)
   
		<li class="collection-item avatar">
      	<i class="material-icons circle green">insert_chart</i>
       
        
       <span class="title">
          <a href="{{url('auth/mobile/sms/'.$sms->id)}}">
          {{str_limit($sms->sms_content,20,'..')}}
          </a>
       </span>
      <p>
       
        {{$sms->post_time()}}<br>
      </p>

      <span  data-url="{{url('auth/mobile/sms/delete/'.$sms->id)}}"  class="btn-floating waves-effect waves-light grey secondary-content mobile-cancel-btn">
          <i class="material-icons left">clear</i>
      </span>
      
    </li>
   
		@endforeach
		</ul>

    {!!$user->sms()->paginate(20)->render()!!}
</div>
</div>
</div>

<script type="text/javascript">
        $(function(){

            front.mobile.dom_cancel();
        })
</script>


@stop
@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')

@include('materialize.lib.breadcrumb')

<div class="row">
<div class="col s12">
<a href="{{$back_url}}" class="btn offset-top10">返回</a>
<a href="{{url('auth/mobile/money/create')}}" class="btn red offset-top10">添加</a>
<div class="card-panel">
		
		<ul class="collection">
		@foreach($user->account()->paginate(20) as $account)
   
		<li class="collection-item avatar">
        <a href="{{url('auth/mobile/money/'.$account->id)}}">
      	<i class="material-icons circle green">insert_chart</i>
        </a>
       
       <span class="title">
          <a href="{{url('auth/mobile/money/'.$account->id)}}">{{$account->type()}}</a>
       </span>
      <p>
        <a href="{{url('auth/mobile/money/'.$account->id)}}">
        <strong class="red-text">￥{{$account->amount}}</strong>
        </a>
        <br>
        {{$account->pay_tag()}}<br>
        <small>{{$account->time()}}</small><br>
      </p>

      <span  data-url="{{url('auth/mobile/money/delete/'.$account->id)}}"  class="btn-floating waves-effect waves-light grey secondary-content mobile-cancel-btn">
          <i class="material-icons left">clear</i>
      </span>
      
    </li>
   
		@endforeach
		</ul>

    {!!$user->account()->paginate(20)->render()!!}
</div>
</div>
</div>

<script type="text/javascript">
        $(function(){

            front.mobile.dom_cancel();
        })
</script>


@stop
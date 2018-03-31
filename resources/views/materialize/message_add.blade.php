@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
	@include('materialize.lib.breadcrumb')
	
	<div class="row">
	<div class="col s12">
	<div class="card-panel">
		
		<div class="row"> 
		{!!Form::open(['url'=>'auth/mobile/message','method'=>'post','class'=>'col s12'])!!}
		
		 <div class="input-field col s12">
    		<select name="type">
      			<option value="" disabled selected>请选择</option>
      			<option value="留言">留言</option>
            <option value="意见">意见</option>
            <option value="建议">建议</option>
            <option value="评价">评价</option>
    		</select>
    		<label>请选择类型</label>
  		</div>

      <div class="input-field col s12">
        <select name="id_value">
            <option value="" disabled selected>请选择</option>
            @foreach(App\Models\Goods::all() as $goods)
            <option value="{{$goods->id}}">{{$goods->goods_name}}</option>
            @endforeach
        </select>
        <label>请选择类型</label>
      </div>

      <div class="input-field col s12">
      <input id="email" name="email" type="text" value="{{$user->email}}" class="validate">
      <label for="email">电子邮件</label>
      </div>

      <div class="input-field col s12">
        <textarea id="content" name="content" class="materialize-textarea"></textarea>
          <label for="content">留言内容</label>
      </div>

         

		   
       <div class="input-field col s12">
        <p>选择评论等级</p>
        <p>
        <input name="rank" type="radio" id="rank1" value="1" checked="true" />
        <label for="rank1">1</label>
        </p>
        
        <p>
        <input name="rank" type="radio" id="rank2" value="2" />
        <label for="rank2">2</label>
        </p>

        <p>
        <input name="rank" type="radio" id="rank3" value="3" />
        <label for="rank3">3</label>
        </p>

        <p>
        <input name="rank" type="radio" id="rank4" value="4" />
        <label for="rank4">4</label>
        </p>

        <p>
        <input name="rank" type="radio" id="rank5" value="5" />
        <label for="rank5">5</label>
        </p>
        </div>
       
       <input type="hidden" name="username" value="{{$user->username}}">
  		 <div class="input-field col s12">
  		 	<button type="submit" class="btn offset-top10">递交</button>
  		 	<a href=" {{$back_url}} " class="btn red offset-top10">返回</a>
  		 </div>

		{!!Form::close()!!}
		</div>

	</div>
	</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
    		$('select').material_select();
  		});
	</script>

@stop
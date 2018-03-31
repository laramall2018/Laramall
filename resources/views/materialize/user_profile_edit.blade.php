@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop
@section('content')

@include('materialize.lib.breadcrumb')
	
	<div class="row">
	<div class="col s12">
	<div class="card-panel"> 
	{!!Form::open(['url'=>'auth/mobile/profile','method'=>'post','files'=>true,'class'=>''])!!}
	 
   <div class="row">
   <div class="file-field input-field">
      <div class="btn">
        <span>上传头像</span>
        <input type="file" name="user_icon">
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate"  type="text" placeholder="上传头像">
      </div>
    </div>
    </div>

    @if($user->icon())
    <div class="row">
    <div class="input-field col s12">
      <img src="{{$user->icon()}}" class="responsive-img" style="width:80px;">
    </div>
    </div>
    @endif

		<div class="row">
        <div class="input-field col s12">
          <input disabled  id="username" name="username" value="{!!$user->username!!}" type="text" class="validate">
          <label for="username">会员名称</label>
    	</div>
    	</div>

    	<div class="row">
        <div class="input-field col s12">
          <input id="email" name="email" value="{!!$user->email!!}" type="email" class="validate">
          <label for="email">电子邮件</label>
    	</div>
    	</div>

    	<div class="row">
        <div class="input-field col s12">
          <input id="phone" name="phone" value="{!!$user->phone!!}" type="text" class="validate">
          <label for="email">手机</label>
    	</div>
    	</div>

      <div class="row">
        <div class="input-field col s12">
          <input id="nickname" name="nickname" value="{!!$user->nickname!!}" type="text" class="validate">
          <label for="nickname">昵称</label>
      </div>
      </div>
  

      <div class="row">
        <div class="input-field col s12">
          <input id="birthday" name="birthday" value="{!!$user->birthday!!}" type="text" class="validate">
          <label for="birthday">生日</label>
        </div>
      </div>
      

      <div class="row">
        <div class="input-field col s12">
          <input id="sfz" name="sfz" value="{!!$user->sfz!!}" type="text" class="validate">
          <label for="sfz">身份证</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <input id="password" name="password" value="" type="password" class="validate">
          <label for="sfz">新密码</label>
        </div>
      </div>

     <div class="row">
    <div class="input-field col s12">
    <select name="sex">
      <option value="" disabled>选择性别</option>
      <option @if($user->sex == 0) selected @endif value="0">男</option>
      <option @if($user->sex == 1) selected @endif value="1">女</option>
      <option @if($user->sex == 2) selected @endif value="2">保密</option>
    </select>
    <label>性别</label>
    <div>
    </div>

      <input type="hidden" name="id" value="{!!$user->id!!}">
      <input type="hidden" name="_method" value="PUT">
      <div class="row">
        <div class="input-field col s12">
           <button type="submit" class="btn blue">
             确认修改
           </button>
           <a href="{!!$back_url!!}" class="btn red">返回</a>
        </div>
      </div>




	{!!Form::close()!!}
	</div>
	</div>
	</div>

  <script type="text/javascript">
    
    $(document).ready(function() {
        $('select').material_select();
    });

  </script>

@stop
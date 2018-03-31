<div class="row">
<div class="col s12">
<div class="user-box z-depth-1">
		
		{!!Form::open(['url'=>'auth/register','method'=>'post','class'=>'register-form'])!!}

        <div class="input-field col s12">
          <input type="text" id="username" name="username" class="validate" value="{!!old('username')!!}">
          <label for="username">@if(!old('username')) {!!trans('front.username')!!}  @endif</label>
        </div>
        <div class="col s12"> 
        @if($errors->get('username'))
			<p class="red-text">{!!$errors->get('username')[0]!!}</p>
        @endif
        </div>
        <div class="input-field col s12">
          <input type="email" id="email" name="email" class="validate" value="{!!old('email')!!}">
          <label for="email">@if(!old('email')) {!!trans('front.email')!!} @endif</label>
        </div>
        <div class="col s12"> 
        @if($errors->get('email'))
			<p class="red-text">{!!$errors->get('email')[0]!!}</p>
        @endif
        </div>
        <div class="input-field col s12">
          <input type="password" id="password" name="password" class="validate">
          <label for="password">{!!trans('front.password')!!}</label>
        </div>
         <div class="col s12"> 
         @if($errors->get('password'))
			<p class="red-text">{!!$errors->get('password')[0]!!}</p>
         @endif
        </div>

        <div class="input-field col s12">
          <input type="password" id="password_confirmation" name="password_confirmation" class="validate">
          <label for="password">{!!trans('front.password_confirmation')!!}</label>
        </div>
        <div class="col s12"> 
        @if($errors->get('password_confirmation'))
			<p class="red-text">{!!$errors->get('password_confirmation')[0]!!}</p>
        @endif
        </div>
        
		<div class="input-field col s12">
			<input type="text" id="captcha" name="captcha" class="validate" value="{!!old('captcha')!!}">
          <label for="captcha">@if(!old('captcha')) {!!trans('front.captcha')!!} @endif</label>
		</div>
		<div class="col s12"> 
        @if($errors->get('captcha'))
			<p class="red-text">{!!$errors->get('captcha')[0]!!}</p>
        @endif
        </div>
		<div class="input-field captcha-img col s12">
				{!! captcha_img('flat') !!}
		</div>

        <div class="input-field col s12">
			<button class="waves-effect waves-light btn-large red accent-3 register-btn col s6" type="submit">
				<i class="material-icons left">check_circle</i>
				{!!trans('front.register')!!}
			</button>
			<a href="{!!url('auth/login')!!}" class="btn-large grey col s6">
			<i class="material-icons right">arrow_forward</i>
			{!!trans('front.login')!!}
			</a>
		</div>


        {!!Form::close()!!}


</div>
</div>     
</div><!--row-->

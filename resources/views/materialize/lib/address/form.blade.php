<div class="row">
	<div class="col s12">
		<div class="card-panel">
			{!!Form::open(['url'=>'mobile/address','method'=>'post','files'=>'true'])!!}

				<div class="row">
        		<div class="input-field col s12">
					<select name="country" id="country">
						<option value="1">中国</option>
					</select>
        		</div>
        		</div>

        		<div class="row">
        		<div class="input-field col s12">
					<select name="province" id="province" class="pcd-select" data-tag="city">
						<option value="">请选择</option>
						@foreach(App\Models\Region::province() as $province)
							<option value="{!!$province->region_id!!}">
									{!!$province->region_name!!}
							</option>
						@endforeach
					</select>
        		</div>
        		</div><!--row-->

        		@if($errors->get('province'))
				<p class="red-text">{!!$errors->get('province')[0]!!}</p>
        		@endif
        		
        		<div class="row">
        		<div class="input-field col s12">
					<select name="city" class="pcd-select" id="city" data-tag="district">

					</select>
        		</div>
        		</div>

        		@if($errors->get('city'))
				<p class="red-text">{!!$errors->get('city')[0]!!}</p>
        		@endif
        		
        		<div class="row">
        		<div class="input-field col s12">
					<select name="district" id="district">
						
					</select>
        		</div>
        		</div>

        		@if($errors->get('district'))
				<p class="red-text">{!!$errors->get('district')[0]!!}</p>
        		@endif

				<div class="row">
        		<div class="input-field col s12">
          			<input id="consignee" name="consignee" type="text" value="{!!old('consignee')!!}" class="validate">
          			<label for="consignee">收货人姓名</label>
        		</div>
        		</div>

        		@if($errors->get('consignee'))
				<p class="red-text">{!!$errors->get('consignee')[0]!!}</p>
        		@endif
				
				<div class="row">
        		<div class="input-field col s12">
          			<input id="email" name="email" type="text" value="{!!old('email')!!}" class="validate">
          			<label for="email">电子邮件</label>
        		</div>
        		</div>
        		@if($errors->get('email'))
				<p class="red-text">{!!$errors->get('email')[0]!!}</p>
        		@endif
				
				<div class="row">
        		<div class="input-field col s12">
          			<input id="phone" name="phone" type="text" value="{!!old('phone')!!}" class="validate">
          			<label for="phone">手机号码</label>
        		</div>
				</div>

				@if($errors->get('phone'))
				<p class="red-text">{!!$errors->get('phone')[0]!!}</p>
        		@endif

				<div class="row">
        		<div class="input-field col s12">
          			<input id="address" name="address" type="text" value="{!!old('address')!!}" class="validate">
          			<label for="address">收货地址</label>
        		</div>
				</div>

				@if($errors->get('address'))
				<p class="red-text">{!!$errors->get('address')[0]!!}</p>
        		@endif
				
				
				<div class="row">
				<div class="input-field col s12">
					<button type="submit" class="btn red">
					
				    {!!trans('front.submit')!!}
					</button>
					
					<a href="{!!url('checkout')!!}" class="btn">
						
						 {!!trans('front.back')!!}
					</a>
				</div>
				</div>

			{!!Form::close()!!}
		</div><!--/card-panel-->
	</div>
</div>
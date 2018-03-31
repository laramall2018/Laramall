

	<div class="form-bb">
         {!!Form::open(['url'=>'checkout-update-address','method'=>'post','class'=>'form-horizontal'])!!}
         	
            <div class="form-group">
            	<label class="control-label col-sm-3">{!!trans('front.diqu')!!}</label>
                <div class="col-sm-3">
                	<select name="province" id="province{!!$key!!}" class="form-control pcd-select" data-type="2" data-tag="city{!!$key!!}">
                    	<option value="0">{!!trans('front.select')!!}</option>
                        @if($province_list)
                        @foreach($province_list as $item2)
                        <option value="{!!$item2->region_id!!}" @if($item->province ==$item2->region_id) selected="selected"  @endif>{!!$item2->region_name!!}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-sm-3">
                	<select name="city" id="city{!!$key!!}" class="form-control pcd-select" data-type="3" data-tag="district{!!$key!!}">
                    	<option value="0">{!!trans('front.select')!!}</option>
                        <option value="{!!$item->city!!}" selected="selected">{!!$item['city_str']!!}</option>
                    </select>
                </div>
                <div class="col-sm-3">
                	<select name="district" id="district{!!$key!!}" class="form-control">
                    	<option value="0">{!!trans('front.select')!!}</option>
                        <option value="{!!$item->district!!}" selected="selected">{!!$item['district_str']!!}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-3">{!!trans('front.consignee')!!}</label>
                <div class="col-sm-9">
                	<input type="text" name="consignee" id="consignee" class="form-control" value="{!!$item->consignee!!}" />
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-3">{!!trans('front.email')!!}</label>
                <div class="col-sm-9">
                	<input type="text" name="email" id="email" class="form-control" value="{!!$item->email!!}" />
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-3">{!!trans('front.address')!!}</label>
                <div class="col-sm-9">
                	<input type="text" name="address" id="address" class="form-control" value="{!!$item->address!!}" />
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-3">{!!trans('front.phone')!!}</label>
                <div class="col-sm-9">
                	<input type="text" name="phone" id="phone" class="form-control" value="{!!$item->phone!!}" />
                </div>
            </div>
            <div class="form-group">
            	
                <div class="col-sm-9 col-sm-offset-3">
                		 
                         <input type="hidden" name="id" value="{!!$item->id!!}" />
                         <input type="submit" class="btn btn-success btn-lg" value="{!!trans('front.edit_submit')!!}"> 
                         <span class="btn btn-danger btn-lg address-btn-del" data-id="{!!$item->id!!}">
                         	<i class="fa fa-times"></i>
                            {!!trans('front.delete')!!}
                         </span>
                         <span class="btn btn-info btn-lg address-btn-def" data-id="{!!$item->id!!}">
                         	<i class="fa fa-cog"></i>
                            {!!trans('front.set_default_address')!!}
                         </span>
                </div>
                
            </div><!--/form-group-->
            
         {!!Form::close()!!}
      </div>
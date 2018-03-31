<!-- Modal Structure -->
  <div id="modal{!!$address->id!!}" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h5>编辑地址信息</h5>
	  
	  <div class="input-field col s12">
     	<select name="country">
      	<option value="1" selected="true">中国</option>
    	</select>
    	<label>国家</label>
     </div>

     <div class="input-field col s12">
     	<select name="province">
      	  @foreach(App\Models\Region::province() as $item)
		      <option value="{!!$item->region_id!!}" @if($item->region_id == $address->province)  selected="selected" @endif>{!!$item->region_name!!}</option>
      	  @endforeach
    	</select>
    	<label>省会</label>
     </div>
     <div class="input-field col s12">
      <select name="province">
         
      <option value="{!!$address->city!!}" selected="selected">{!!$address->city()!!}</option>
          
      </select>
      <label>城市</label>
     </div>

     <div class="input-field col s12">
      <select name="district">
         
      <option value="{!!$address->district!!}" selected="selected">{!!$address->district()!!}</option>
          
      </select>
      <label>区域</label>
     </div>


      <div class="input-field col s12">
          <input placeholder="收货人姓名" id="consignee{!!$address->id!!}" name="consignee" value="{!!$address->consignee!!}" type="text" class="validate">
          <label for="consignee{!!$address->id!!}">收货人姓名</label>
      </div><!--input-field-->
      <div class="input-field col s12">
          <input placeholder="电子邮件" id="email{!!$address->id!!}" value="{!!$address->email!!}" type="email" class="validate">
          <label for="email{!!$address->id!!}">电子邮件</label>
      </div><!--input-field-->
      <div class="input-field col s12">
          <input placeholder="手机号码" id="phone{!!$address->id!!}" value="{!!$address->phone!!}" type="text" class="validate">
          <label for="phone{!!$address->id!!}">手机号码</label>
      </div><!--input-field-->
      <div class="input-field col s12">
          <input placeholder="地址信息" id="address_{!!$address->id!!}" value="{!!$address->address!!}" type="text" class="validate">
          <label for="address_{!!$address->id!!}">收货地址</label>
      </div><!--input-field-->
    </div>
    <div class="modal-footer">
    
      	<span class="modal-action modal-close waves-effect waves-green btn blue address-edit-btn ">
      		<i class="material-icons">mode_edit</i>
      		编辑
      	</span>
      	<span class="modal-action modal-close waves-effect waves-green btn red address-del-btn">
	   <i class="material-icons">clear</i>
      	删除
      	</span>
	</div>

  </div>
<!--end Modal -->
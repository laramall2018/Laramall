
<form class="form-horizontal" role="form">
  <div class="form-group">
    <label for="consignee" class="col-sm-2 control-label">收货姓名</label>
    <div class="col-sm-10">
      <input type="text" 
             class="form-control" 
             v-bind:id="'consignee'+ address.id" 
             v-bind:name="'consignee'+address.id" 
             v-model="address.consignee">
    </div>
  </div><!--/form-group-->
  
  <div class="form-group">
    <label for="phone" class="col-sm-2 control-label">手机号码</label>
    <div class="col-sm-10">
      <input type="text" 
             class="form-control" 
             v-bind:id="'phone'+address.id" 
             v-bind:name="'phone'+address.id" 
             v-model="address.phone">
    </div>
  </div><!--/form-group-->

  <div class="form-group">
    <label class="col-sm-2 control-label">城市地区</label>
    <div class="col-sm-4">
    	<select  v-bind:name="'province'+address.id"
    			 v-bind:id="'province'+address.id"
    			 v-on:change="pcd"
    	         class="form-control">
    	  
    	    <option v-model="region.region_id"
    	    		v-if="address.province == region.region_id"
    	    		selected="true" 
    	    	    v-for="region in rows.province_list">
    	    	   @{{region.region_name}}
    	    </option>
    	    <option v-model="region.region_id"
    	    		v-else
    	    		v-for="region in rows.province_list">
    	    	   @{{region.region_name}}
    	    </option>
    	    
    	</select>	
    </div>
    <div class="col-sm-3">
    	<select v-bind:name="'city'+address.id"
    	        v-bind:id="'city'+ address.id"
    		    v-on:change="pcd"
    			class="form-control">
    		<option v-model="address.city"
    				v-if="rows.city_list.length == 0"
    			    selected="true">@{{address.cityName}}</option>
    		<option v-model="region.region_id" v-for="region in rows.city_list">
    	    	@{{region.region_name}}
    	    </option>
    	    <option value="0">请选择</option>
    	</select>	
    </div>
    <div class="col-sm-3">
    	<select v-bind:name="'district'+address.id"
    			v-bind:id="'district'+address.id"
    	        class="form-control">
    		<option v-model="address.district" 
    				v-if="rows.district_list.length == 0"
    				selected="true">@{{address.districtName}}</option>
    		<option v-model="region.region_id" v-for="region in rows.district_list">
    	    	@{{region.region_name}}
    	    </option>
    	</select>	
    </div>
  </div><!--/form-group pcdapp-->


  <div class="form-group">
    <label for="address" class="col-sm-2 control-label">详细地址</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" 
      		v-bind:id="'address'+address.id" 
      		v-bind:name="'address'+address.id" 
      		v-model="address.address">
    </div>
  </div><!--/form-group-->

  <div class="form-group">
    <label  class="col-sm-2 control-label">默认地址</label>
    <div class="col-sm-10">
      <span class="checked-btn" 
      		v-bind:class="{'checked-on':address.isDefault}"
      	    v-on:click="setDefault(address)"></span>
    </div>
  </div><!--/form-group-->


</form>
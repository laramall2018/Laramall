<form class="form-horizontal" role="form">
  <div class="form-group">
    <label for="consignee" class="col-sm-2 control-label">收货姓名</label>
    <div class="col-sm-10">
      <input type="text" class="form-control"  id="consignee" name="consignee">
    </div>
  </div><!--/form-group-->

  <div class="form-group">
    <label for="phone" class="col-sm-2 control-label">手机号码</label>
    <div class="col-sm-10">
      <input type="text"  class="form-control" id="phone" name="phone">
    </div>
  </div><!--/form-group-->

  <div class="form-group">
    <label class="col-sm-2 control-label">城市地区</label>
    <div class="col-sm-4">
      <select  name="province" id="province" v-on:change="pcd"  class="form-control">
          <option v-model="region.region_id" v-for="region in rows.province_list">
               @{{region.region_name}}
          </option>
      </select> 
    </div>
    <div class="col-sm-3">
      <select name="city" id="city" v-on:change="pcd" class="form-control">
          <option v-model="region.region_id" v-for="region in rows.city_list">
            @{{region.region_name}}
          </option>
          <option value="0">请选择</option>
      </select> 
    </div>
    <div class="col-sm-3">
        <select name="district" id="district" class="form-control">
        <option v-model="region.region_id" v-for="region in rows.district_list">
            @{{region.region_name}}
          </option>
      </select> 
    </div>
  </div><!--/form-group pcdapp-->

  <div class="form-group">
    <label for="address" class="col-sm-2 control-label">详细地址</label>
    <div class="col-sm-10">
      <input type="text"  class="form-control" id="address" name="address">
    </div>
  </div><!--/form-group-->

</form>

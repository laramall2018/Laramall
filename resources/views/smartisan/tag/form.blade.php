<form class="form-horizontal" role="form">
  <div class="form-group">
    <label for="consignee" class="col-sm-2 control-label">标签名称</label>
    <div class="col-sm-10">
      <input type="text" class="form-control"  v-model="tag_name">
    </div>
  </div><!--/form-group-->

  <div class="form-group">
    <label class="col-sm-2 control-label">商品名称</label>
    <div class="col-sm-4">
      <select v-model="goods_id"  class="form-control">
         
         <option value="0">请选择</option>
         <option v-bind:value="goods.id" 
                 v-for="goods in rows.goods_list">@{{goods.goods_name}}
         </option>
      </select> 
    </div>
  </div><!--/form-group pcdapp-->

  <div class="form-group">
    <label for="consignee" class="col-sm-2 control-label">排序</label>
    <div class="col-sm-10">
      <input type="text" class="form-control"  v-model="sort_order">
    </div>
  </div><!--/form-group-->
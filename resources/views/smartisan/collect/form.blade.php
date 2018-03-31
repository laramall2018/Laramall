<form class="form-horizontal" role="form">

  <div class="form-group">
    <label for="consignee" class="col-sm-2 control-label">商品</label>
    <div class="col-sm-10">
      <select v-model="goods_id" class="form-control">
         <option value="">请选择</option>
         @foreach(App\Models\Goods::all() as $goods)
         <option value="{{$goods->id}}">{{$goods->goods_name}}</option>
         @endforeach
      </select>
    </div>
  </div><!--/form-group-->
</form><!--/form-->

  

<div class="cat-select-list">

<div class="attr-list" id="selected-btn-list">
	<div class="row">
        <div class="col-md-12">
        <span class="item active-item"
              v-on:click="priceGradeDel"
              v-if="rows.min >0 && rows.max > 0">
            @{{rows.min}} - @{{rows.max}}
            <i class="fa fa-times"></i>
        </span>

        <span class="item active-item"
              v-on:click="brandDel"
              v-if="rows.brand_id > 0">
            @{{rows.brand_name}}
            <i class="fa fa-times"></i>
        </span>

        <span  class="item active-item"
               v-on:click="attrDel(goods_attr.id)"
               v-for="goods_attr in rows.goods_attrs">
           @{{goods_attr.attrName}}:@{{goods_attr.attr_value}}
           <i class="fa fa-times"></i>
        </span>
        
        <span  class="item active-item"
               v-on:click="fieldDel(goods_field.id)"
               v-for="goods_field in rows.goods_fields">
           @{{goods_field.field_name}}:@{{goods_field.field_value}}
           <i class="fa fa-times"></i>
        </span>

        </div><!--/col-md-10-->
    </div><!--/row-->
</div><!--/attr_list-->

<div class="attr-list" v-if="rows.price">
	<div class="row">
    	<div class="col-md-1">
        	<span class="tit">价格</span>
        </div><!--/col-md-2-->
        <div class="col-md-10">
        <span  class="item price-item"
               v-on:click="priceGrade(0,0,$event)"
               data-min="0" data-max="0">所有</span>
        
        	<span class="item price-item" 
                  v-for="price in rows.price" v-on:click="priceGrade(price.min,price.max,$event)">
            @{{price.min}} - @{{price.max}}
            </span>

        </div><!--/col-md-10-->
    </div><!--/row-->
</div><!--/attr_list-->



<div class="attr-list" v-if="rows.brand">
    <div class="row">
        <div class="col-md-1">
            <span class="tit">{!!trans('front.brand')!!}</span>
        </div><!--/col-md-2-->
        <div class="col-md-10">
            <span class="item brand-item"
                  v-on:click="changeBrand(0,'',$event)"
                  data-brand_id="0">所有</span>
        
            <span class="item brand-item" 
                  v-for="brand in rows.brand"
                  v-bind:data-brand_name="brand.brand_name"
                  v-bind:data-brand_id="brand.id" 
                  v-on:click="changeBrand(brand.id,brand.brand_name,$event)">
                  @{{brand.brand_name}}
            </span>
       
            
        </div><!--/col-md-10-->
    </div><!--/row-->
</div><!--/attr_list-->



<div class="attr-list" v-for="attr in rows.attr">
	<div class="row">
    	<div class="col-md-1">
        	<span class="tit" v-bind:attr_id="attr.id">@{{attr.attr_name}}</span>
        </div><!--/col-md-2-->
        <div class="col-md-10">
            <span class="item attr-item"
                v-bind:data-goods_attr_id="0"
                v-on:click="changeAttr(0,$event)"
                >
             	所有
           </span>
        	
        	<span class="item attr-item" 
                v-for="value in attr.attr_value"
            	  v-bind:data-goods_attr_id="value.id"
                v-bind:id="['goods-attr-'+value.id]"
                v-on:click="changeAttr(value.id,$event)" 
                >
             	@{{value.attr_value}}
           </span>
           
        </div><!--/col-md-10-->
    </div><!--/row-->
</div><!--/attr_list-->


<div class="attr-list" v-for="field in rows.field">
  <div class="row">
      <div class="col-md-1">
          <span class="tit" v-bind:field_id="field.id">@{{field.field_name}}</span>
        </div><!--/col-md-2-->
        <div class="col-md-10">
            <span class="item field-item"
                v-bind:data-goods_field_id="0"
                v-on:click="changeField(0,$event)"
                >
              所有
           </span>
          
          <span class="item field-item" 
                v-for="value in field.field_value"
                v-bind:data-goods_field_id="value.id"
                v-bind:id="['goods-field-'+value.id]"
                v-on:click="changeField(value.id,$event)" 
                >
              @{{value.field_value}} 
           </span>
           
        </div><!--/col-md-10-->
    </div><!--/row-->
</div><!--/attr_list-->





</div>
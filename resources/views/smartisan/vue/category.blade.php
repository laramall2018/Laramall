<script type="text/javascript">

    $(function(){
		larastore.goods.gallery();
	})

	var catapp = new Vue({

		  el:'#catapp',
		  data:{

		  			rows:[],

		  },
		  created:function(){

		  	 this.getList();
		  },
		  
		  methods:{

		  		//获取商品记录
		  		getList:function(){

		  			$.ajax({
		  				url:"{{url('api/category/'.$id)}}",
		  				type:'GET',
		  				dataType:'json',
		  				success:function(data){
		  					 catapp.rows 	= data.data;

		  				}
		  			});
		  		},

		  		//加入购物车
		  		addCart:function(id){

		  			$.ajax({

		  				url:"{{url('api/cart/add')}}",
		  				type:'POST',
		  				data:'id='+ id,
		  				dataType:'json',
		  				success:function(data){
		  					var content  = data.data;
		  					if(content.tag == 'error'){

		  						swal({
		  							title:"错误提示",
		  							text:content.info,
		  							html:true
		  						});
		  						return false;
		  					}

		  					if(content.tag == 'success'){
		  						swal("成功添加","您已经成功添加商品到购物车","success");
		  					}

		  					cartapp.rows 	= content;
		  				}
		  			})
		  		},

		  		//选择价格区间
		  		priceGrade:function(min,max,event){

		  			var  that 			= event.currentTarget;
		  			$(that).addClass('active-item').siblings('.price-item').removeClass('active-item');
		  			catapp.rows.min 	= min;
		  			catapp.rows.max		= max; 
		  			//执行ajax
		  			this.doAjax();
		  		},
		  		//清除价格区间
		  		priceGradeDel:function(){
		  			$('.cat-select-list .price-item').removeClass('active-item');
		  			catapp.rows.min 	= 0;
		  			catapp.rows.max 	= 0;
		  			//执行ajax
		  			this.doAjax();
		  		},

		  		//选择品牌
		  		changeBrand:function(brand_id,brand_name,event){
		  			var that 				= event.currentTarget;
		  			$(that).addClass('active-item').siblings('.brand-item').removeClass('active-item');
		  			catapp.rows.brand_id     = brand_id;
		  			catapp.rows.brand_name 	 = brand_name;
		  			this.doAjax();
		  		},
		  		//清空已经被选中的品牌
		  		brandDel:function(){
		  		   $('.cat-select-list .brand-item').removeClass('active-item');
		  		   catapp.rows.brand_id 	 = 0;
		  		   catapp.rows.brand_name 	 = '';
		  		   this.doAjax();
		  		},

		  		//选择商品属性
		  		changeAttr:function(goods_attr_id,event){
		  			var that 						= event.currentTarget;
		  			$(that).addClass('active-item').siblings('.attr-item').removeClass('active-item');
		  			
		  			//获取所有被选中的属性组
		  			var   goods_attr_ids 			= this.getGoodsAttrIds();
		  			catapp.rows.goods_attr_ids 		= goods_attr_ids;

		  			//执行ajax
		  			this.doAjax();
		  		},

		  		//筛选规格
		  		changeField:function(goods_field_id,event){

		  			var that 						= event.currentTarget;
		  			$(that).addClass('active-item').siblings('.field-item').removeClass('active-item');
		  			
		  			//获取所有被选中的属性组
		  			var   goods_field_ids 			= this.getGoodsFieldIds();
		  			catapp.rows.goods_field_ids 	= goods_field_ids;

		  			//执行ajax
		  			this.doAjax();
		  		},

		  		//删除选中的属性
		  		attrDel:function(goods_attr_id){

		  			$('#goods-attr-'+goods_attr_id).removeClass('active-item');
		  			//获取所有被选中的属性组
		  			var   goods_attr_ids 			= this.getGoodsAttrIds();
		  			catapp.rows.goods_attr_ids 		= goods_attr_ids;
		  			this.doAjax();
		  		},

		  		//删除选中的规格
		  		fieldDel:function(goods_field_id){

		  			$('#goods-field-'+goods_field_id).removeClass('active-item');
		  			//获取所有被选中的属性组
		  			var   goods_field_ids 			= this.getGoodsFieldIds();
		  			catapp.rows.goods_field_ids 	= goods_field_ids;
		  			this.doAjax();
		  		},

		  		//排序
		  		orderBy:function(event){
		  			var 	that 				= event.currentTarget;
		  			$(that).addClass('btn-success').siblings('.sort-btn').removeClass('btn-success');
		  			var     sort_name 			= $(that).data('sort_name');
		  			var     sort_value 			= catapp.rows.sort_value;

		  			
		  			if(sort_value == 'asc'){
		  				
		  					temp_sort_value 	= 'desc';
		  			}
		  			
		  			if(sort_value == 'desc'){

		  					temp_sort_value 	= 'asc';
		  			}

		  			catapp.rows.sort_value 		= temp_sort_value;
		  			catapp.rows.sort_name 		= sort_name;

		  			//执行ajax
		  			this.doAjax();
		  		},

		  		//分页
		  		changePage:function(page){

		  			catapp.rows.page.current_page = page;
		  			//执行ajax
		  			this.doAjax();

		  		},

		  		//执行ajax
		  		doAjax:function(){

		  			//获取参数
		  			var param 		= this.getParam();
		  			//执行ajax操作
		  			$.ajax({

		  				type:'POST',
		  				url:"{{url('api/category/grid')}}",
		  				data:'param=' + $.toJSON(param),
		  				dataType:'json',
		  				success:function(data){
		  					var  content 			    = data.data;
		  					//更新需要刷新的数据
		  					catapp.rows.goods_attrs 	= content.goods_attrs;
		  					catapp.rows.goods_fields 	= content.goods_fields;
		  					catapp.rows.goods_list 		= content.goods_list;
		  					catapp.rows.page 			= content.page;
		  					catapp.rows.number 			= content.number;
		  					catapp.rows.current_page 	= content.current_page;
		  					catapp.rows.per_page 		= content.per_page;
		  					catapp.rows.last_page 		= content.last_page;
		  					catapp.rows.total 			= content.total;
		  				}
		  			});
		  		},

		  		//获取参数
		  		getParam:function(){

		  			var  info 					= {};
		  				 info.cat_id 	  		= catapp.rows.cat_id;
		  				 info.brand_id 			= catapp.rows.brand_id;
		  				 info.min 				= catapp.rows.min;
		  				 info.max 				= catapp.rows.max;
		  				 info.sort_name 	    = catapp.rows.sort_name;
		  				 info.sort_value 		= catapp.rows.sort_value;
		  				 info.goods_attr_ids 	= catapp.rows.goods_attr_ids;
		  				 info.current_page 		= catapp.rows.page.current_page;
		  				 info.goods_field_ids   = catapp.rows.goods_field_ids;

		  			return info;
		  		
		  		},

		  		//获取被选中的商品属性值编号
		  		getGoodsAttrIds:function(){

		  			var  goods_attr_ids 	 = new Array();
		  			var  attr_item           = $('.cat-select-list .attr-item');
		  			$.each(attr_item,function(i,item){

         				if($(item).hasClass('active-item')){
              				
              				var goods_attr_id   = $(item).data('goods_attr_id');
                  				goods_attr_id   = parseInt(goods_attr_id);

                  				if(goods_attr_id > 0)
                  				{ 
                    				goods_attr_ids.push(goods_attr_id);
                  				}
         				}
    				});

    				return goods_attr_ids;
		  		},

		  		//获取被选中的商品属性值编号
		  		getGoodsFieldIds:function(){

		  			var  goods_field_ids 	 = new Array();
		  			var  field_item          = $('.cat-select-list .field-item');
		  			$.each(field_item,function(i,item){

         				if($(item).hasClass('active-item')){
              				
              				var goods_field_id   = $(item).data('goods_field_id');
                  				goods_field_id   = parseInt(goods_field_id);

                  				if(goods_field_id > 0)
                  				{ 
                    				goods_field_ids.push(goods_field_id);
                  				}
         				}
    				});

    				return goods_field_ids;
		  		},
		  },
	});
</script>
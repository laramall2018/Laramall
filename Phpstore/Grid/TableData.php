<?php namespace Phpstore\Grid;

	/*
    |-------------------------------------------------------------------------------
	|
	|    根据给定的参数 从数据库中检索数据
	| 	 fieldRow搜索数组 	 	搜索键值组合 等于搜索 ['brand_id'=>0 ,'is_new'=>1]
	|    keywords               搜索关键词 like搜索
	|    whereIn                whereIn搜索 比如： whereIn('cat_id',[1,2,4,5])
	|	 sort_name  			排序名称	比如：goods_id
	|    sort_value  			排序值   比如：desc
	|    Page类的实例  			page类似的实例为分页
	| 	 table 					对应数据表
	| 	 col数组 				数据表中需要显示的数据字段
	|
	|-------------------------------------------------------------------------------
	|
	|	page($key,$value)						给分页实例赋值
	|   put($key,$value)						给对象赋值
	|   get($key)	    						获取对象的值
	|   addField($field_name,$field_value)		设置等于搜索关键字字段和值
	|   addCol 								    设置数据库中需要显示的数据字段
	|   keywords($field_name , $keywords)  		设置like搜索关键词
	|   whereIn($in_field , array $in_value)    设置whereIn搜索关键词字段和值
	|   total()  								获取记录总数
	|   data() 									获取根据搜索参数返回的数据记录
	|   toArray() 								把对象格式的数据转化成数组格式
	|
	|-------------------------------------------------------------------------------
	*/
	class TableData{

		protected $sort_name;
		protected $sort_value;
		protected $keywords  = [];
		protected $in_field;
		protected $in_value;
		protected $page;
		protected $fieldRow  = [];
		protected $table;
		protected $col 		 = [];
		protected $data;
		


		/*
		|----------------------------------------------------------------------------
		|
		| 构造函数
		|
		|----------------------------------------------------------------------------
		*/  
		function __construct(){


			$this->page 	=  new Page();

		}



		/*
		|----------------------------------------------------------------------------
		|
		|  为page实例 设置参数
		|
		|----------------------------------------------------------------------------
		*/
		public function page($key , $value){

			$this->page->put($key , $value);

		}


		/*
		|----------------------------------------------------------------------------
		|
		| 设置参数
		|
		|----------------------------------------------------------------------------
		*/
		public function put($key , $value){

			$this->$key 	= $value;
		}


		/*
		|----------------------------------------------------------------------------
		|
		| 获取类的属性值
		|
		|----------------------------------------------------------------------------
		*/
		public function get($key){

			if($this->$key){

				return $this->$key;
			}
			else{

				return '';
			}
		}


		/*
		|----------------------------------------------------------------------------
		|
		| 设置搜索字段数组
		|
		|----------------------------------------------------------------------------
		*/
		public function addField($field_name , $field_value){

			$row 			= ['field_name'=>$field_name , 'field_value'=>$field_value];
			$this->fieldRow[] 	= $row;
		}

		/*
    	|-------------------------------------------------------------------------------
		|
		|  设置col数组
		|
		|-------------------------------------------------------------------------------
		*/
		public function addCol($name ,$alias_name , $value , $width, $tag = 1){

			$row 	= [	
							'col_name'		=>$name , 
							'alias_name'	=>$alias_name , 
							'col_value' 	=>$value , 
							'width'			=>$width ,
							'tag'			=>$tag 
					  ];

			$this->col[] 	= $row; 

		}


		/*
		|----------------------------------------------------------------------------
		|
		| 设置搜索关键字数组
		|
		|----------------------------------------------------------------------------
		*/
		public function  keywords($field_name , $keywords){

			$row 					= ['field_name'=>$field_name , 'keywords'=>$keywords];
			$this->keywords[]   	= $row;
		}


		/*
		|----------------------------------------------------------------------------
		|
		| 设置whereIn数组
		|
		|----------------------------------------------------------------------------
		*/
		public function whereIn($in_field , array $in_value){

			$this->in_field 		= $in_field;
			$this->in_value 		= $in_value;
		}



		/*
		|----------------------------------------------------------------------------
		|
		| 获取总数据 用查询构造器
		|
		|----------------------------------------------------------------------------
		*/
		public function total(){

			$query 		= \DB::table($this->table);
            
            //组合搜索  等于搜索
			foreach($this->fieldRow as $key=>$value){

				if($value['field_value'] !== ''){

					$query  = $query->where($value['field_name'] , $value['field_value']);
				}
			}

			//关键字 like搜索
			foreach($this->keywords as $k=>$v){

				if($v['keywords']){

					$query  = $query->where($v['field_name'],'like','%'.$v['keywords'].'%');
				}
			}

			//whereIn 搜索
			$count 	= count($this->in_value);

			if($count == 1){

				$query  = $query->where($this->in_field , $this->in_value[0]);
			}
			elseif($count > 1){

				$query = $query->whereIn($this->in_field , $this->in_value);
			}

			$total 		= $query->count();

			return $total;
		}



		/*
		|----------------------------------------------------------------------------
		|
		| 获取数据
		|
		|----------------------------------------------------------------------------
		*/
		public function data(){

			$sort_name 					= $this->sort_name;
			$sort_value 				= $this->sort_value;

			$skip_num       			= '';
        	$data           			= '';

        	$total          			= $this->total();
        	$current_page   			= $this->page->get('current_page');
        	$per_page 					= $this->page->get('per_page');

        	$last_page      			= ceil($total / $per_page );

        	if($current_page <= $last_page ){

            		$skip_num       = ($current_page - 1)* $per_page ;
        	}
        	else{

            		$skip_num       = 0;
            		$current_page   = 1;
        	}

        	$query 		= \DB::table($this->table);


        	foreach($this->fieldRow as $value){

        		if($value['field_value'] !== ''){

        			$query		 = $query->where($value['field_name'] , $value['field_value']);
        		}

        	}

        	foreach($this->keywords as $k=>$v){

				if($v['keywords']){

					$query  = $query->where($v['field_name'],'like','%'.$v['keywords'].'%');
				}
			}

			//whereIn 搜索
			$count 	= count($this->in_value);
			
			if($count == 1){

				$query  = $query->where($this->in_field , $this->in_value[0]);
			}
			elseif($count > 1){

				$query = $query->whereIn($this->in_field , $this->in_value);
			}


        	$data 	    = $query->orderBy($sort_name , $sort_value)->skip($skip_num)->take($per_page)->get();

        	return $data;

		}


		/*
		|----------------------------------------------------------------------------
		|
		| 把对象格式的数据 转化成数组
		|
		|----------------------------------------------------------------------------
		*/
		public function toArray(){

			$data 		= $this->data();

			if(empty($data)){

				return '';
			}

			$row 	    = [];

			foreach($data as $key=>$value){

			
				foreach($this->col as $item){

					$col_name 							= $item['col_name'];

					$row[$key][$col_name]  				= $value->$col_name;
				}

			}

			return $row;
		}
	}

<?php namespace Phpstore\Grid;
use \URL;
use \View;
use \Hash;
use \Auth;
use \Lang;
use \Input;
use \Response;
use \Redirect;
use \Password;
use \Session;
use \HTML;
use \DB;


	/*
    |-------------------------------------------------------------------------------
	|
	|  phpstore 全新的grid系统
	|  返回json格式数据
	|  输出页面第一次加载的整体table数据
	|
	|-------------------------------------------------------------------------------
	|
	|  tableData 						为tableData类的实例
	|  put($key,$value)					为对象设置值
	|  get($key)						获取值
	|  links() 							输出分页信息
	|  total()   						输出总记录
	|  col() 							获取数据表中要显示的数据字段列表
	|  page() 							分页的基本信息数组
	|  data() 							获取查询所得数据信息
	|  render() 						输出json格式的数据信息
	|  table() 							输出第一次加载页面时候的表格数据信息
	|  portlet() 						输出带样式的portlet信息
	|  th() 							table()的辅助函数 th_first() + th_item()
	|  th_first()						table()的辅助函数 输出第一个th
	|  th_item() 					    table()的辅助函数 输出普通的th元素
	|  body() 							table()的辅助函数 输出主要数据内容 td
	|  td_first() 						table()的辅助函数 输出第一个td （编号选择）
	|  td_last_link() 					table()的辅助函数 输出操作的链接
	|  td_last_preview_link() 			table()的辅助函数 输出带预览链接的操作
	|
	|-------------------------------------------------------------------------------
	*/
	class Grid{


	    protected $tableData;




		/*
    	|-------------------------------------------------------------------------------
    	|
    	| 构造函数
    	|
    	|-------------------------------------------------------------------------------
    	*/
    	function __construct(TableData $tableData){

    		$this->tableData 		= $tableData;

    	}


    	/*
    	|-------------------------------------------------------------------------------
    	|
    	|  给grid设置值
    	|
    	|-------------------------------------------------------------------------------
    	*/
    	public function put($key , $value){

    		$this->$key  	= $value;
    	}



    	/*
    	|-------------------------------------------------------------------------------
    	|
    	|  获取grid类的值
    	|
    	|-------------------------------------------------------------------------------
    	*/
    	public function get($key){

    		return $this->$key;
    	}




    	/*
    	|-------------------------------------------------------------------------------
		|
		|   输出分页信息
		|
		|-------------------------------------------------------------------------------
		*/

		public function links(){

			return $this->tableData->get('page')->links();
		}




		/*
    	|-------------------------------------------------------------------------------
		|
		|   输出总记录数
		|
		|-------------------------------------------------------------------------------
		*/

		public function total(){

			return $this->tableData->total();
		}


		/*
    	|-------------------------------------------------------------------------------
		|
		|   获取显示数据的字段列表
		|
		|-------------------------------------------------------------------------------
		*/
		public function col(){

			return $this->tableData->get('col');
		}


		/*
    	|-------------------------------------------------------------------------------
		|
		|   获取分页的详细信息
		|
		|-------------------------------------------------------------------------------
		*/
		public function page(){


			$row 		= [
						     'current_page'		=> $this->tableData->get('page')->get('current_page'),
						     'per_page'			=> $this->tableData->get('page')->get('per_page'),
						     'last_page'		=> $this->tableData->get('page')->get('last_page'),
						     'total'			=> $this->tableData->get('page')->get('total')
						  ];

			return $row;
		}


		/*
    	|-------------------------------------------------------------------------------
		|
		|   输出总的数据
		|
		|-------------------------------------------------------------------------------
		*/
		public function data(){

			return $this->tableData->get('data');
		}



		/*
    	|-------------------------------------------------------------------------------
		|
		|   输出相应的json信息
		|
		|-------------------------------------------------------------------------------
		*/
		public function render(){

			$row 						= [];
			$row['data']				= $this->data();
			$row['col']					= $this->tableData->get('col');
			$row['sort_name'] 			= $this->tableData->get('sort_name');
			$row['sort_value'] 			= $this->tableData->get('sort_value');
			$row['fieldRow'] 			= $this->tableData->get('fieldRow');
			$row['keywords'] 			= $this->tableData->get('keywords');
			$row['page']  				= $this->page();
			$row['links'] 				= $this->links();
			$row['in_field'] 			= $this->tableData->get('in_field');
			$row['in_value'] 		    = $this->tableData->get('in_value');

			return  json_encode($row,JSON_UNESCAPED_UNICODE);
		}


		/*
    	|-------------------------------------------------------------------------------
		|
		|   输出第一次加载的表格内容
		|
		|-------------------------------------------------------------------------------
		*/
		public function table(){



		     $table  = '<table  class="table table-striped table-bordered table-hover ajax-sort-tab">';

		     $table  .= $this->th();
		     $table  .= $this->body();

		     $table  .= '</table>';

		     return $table;

		}



		/*
    	|-------------------------------------------------------------------------------
		|
		|   输出带portlet box样式的表格
		|
		|-------------------------------------------------------------------------------
		*/
		public function portlet(){

			$str  	= 	'<div class="panel panel-primary '.$this->color.'" >'
					   .'<div class="panel-heading">'
					   .'<div class="caption">'
					   .'<i class="fa fa-cogs"></i>'
					   .$this->action_name
					   .'</div>'
					   .'</div>'
					   .'<div class="panel-body">'
					   .'<div class="table-scrollable">'
					   .$this->table()
					   .'</div>'
					   .'</div>'
					   .'</div>';

			return $str;
		}


		/*
    	|-------------------------------------------------------------------------------
		|
		|   输出初始加载的表格数据的 th部分
		|
		|-------------------------------------------------------------------------------
		*/

		public function th(){

			$th ='<tr>'
				  .'<th scope="col" class="tit" style="width:50px;">'
				  .'<input class="icheck mycheckbox checkbox" type="checkbox" name="select_all" />'
				  .'</th>';


			foreach($this->col() as $key=>$item){

				//如果是要显示的第一个元素 比如 id, attr_id之类的
				if($key == 0){

					$th .= $this->th_first();
				}
				else{

					$th .= $this->th_item($item['col_name'],$item['col_value'],$item['width']);
				}
			}

			$th .= '<th scope="col" class="tit" style="width:250px;">相关操作</th>';
			$th .= '</tr>';

			return $th;
		}

		/*
    |-------------------------------------------------------------------------------
		|
		|   输出初始加载的表格数据的 th_first();
		|
		|-------------------------------------------------------------------------------
		*/

		public function th_first(){

			$th  = '<th scope="col" class="tit active" data-sort_name="'.$this->col()[0]['col_name'].'" data-sort_value="asc" style="width:'.$this->col()[0]['width'].'">'
               	   .'<span class="ajax-sort">'.$this->col()[0]['col_value'].'</span>'
               	   .'<i class="fa fa-sort-desc"></i>'
            	   .'</th>';

            return $th;
		}


		/*
    	|-------------------------------------------------------------------------------
		|
		|   输出初始加载的表格 th的主要部分
		|
		|-------------------------------------------------------------------------------
		*/
		public function th_item($col_name , $col_value , $width){



			$th  = '';

			$th  .= '<th scope="col" class="tit" data-sort_name="'.$col_name .'" data-sort_value="desc" style="width:'.$width.'">';
			$th  .= '<span class="ajax-sort">'.$col_value.'</span>';
			$th  .= '</th>';

			return $th;
		}


		/*
    	|-------------------------------------------------------------------------------
		|
		|   输出初始加载的表格 输出td主要的内容部分
		|
		|-------------------------------------------------------------------------------
		*/
		public function body(){

			$data 	= $this->data();

			if(empty($data)){

				return '';
			}

			$str = '';

			foreach($data as $item ){

				$str .= '<tr>';
				$str .= $this->td_first($item[$this->col()[0]['col_name']]);

				foreach($this->col() as $col){

						$str .= '<td>'.$item[$col['alias_name']].'</td>';

				}

				if(empty($item['preview_url'])){

					$str .= $this->td_last_link($item['edit_url'],$item['del_url']);
				}
				else{

					$edit_url 			= $item['edit_url'];
					$del_url 			= $item['del_url'];
					$preview_url 		= $item['preview_url'];

					$str .= $this->td_last_link_preview($edit_url , $del_url , $preview_url);
				}


			}

			$str .= '</tr>';

			return $str;

		}


		/*
    |-------------------------------------------------------------------------------
		|
		|   输出td的第一个元素
		|
		|-------------------------------------------------------------------------------
		*/
		public function td_first($id){


			return '<td style="text-align:center;vertical-align:middle;"><input class="icheck mycheckbox checkbox-item" type="checkbox" name="ids[]" value="'.$id.'" /></td>';


		}



		/*
    	|-------------------------------------------------------------------------------
		|
		|   输出每个tr的最后一个td  也就是操作相关的链接
		|
		|-------------------------------------------------------------------------------
		*/
		public function td_last_link($edit_url , $del_url){


			return '<td>'.$edit_url .'&nbsp;'.$del_url.'</td>';
		}



		/*
    	|-------------------------------------------------------------------------------
		|
		|   输出每个tr的最后一个td  也就是操作相关的链接 包含预览按钮链接
		|
		|-------------------------------------------------------------------------------
		*/
		public function td_last_link_preview($edit_url , $del_url,$preview_url){


			return '<td style="vertical-align:middle;text-align:center;">'.$edit_url .'&nbsp;'.$del_url.' '.$preview_url.'</td>';
		}

	}

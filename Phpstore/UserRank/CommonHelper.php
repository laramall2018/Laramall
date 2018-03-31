<?php namespace Phpstore\UserRank;

use Phpstore\Grid\TableData;
use Phpstore\Grid\Grid;
use Phpstore\Grid\Page;
use Phpstore\Grid\Common;
use Phpstore\Base\Goodslib;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Goods;
use App\User;
use App\Models\UserRank;

/*
|-------------------------------------------------------------------------------
|
|   商品控制器里面的grid相应操作函数
|
|-------------------------------------------------------------------------------
|
|   tableDataInit  	    --------------- 初始化tableData实例 并赋值给grid实例
|   setTableDataCol		--------------- 设置tabledata实例需要显示的数据库字段
|   getData 		    --------------- 根据指定的字段 获取表格所需要显示的所有数据
|   getTableData($info) --------------- 根据返回的json格式数据 初始化新的tableData实例
|   searchData          --------------- grid模板页面 需要的搜索表单配置数组
|   searchInfo 			--------------- grid模板页面 ajax操作函数 需要的json格式参数
|                                       ps.ui.grid(ajax_url,_token ,json)
|   FormData            --------------- 生成添加商品时候的表单数据信息
|   EditData            --------------- 编辑商品时候生成表单的数组信息
|   delete_goods_image  --------------- 删除商品图片
|   softdelAction       --------------- 批量回收站操作
|   deleteAction        --------------- 批量删除操作
|
|-------------------------------------------------------------------------------
*/
class CommonHelper{

	protected $data;



	/*
	|----------------------------------------------------------------------------
	|
	|  构造函数
	|
	|----------------------------------------------------------------------------
	*/
	function __construct(){


    //定义商品的常用操作链接
    $this->list_url             = 'admin/user_rank';
    $this->edit_url             = 'admin/user_rank/edit';
    $this->add_url              = 'admin/user_rank/create';
    $this->update_url           = 'admin/user_rank/update';
    $this->del_url              = 'admin/user_rank/del/';
    $this->batch_url            = 'admin/user_rank/batch';
    $this->ajax_url             = 'admin/user_rank/grid';


	}


	/*
    |-------------------------------------------------------------------------------
    |
    |  初始化tableData 输出初始的商品列表dom元素
    |  设置 数据表   					table ---- goods
    |  设置排序方式  					orderBy('id','desc')
    |  设置等于搜索
    |
    |  brand_id  					品牌
    |  is_new    					新品
    |  is_best   					精品
    |  is_hot    					热卖
    |  is_on_sale 					上架
    |
    |  设置关键字搜索  				商品名称 goods_name
    |  where('goods_name','like',''.$goods_name.'')
    |
    |  设置whereIn操作
    |  whereIn('cat_id',[1,2,3,4,5])
    |  系统会根据以上条件拼接sql查询 把最终结果返回给grid类来处理
    |
    |-------------------------------------------------------------------------------
    */
    public function tableDataInit(){


        $tableData                  = new TableData();

        //设置参数
        $tableData->put('table','user_rank');
        $tableData->put('sort_name','id');
        $tableData->put('sort_value','desc');

        //设置等于搜索数组


        //设置搜索关键字
        $tableData->keywords('username','');

        //设置whereIn搜索
        //$tableData->whereIn('cat_id',[]);


        //设置数据表格每列显示的字段名称
        $tableData              = $this->setTableDataCol($tableData);

         //给page设置参数
         $current_page           = 1;
         $per_page               = 20;
         $total                  = intval($tableData->total());
         $last_page              = ceil($total / $per_page);
         $tableData->page('current_page',$current_page);
         $tableData->page('per_page',$per_page);
         $tableData->page('total',$total);
         $tableData->page('last_page',$last_page);

         //获取个性化后的数据
         $data                   = $this->getData($tableData->toArray());
         $tableData->put('data',$data);

        return $tableData;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   设置数据表中需要显示的所有数据字段 并根据需求格式化数据内容
    |
    |-------------------------------------------------------------------------------
    */
    public function setTableDataCol(TableData $tableData){

        //设置数据表格每列显示的字段名称
        $tableData->addCol('id','id','编号','100px');
        $tableData->addCol('rank_name','rank_name','会员等级名字','');
		$tableData->addCol('min_points','min_points','最小积分','');
		$tableData->addCol('max_points','max_points','最大积分','');
		$tableData->addCol('discount','discount','折扣比例','');
		$tableData->addCol('show_price','show_price_str','显示等级价格','');
		$tableData->addCol('special_rank','special_rank_str','特殊等级','');
		$tableData->addCol('rank_pic','rank_pic_str','等级图标','');

        return $tableData;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  把获取的数据 再进一步格式化
    |
    |-------------------------------------------------------------------------------
    */
    public function getData($data){

        if(empty($data)){

            return '';
        }

        foreach($data as $key=>$value){

            $model                                  = UserRank::find($value['id']);
            //alias赋值
			$data[$key]['show_price_str']           = Common::is_show($value['show_price']);
			$data[$key]['special_rank_str']         = Common::is_show($value['special_rank']);
            $data[$key]['rank_pic_str']            	= Common::image($model->icon());


            //操作链接
            $data[$key]['edit_url']                 = Common::get_resource_edit_url('admin/user_rank',$value['id']);
            $data[$key]['del_url']                  = Common::get_del_url($this->del_url,$value['id']);
            $data[$key]['preview_url']              = '';


        }

        return $data;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  根据返回的json格式的数据  格式化相关数据
    |
    |-------------------------------------------------------------------------------
    */
    public function getTableData($info){


        $tableData                  = new TableData();

        $sort_name                  = $info->sort_name;
        $sort_value                 = $info->sort_value;
        $current_page               = $info->page;
        $per_page                   = $info->per_page;

        $fieldRow                   = $info->fieldRow;
        $keywords                   = $info->keywords;
        $whereIn                    = $info->whereIn;


        //设置参数
        $tableData->put('table','user_rank');
        $tableData->put('sort_name',$sort_name);
        $tableData->put('sort_value',$sort_value);

        //设置关键词
        if($keywords){

            foreach($keywords as $key=>$value){

                $tableData->keywords($key , $value);
            }
        }

        //设置fieldRow 等于搜索
        if($fieldRow){

            foreach($fieldRow as $key=>$value){

                $tableData->addField($key , $value);
            }
        }



        //设置数据表格每列显示的字段名称
        $tableData              = $this->setTableDataCol($tableData);

         //设置分页参数信息
         $total                  = intval($tableData->total());
         $last_page              = ceil($total / $per_page);
         $tableData->page('current_page',$current_page);
         $tableData->page('per_page',$per_page);
         $tableData->page('total',$total);
         $tableData->page('last_page',$last_page);

         //获取个性化后的数据
         $data                   = $this->getData($tableData->toArray());
         $tableData->put('data',$data);

         return $tableData;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 生成grid页面 搜索表单的配置数组
    |
    |-------------------------------------------------------------------------------
    */
    public function searchData(){

        return [

                    [
                        'type'          => 'select',
                        'field'         => 'per_page',
                        'name'          => '分页大小',
                        'option_list'   => Common::get_per_page_option_list(),
                        'selected_name' => '5个/页',
                        'selected_value'=> 5,
                        'id'            => 'per_page',
                    ],


                    [
                        'type'          => 'text',
                        'field'         => 'rank_name',
                        'name'          => '会员等级名称',
                        'value'         => '',
                        'id'            => 'rank_name',
                    ],


                    [
                        'type'          => 'button',
                        'name'          => '搜索',
                        'id'            => 'search-btn',
						'back_url'	    => url($this->list_url),
                    ],
        ];

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  把执行ajax的搜索参数 用json格式化后 传递给grid页面
    |
    |-------------------------------------------------------------------------------
    */
    public function searchInfo(){

        $row    = [

                    'keywords'=>[
                                    ['field'=>'rank_name','value'=>'']
                    ],

                    'fieldRow'=>[




                    ],

                    'whereIn'=>[],
        ];


        return  json_encode($row,JSON_UNESCAPED_UNICODE);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 添加商品 生成form表单的配置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function FormData(){

        return [

                    [
                        'type'          => 'text',
                        'field'         => 'rank_name',
                        'name'          => '会员等级名称',
                        'value'         => '',
                        'id'            => 'rank_name',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'min_points',
                        'name'          => '最小积分',
                        'value'         => '',
                        'id'            => 'min_points',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'max_points',
                        'name'          => '最大积分',
                        'value'         => '',
                        'id'            => 'max_points',
                    ],
										[
                        'type'          => 'text',
                        'field'         => 'discount',
                        'name'          => '折扣比例',
                        'value'         => '',
                        'id'            => 'discount',
                    ],
										//单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'show_price',
                        'name'          => '是否显示等级价格',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => 1,
                        'id'            => 'show_price',
                    ],
					//单选按钮表单
					[							
                        'type'          => 'radio',
						'field'         => 'special_rank',
						'name'          => '是否是特殊等级',
						'radio_row'     => $this->get_radio(),
						'checked'       => 0,
						'id'            => 'special_rank',
					],


                    [
                        'type'          => 'file',
                        'field'         => 'rank_pic',
                        'name'          => '等级图标',
                        'value'         => '',
                        'file_info'     => '',
                        'upload_img'    =>'',
                        'id'            => 'rank_pic',
                    ],

                    [
                        'type'          => 'submit',
                        'value'         => '确认添加',
                        'id'            => 'cat-submit',
                        'back_url'      => url($this->list_url),
                    ],
        ];

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 编辑商品 生成form表单的配置参数
    |
    |-------------------------------------------------------------------------------
    */
		public function EditData($model){

				return [

										[
												'type'          => 'text',
												'field'         => 'rank_name',
												'name'          => '会员等级名称',
												'value'         => $model->rank_name,
												'id'            => 'rank_name',
										],

										[
												'type'          => 'text',
												'field'         => 'min_points',
												'name'          => '最小积分',
												'value'         => $model->min_points,
												'id'            => 'min_points',
										],

										[
												'type'          => 'text',
												'field'         => 'max_points',
												'name'          => '最大积分',
												'value'         => $model->max_points,
												'id'            => 'max_points',
										],
										[
												'type'          => 'text',
												'field'         => 'discount',
												'name'          => '折扣比例',
												'value'         => $model->discount,
												'id'            => 'discount',
										],
										//单选按钮表单
										[
												'type'          => 'radio',
												'field'         => 'show_price',
												'name'          => '是否显示等级价格',
												'radio_row'     => $this->get_radio(),
												'checked'       => $model->show_price,
												'id'            => 'show_price',
										],
										//单选按钮表单
										[
												'type'          => 'radio',
												'field'         => 'special_rank',
												'name'          => '是否是特殊等级',
												'radio_row'     => $this->get_radio(),
												'checked'       => $model->special_rank,
												'id'            => 'special_rank',
										],


										[
												'type'          => 'file',
												'field'         => 'rank_pic',
												'name'          => '等级图标',
												'value'         => $model->icon(),
												'file_info'     => '',
												'upload_img'    =>$model->icon(),
												'id'            => 'rank_pic',
										],

										[
	                                           'type'          => 'hidden',
	                                           'field'         => 'id',
	                                           'name'          => '模型编号',
	                                           'value'         => $model->id,
	                                           'id'            => 'id',
	                                   ],

	                                   [
	                                           'type'          => 'hidden',
	                                           'field'         => '_method',
	                                           'name'          => '表单递交方法',
	                                           'value'         => 'PUT',
	                                           'id'            => 'method',
	                                   ],


										[
												'type'          => 'submit',
												'value'         => '确认编辑',
												'id'            => 'cat-submit',
												'back_url'      => url($this->list_url),
										],
				        ];

		}


	/*
    |-------------------------------------------------------------------------------
    |
    | 是否显示等级价格
    |
    |-------------------------------------------------------------------------------
    */
    public function get_radio(){

    	return [


    					['name'=>'不显示','value'=>0],
    					['name'=>'显示','value'=>1],

    		];

    }


		/*
    |-------------------------------------------------------------------------------
    |
    | 删除会员等级图标
    |
    |-------------------------------------------------------------------------------
    */
    public function delete_user_rank_image($id){

        $model              = UserRank::find($id);

        if(empty($model)){

            return ;
        }


        $rank_pic          = $model->rank_pic;

        if($rank_pic){

            @unlink(public_path().'/'.$rank_pic);
        }
    }

}

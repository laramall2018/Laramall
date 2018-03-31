<?php namespace Phpstore\Grid;

/*
|-------------------------------------------------------------------------------
|
|  phpstore 商城的ajax分页系统
|
|-------------------------------------------------------------------------------
*/

class Page{

	protected $total;
	protected $current_page;
	protected $last_page;
	protected $per_page;

	/*
	|----------------------------------------------------------------------------
	|
	| 构造函数
	|
	|----------------------------------------------------------------------------
	*/  
	function __construct(){


		//初始化 首先赋值 记录总个数 total
		// total 的计算来至于 tabledata实例 total函数
		//当前页 current_page
		//总页数也就是最后页 last_page
		//每页记录个数 per_page 


	}


	/*
	|----------------------------------------------------------------------------
	|
	|  初始化赋值函数
	|
	|----------------------------------------------------------------------------
	*/  
	public function put($key , $value){

		$this->$key 	= $value;
		if($this->last_page <= 0){
			$this->last_page = 1;
		}

		return $this;
	}

	/*
	|----------------------------------------------------------------------------
	|
	|  批量初始化
	|
	|----------------------------------------------------------------------------
	*/ 
	public function init($row){

		foreach($row as $key=>$value){

			$this->put($key,$value);
		}
	}



	/*
	|----------------------------------------------------------------------------
	|
	|  获取page类的属性值
	|
	|----------------------------------------------------------------------------
	*/ 
	public function get($key){

		if(isset($this->$key)){

			return $this->$key;
		}
		else{

			return '';
		}
	}


	/*
	|------------------------------------------------------------------------------
	|
	|  生成总的分页ul代码
	|
	|------------------------------------------------------------------------------
	*/
	public function links(){


		return '<ul class="pagination">'. $this->render() .'</ul>';


	}



	/*
	|------------------------------------------------------------------------------
	|
	|  生成主要的分页队列代码 li元素
	|
	|------------------------------------------------------------------------------
	*/
	public function render(){


		//如果总页面数小于13 则直接全部显示
		if($this->last_page < 13){

			$content =  $this->get_page_range(1, $this->last_page);
		}

		//如果总页面数量大于或者等于13
		else{

			$content =  $this->get_page_slider();
		}

		return $this->get_prev() . $content . $this->get_next();

	}


	/**
	 * 生成一个总长度为13列的分页数列 
	 *
	 * @return string
	 */
	protected function get_page_slider()
	{
		$window = 6;

		// 如果当前页面小于6 也就是当前页面 在整个分页列表的左侧
		// 分页主要以左侧为主 那右侧只需要显示 end部分 即可
		// 10+3 的模式
		if ($this->current_page  <= $window)
		{
			$ending = $this->get_end();

			return $this->get_page_range(1, $window + 4).$ending;
		}

		// 当前页面大于6 同时当前页面和最末页的间距小于等于6
		// 也就是当前页面 在整个分页列表的右侧 以右侧为主
		// 3+ 10
		elseif ($this->current_page  >= $this->last_page  - $window)
		{
			$start = $this->last_page  - 9;

			$content = $this->get_page_range($start, $this->last_page);

			return $this->get_start() . $content;
		}

	
		// 当前页面在整个分页队列的正中间部分 和左侧 右侧间距 都大于6
		// 只需要显示：start部分  + 当前页为中心的前后三页+当前页  + end部分页面
		else
		{
			$content = $this->get_page_range($this->current_page -3 , $this->current_page + 3);
			return $this->get_start().$content.$this->get_end();
		}
	}





	/*
	|------------------------------------------------------------------------------
	|
	|  显示正常分页页面链接信息
	|
	|------------------------------------------------------------------------------
	*/
	public function get_page_link($text , $page ,  $cls , $rel){

		if(empty($rel)){

			return '<li><a class="'.$cls.'" href="#" data-page="'.$page.'">'.$text.'</a></li>';

		}
		else{

			return '<li class="'.$rel.'"><a class="'.$cls.'" href="#" data-page="'.$page.'">'.$text.'</a></li>';

		}
		
	}


	/*
	|------------------------------------------------------------------------------
	|
	|  显示禁止链接分页信息
	|
	|------------------------------------------------------------------------------
	*/
	public function get_disabled_text($text , $cls){

		return '<li class="disabled '.$cls.'"><span>'.$text.'</span></li>';
	}

	/*
	|------------------------------------------------------------------------------
	|
	|  显示上一页按钮
	|
	|------------------------------------------------------------------------------
	*/
	public function get_prev(){

		$text = '&laquo;';
		if($this->current_page > 1){

			$page = $this->current_page -1;

			return $this->get_page_link($text , $page , 'ajax-a' , 'first');
		}
		else{

			return $this->get_disabled_text($text , 'first');
		}
	}



	/*
	|------------------------------------------------------------------------------
	|
	|  显示下一页按钮
	|
	|------------------------------------------------------------------------------
	*/
	public function get_next(){

		$text = '&raquo;';
		if($this->current_page < $this->last_page ){

			$page = $this->current_page + 1;

			return $this->get_page_link($text , $page , 'ajax-a' ,'last');
		}

		else{

			return $this->get_disabled_text($text, 'last');
		}

	}


	/*
	|------------------------------------------------------------------------------
	|
	|  显示省略号按钮
	|
	|------------------------------------------------------------------------------
	*/
	public function get_dots(){

		$text = '...';
		return $this->get_disabled_text($text , '');

	}



	/*
	|------------------------------------------------------------------------------
	|
	|  显示当前页
	|
	|------------------------------------------------------------------------------
	*/
	public function get_active($page){

		return '<li class="active"><span>'.$page.'</span></li>';

	}


	/*
	|------------------------------------------------------------------------------
	|
	|  安装顺序显示一组分页信息
	|
	|------------------------------------------------------------------------------
	*/
	public function get_page_range($start , $end){

		

		$page_link = '';

		for($page = $start ; $page<= $end ; $page++ ){

			//如果是当前页 激活当前页
			if($page == $this->current_page ){

				$page_link .= $this->get_active($page);
			}
			else{

				$page_link .= $this->get_page_link($page , $page , 'ajax-a' , '');
			}

		}

		return $page_link;
	}



	/*
	|------------------------------------------------------------------------------
	|
	|  显示1,2,...,开始页面
	|
	|------------------------------------------------------------------------------
	*/
	public function get_start(){

		return $this->get_page_range(1,2) . $this->get_dots();
	}


	/*
	|------------------------------------------------------------------------------
	|
	|  显示...,倒数第二页，倒数第一页  分页的结束页面
	|
	|------------------------------------------------------------------------------
	*/
	public function get_end(){

		return $this->get_dots() . $this->get_page_range($this->last_page-1 , $this->last_page );
	}


	/*
	|------------------------------------------------------------------------------
	|
	|  输出一个分页的数字数组
	|
	|------------------------------------------------------------------------------
	*/
	public function number(){

		//如果总页面小于13 则可以返回所有页面 否则需要特殊处理溢出的页面
		return ($this->last_page <= 13) ? range(1,$this->last_page) : $this->getNumberLastPageOver();
	}

	/*
	|------------------------------------------------------------------------------
	|
	|  当总页面大于13的时候
	|
	|------------------------------------------------------------------------------
	*/
	public function getNumberLastPageOver(){

		//当前页小于middle = 6的时候  相当于当前页在整个分页的左侧
		//相当于 10 + 3 模式 
		$middle 					= 6;
		return ($this->current_page <= $middle) ? $this->getNumberLeftModel(): $this->getNumberRightModel();
	}


	/*
	|------------------------------------------------------------------------------
	|
	|  总页面大于13 当前页在 middle的左侧
	|  显示模式：10 + 3 模式
	|
	|------------------------------------------------------------------------------
	*/
	public function getNumberLeftModel(){

		return [ 
					1,2,3,4,5,6,7,8,9,10,
					'..',
					($this->last_page -2),
					($this->last_page -1),
					$this->last_page 
				];
	}

	/*
	|------------------------------------------------------------------------------
	|
	|  总页面大于13 当前页在 middle的右侧
	|  在右侧 有2种可能
	|  1.当前页面距离最末页 间距小于 6 也就是在右侧 靠近页面尾部  3 + 10模式
	|  2.当前页面距离最末页 间距大于 6 也就是虽然在右侧 但是距离分页尾部间距大于6
	|
	|------------------------------------------------------------------------------
	*/
	public function getNumberRightModel(){

		$middle 				= 6;
		$skip 					= $this->last_page - $this->current_page;
		// 3 + 10模式  开始的三页 +  以从尾页开始的倒数10页
		$arr 					= [1,2,3,'..'];

		for($i = $this->last_page - 9 ;$i< $this->last_page ;$i ++){

			$arr[]				= $i;
		}
		return ($skip <= 6)? $arr : $this->getNumberMiddleModel();
	}



	/*
	|------------------------------------------------------------------------------
	|
	|  总页面大于13 当前页在 middle的右侧
	|  在右侧 有2种可能
	|  2.当前页面距离最末页 间距大于 6 也就距离页尾和页头 距离都大于6 
	|  分页的模式 就是  3 + 7 + 3 模式  开始三页 +  以当前页为中心的7页 + 结尾三页
	|
	|------------------------------------------------------------------------------
	*/
	public function getNumberMiddleModel(){

		$arr 	=   [
						1,
						2,
						3,
						'..',
						$this->current_page -3 ,
						$this->current_page -2,
						$this->current_page -1,
						$this->current_page,
						$this->current_page +1,
						$this->current_page +2,
						$this->current_page +3,
						'..',
						$this->last_page -2,
						$this->last_page -1,
						$this->last_page
					];
	    return $arr;
	}

}
<?php namespace Install;


class Common{

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
       
	}


	/*
	|----------------------------------------------------------------------------
	|
	|  获取导入商品列表
	|
	|----------------------------------------------------------------------------
	*/
    public static function get_goods_list(){

        return [

            [   
                'goods_sn'=>'ps-1234',
                'goods_name'=>'西门子冰箱ASD1',
                'goods_thumb'=>'images/123',
                'cat_id'=>1,
                'brand_id'=>2,
                'market_price'=>123,
                'shop_price'=>111,
                'goods_number'=>123,
                'diy_url'=>'',
                'is_new'=>1,
                'is_best'=>1,
                'is_hot'=>1,
                'is_promote'=>1,
                'is_on_sale'=>1
            ],
            [   
                'goods_sn'=>'ps-12342',
                'goods_name'=>'西门子冰箱ASD2',
                'goods_thumb'=>'images/123',
                'cat_id'=>1,
                'brand_id'=>2,
                'market_price'=>123,
                'shop_price'=>111,
                'goods_number'=>123,
                'diy_url'=>'',
                'is_new'=>1,
                'is_best'=>1,
                'is_hot'=>1,
                'is_promote'=>1,
                'is_on_sale'=>1
            ],
            [   
                'goods_sn'=>'ps-12343',
                'goods_name'=>'西门子冰箱ASD3',
                'goods_thumb'=>'images/1233',
                'cat_id'=>1,
                'brand_id'=>2,
                'market_price'=>123,
                'shop_price'=>111,
                'goods_number'=>123,
                'diy_url'=>'',
                'is_new'=>1,
                'is_best'=>1,
                'is_hot'=>1,
                'is_promote'=>1,
                'is_on_sale'=>1
            ],
            [   
                'goods_sn'=>'ps-12344',
                'goods_name'=>'西门子冰箱ASD4',
                'goods_thumb'=>'images/1234',
                'cat_id'=>1,
                'brand_id'=>2,
                'market_price'=>123,
                'shop_price'=>111,
                'goods_number'=>123,
                'diy_url'=>'',
                'is_new'=>1,
                'is_best'=>1,
                'is_hot'=>1,
                'is_promote'=>1,
                'is_on_sale'=>1
            ],
            [   
                'goods_sn'=>'ps-12345',
                'goods_name'=>'西门子冰箱ASD5',
                'goods_thumb'=>'images/1236',
                'cat_id'=>1,
                'brand_id'=>2,
                'market_price'=>123,
                'shop_price'=>111,
                'goods_number'=>123,
                'diy_url'=>'',
                'is_new'=>1,
                'is_best'=>1,
                'is_hot'=>1,
                'is_promote'=>1,
                'is_on_sale'=>1
            ],
            [   
                'goods_sn'=>'ps-12346',
                'goods_name'=>'西门子冰箱ASD6',
                'goods_thumb'=>'images/1236',
                'cat_id'=>1,
                'brand_id'=>2,
                'market_price'=>123,
                'shop_price'=>111,
                'goods_number'=>123,
                'diy_url'=>'',
                'is_new'=>1,
                'is_best'=>1,
                'is_hot'=>1,
                'is_promote'=>1,
                'is_on_sale'=>1
            ],
            [   
                'goods_sn'=>'ps-12347',
                'goods_name'=>'西门子冰箱ASD7',
                'goods_thumb'=>'images/1237',
                'cat_id'=>1,
                'brand_id'=>2,
                'market_price'=>123,
                'shop_price'=>111,
                'goods_number'=>123,
                'diy_url'=>'',
                'is_new'=>1,
                'is_best'=>1,
                'is_hot'=>1,
                'is_promote'=>1,
                'is_on_sale'=>1
            ],
            [   
                'goods_sn'=>'ps-12348',
                'goods_name'=>'西门子冰箱ASD8',
                'goods_thumb'=>'images/123',
                'cat_id'=>1,
                'brand_id'=>2,
                'market_price'=>123,
                'shop_price'=>111,
                'goods_number'=>123,
                'diy_url'=>'',
                'is_new'=>1,
                'is_best'=>1,
                'is_hot'=>1,
                'is_promote'=>1,
                'is_on_sale'=>1
            ],

        ];
    }


    /*
	|----------------------------------------------------------------------------
	|
	|  导入大量商品数据
	|
	|----------------------------------------------------------------------------
	*/
	public static function goods_list(){

		$data 			= [];

		for($i = 0; $i<10000;$i++){

			$data[] 	= [   
                			'goods_sn'=>'ps-1234'.$i,
                			'goods_name'=>'西门子冰箱ASD'.$i,
                			'goods_thumb'=>'images/123'.$i,
                			'cat_id'=>1,
                			'brand_id'=>2,
                			'market_price'=>(123+$i),
                			'shop_price'=>(111+$i),
                			'goods_number'=>123,
                			'diy_url'=>'',
                			'is_new'=>1,
                			'is_best'=>1,
                			'is_hot'=>1,
                			'is_promote'=>1,
                			'is_on_sale'=>1
            ];
		}

		return $data;
	}
}

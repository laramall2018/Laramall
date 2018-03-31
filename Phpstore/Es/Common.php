<?php

namespace Phpstore\Es;

class Common{


	/*
	|----------------------------------------------------------------------------
	|
	|  构造函数
	|
	|----------------------------------------------------------------------------
	*/
	public function init(){

		$hosts = [env('ES_HOST')];

		$client = \Elasticsearch\ClientBuilder::create()  
                    ->setHosts($hosts)     
                    ->build();

        return $client;

	}
}
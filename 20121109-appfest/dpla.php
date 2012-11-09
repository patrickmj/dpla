<?php

/**
* Baseline class for access to DPLA API
*/
class dpla
{

	public $api_base_url;
	
	function __construct(argument)
	{
		$this->api_base_url = 'http://api.dp.la/v1/';
	}
}

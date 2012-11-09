<?php

/**
* Baseline class for access to DPLA API
*/
class dpla
{

	public $api_base_url;
	
	function __construct()
	{
		$this->api_base_url = 'http://api.dp.la/v1/';
	}

	public function search_item($searchtype, $term) {
		
		$searchtype = strtolower($searchtype);
		$valid_types = array('title', 'description', 'subject', 'dplacontributor', 'creator', 'type', 'publisher', 'format', 'rights', 'contributor', 'spatial', 'ispartof');
		if (!in_array($searchtype, $valid_types)) {
			return array('error' => 'Invalid search type');
		}

		
	}

	public function item_fetch($item_id) {

	}

}

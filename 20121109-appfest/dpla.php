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

	public function search_item($term, $searchtype = NULL) {
		
		if (!$searchtype) { $searchtype = 'q'; }
		$searchtype = strtolower($searchtype);
		$valid_types = array('q', 'title', 'description', 'subject', 'dplacontributor', 'creator', 'type', 'publisher', 'format', 'rights', 'contributor', 'spatial', 'ispartof');
		if (!in_array($searchtype, $valid_types)) {
			return array('error' => 'Invalid search type');
		}

		$result = json_decode(file_get_contents($this->api_base_url . 'items?' . $searchtype . '=' . $term));

		return $result;

	}

	public function item_fetch($item_id) {

	}

}

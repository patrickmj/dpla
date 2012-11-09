#!/usr/bin/php -q
<?php

require_once('dpla.php');

$dpla = new dpla;

$searchtype = NULL;
$term = 'fruit';

$itemid = $arrayName = array('f661d96c6109911a1b93df8d0a65c474');

//print_r($dpla->search_item($term, $searchtype));
print_r($dpla->item_fetch($itemid));
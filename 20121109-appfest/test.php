#!/usr/bin/php -q
<?php

require_once('dpla.php');

$dpla = new dpla;

$searchtype = NULL;
$term = 'fruit';

print_r($dpla->search_item($term, $searchtype));
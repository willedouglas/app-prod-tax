<?php

	include_once 'Controller/Taxes.class.php';
	include_once 'Controller/Categories.class.php';
	include_once 'Controller/Products.class.php';

	$request = explode('/', rtrim($_REQUEST['request'], '/'));
	
	if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
		$_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
	}

	try {
		if (!empty($request[0])) {
			$API = new $request[0]($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
			echo $API->processAPI();	
		} else {
			echo json_encode("No endpoint.");
		}
	} catch (Exception $e) {
		echo json_encode(Array('error' => $e->getMessage()));
	}
?>
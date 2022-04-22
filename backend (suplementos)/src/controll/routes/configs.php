<?php

	header("Content-type: application/json");
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");
	header('Access-Control-Allow-Headers: Content-Type');

	$_POST;
	if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'POST')) {
		$_POST = json_decode(file_get_contents('php://input'));
	}
	
	$_PUT;
	if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'PUT')) {
		$_PUT = json_decode(file_get_contents('php://input'));
	}
	
	$_DELETE;
	if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'DELETE')) {
		$_DELETE = $_GET['id'];
	}


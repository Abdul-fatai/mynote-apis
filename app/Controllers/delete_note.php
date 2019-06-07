<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: appliaction/json');

include '../dbconn.php';
include '../User.php';

// Instantiate database
$database = new Dbh;
$db = $database->connect();

// notes model
$user = new User($db);

foreach ($_REQUEST as $key => $value) {
	$$key = $value;
}


if (empty($_REQUEST)) {
	http_response_code(400);
	echo json_encode(
		array('message' => 'invalid input')
	);
	return false;
}

// notes model
$user->id = $id;

try{
	// notes model
	$user->delete();
	echo json_encode(
		array('message' => 'note delete successfully')
	);
}catch(Exception $e){
	$error_file = '../../error.log';
	$handle = fopen($error_file, 'a') or die("Cannot open file");
	$str = "\n \n \n [".date('Y-m-d h:i a')."] \n";
	fwrite($handle, $str);
	fwrite($handle, $e);
	echo json_encode(
		array('message' => 'something went wrong')
	);
}
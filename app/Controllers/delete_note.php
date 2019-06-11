<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: appliaction/json');

include '../config/dbconn.php';
include '../Note.php';

// Instantiate database
$database = new Dbh;
$db = $database->connect();


$note = new Note($db);

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


$note->id = $id;

try{
	
	$note->delete();
	echo json_encode(
		array('message' => 'note delete successfully')
	);
}catch(Exception $e){
	$error_file = '../../error.log';
	$handle = fopen($error_file, 'a') or die("Cannot open file");
	$str = "\n \n \n [".date('Y-m-d h:i a')."] \n";
	fwrite($handle, $str);
	fwrite($handle, $e);
	http_response_code(400);
	echo json_encode(
		array('message' => 'something went wrong')
	);
}
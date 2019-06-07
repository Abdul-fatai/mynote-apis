<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: appliaction/json');

include '../dbconn.php';
include '../User.php';

//Instantiate database
$database = new Dbh;
$db = $database->connect();

$user = new User($db);

foreach ($_REQUEST as $key => $value) {
	$$key = $value;

}

if (empty($_REQUEST)) {
	http_response(500);
	echo json_encode(
		array('message' => 'empty input')
	);

	return false;
}

$user->subject = $subject;
$user->body = $body;

//post id
$user->id = $id;

try {
	$user->update();
	echo json_encode(
		array('message' => 'note upadate succesfully')
	);
} catch(Exception $e){
		$error_file = '../../error.log';
		$handle = fopen($error_file, 'a') or die('Cannot open file');
		$str = "\n \n \n[". date('Y-m-d h:i a') ."] \n";
		fwrite($handle, $str);
		fwrite($handle, $e);
		echo json_encode(
			array('error' => 'something went wrong')
		);
}

<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: appliaction/json');


	include '../dbconn.php';
	include '../User.php';

	//Instantiate DB & connect
	$database = new Dbh();
	$db = $database->connect();

	$user = new User($db);

	foreach ($_REQUEST as $key => $value) {
		$$key = $value;
	}

	if(empty($_REQUEST)) {
		http_response_code(400);
		echo json_encode(
	        array('message' => 'Invalid input')
	    );
	    return false;
	}

	$user->username = $username;
	$user->email = $email;
	$user->password = $password;

	try {
		$user->create();
		echo json_encode(
	        array('message' => 'account created successfully')
	    );
	} catch (Exception $e) {
		$error_file = '../../error.log';
		$handle = fopen($error_file, 'a') or die('Cannot open file');
		$str = "\n \n \n[". date('Y-m-d h:i a') ."] \n";
		fwrite($handle, $str);
		fwrite($handle, $e);
		echo json_encode(
			array('error' => 'something went wrong')
		);
	}

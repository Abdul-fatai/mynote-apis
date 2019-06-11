<?php
	header("Access-Control-Allow-Origin: * ");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include '../config/dbconn.php';
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

	
	// Hash password
	$password_hash = password_hash($password, PASSWORD_DEFAULT);

	$user->username = $username;
	$user->email = $email;
	$user->password = $password_hash;

	try {
		$user->create();
		http_response_code(200);
		echo json_encode(
	        array('message' => 'account created successfully')
	    );
	} catch (Exception $e) {
		$error_file = '../../error.log';
		$handle = fopen($error_file, 'a') or die('Cannot open file');
		$str = "\n \n \n[". date('Y-m-d h:i a') ."] \n";
		fwrite($handle, $str);
		fwrite($handle, $e);
		http_response_code(400);
		echo json_encode(
			array('error' => 'something went wrong')
		);
	}

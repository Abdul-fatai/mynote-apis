<?php 
	
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/dbconn.php';
	include_once "../../vendor/autoload.php";
	use \Firebase\JWT\JWT;
	include_once '../User.php';

	//Instantiate DB & connect
	$database = new Dbh();
	$db = $database->connect();

	$user = new User($db);
	

	// Login query
	$result = $user->login();

	//Get row count 
	$num = $result->rowCount($db);
    
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
	
	if($num > 0){
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$username = $row['username'];
		$email = $row['email'];
		$password_verify = $row['password'];
	
		if(password_verify($password, $password_verify))
		{
			$secret_key = "";
			$issuer_claim = "localhost"; // this can be the servername
			$audience_claim = "THE_AUDIENCE";
			$issuedat_claim = time("h:i:sa"); // issued at
			$notbefore_claim = $issuedat_claim + 10; //not before in seconds
			$expire_claim = $issuedat_claim + 60; // expire time in seconds
			$token = array(
				"iss" => $issuer_claim,
				"aud" => $audience_claim,
				"iat" => $issuedat_claim,
				"nbf" => $notbefore_claim,
				"exp" => $expire_claim,
				"data" => array(
					"username" => $username,
					"email" => $email
			));
	
			http_response_code(200);
	
			$jwt = JWT::encode($token, $secret_key);
			echo json_encode(
				array(
					"message" => "Successful login.",
					"jwt" => $jwt,
					"username" => $username,
					"email" => $email,
					"expireAt" => $expire_claim
				));
		}
		else{
	
			http_response_code(401);
			echo json_encode(
				array("message" => "Login failed.", "password" => $password)
			);
		}
	}

<?php

class User {
	private $conn;
	private $table = 'users';

	public $username = '';
	public $email = '';
	public $password = '';


	//Contructors with DB
    public function __construct($db) {
        $this->conn = $db;
    }

	public function create() {

		$query = 'INSERT INTO '. 
		$this->table .' 
		SET 
		username = :username, 
		email = :email,
		password = :password';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->username = htmlspecialchars(strip_tags($this->username));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->password = htmlspecialchars(strip_tags($this->password));

		//Bind data
		$stmt->bindParam(':username', $this->username);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':password', $this->password);


	    //Execute query
	    if($stmt->execute()){
	      return true;
	    } 
	    //Print error if something went wrong
	    printf("Error: %s.\n", $stmt->error);
	      return false; 
	}

	public function login() {

		$query = 'SELECT * FROM '. 
		$this->table .' 
		WHERE
		username = :username
		OR
		email = :email
		LIMIT 1';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->username = htmlspecialchars(strip_tags($this->username));
		$this->email = htmlspecialchars(strip_tags($this->email));

		//Bind data
		$stmt->bindParam(':username', $this->username);
		$stmt->bindParam(':email', $this->email);


	    //Execute query
	    $stmt->execute();
	}

}

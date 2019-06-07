<?php

class User {
	private $conn;
	private $table = 'users';

	// remove this thing
	private $table1 = 'notes';


	public $username = '';
	public $email = '';
	public $password = '';

	//remove this shit
	public $subject = '';
	public $body = '';

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

	// move this shit to the notes model
	public function note(){
		$query = 'INSERT INTO '.
		$this->table1 .'
		SET
		subject = :subject,
		body = :body';

		//prepare statement 
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->subject = htmlspecialchars(strip_tags($this->subject));
		$this->body = htmlspecialchars(strip_tags($this->body));

		//Bind data
		$stmt->bindParam(':subject', $this->subject);
		$stmt->bindParam(':body', $this->body);

		//Execute query 
		if ($stmt->execute()) {
			return true;
		}

		printf("Error: %s.\n", $stmt->error);
		return false;
	}

	// move this to notes model
	public function update(){
		$query = 'UPDATE '.
		$this->table1 .'
		SET
		subject = :subject,
		body = :body
		WHERE 
		id = :id';


		//Prepare statement 
		$stmt = $this->conn->prepare($query);

		//Clean data 
		$this->subject = htmlspecialchars(strip_tags($this->subject));
		$this->body = htmlspecialchars(strip_tags($this->body));
		$this->id = htmlspecialchars(strip_tags($this->id));

		//Bind data 
		$stmt->bindParam(':subject', $this->subject);
		$stmt->bindParam(':body', $this->body);
		$stmt->bindParam(':id', $this->id);

		//Execute query
		if ($stmt->execute()) {
			return true;
		}
		printf("Error: %s.\n", $stmt->error);
		return false;
	}


	// move this too, ok
	public function delete(){
		$query = 'DELETE FROM '.
		$this->table1 .'
		WHERE 
		id = :id';

		//Prepare statement 
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->id = htmlspecialchars(strip_tags($this->id));

		// bind data

		$stmt->bindParam(':id', $this->id);

		//Execute query

		if ($stmt->execute()) {
			return true;
		}

		printf("Error: %s.\n", $stmt->error);
		return false;

	}

}

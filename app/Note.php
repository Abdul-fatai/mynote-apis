<?php
   class Note {
    private $conn;
    private $table = 'notes';
    
    public $id = '';
	public $subject = '';
    public $body = '';
    
    //Contructors with DB
    public function __construct($db) {
            $this->conn = $db;
        }

    
	public function note(){
		$query = 'INSERT INTO '.
		$this->table .'
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

	public function update(){
		$query = 'UPDATE '.
		$this->table . '
		SET
		subject = :subject,
		body = :body
		WHERE 
		id = :id ';


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


	
	public function delete(){
		$query = 'DELETE FROM '.
		$this->table .'
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
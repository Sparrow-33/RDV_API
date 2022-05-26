<?php
  class User {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Regsiter user
    public function registerModel($data){
      $this->db->query('INSERT INTO patient (PID, Fname, Pname,NID, email, reference) VALUES(:PID, :Fname, :Pname, :NID, :email,  :reference)');
      // Bind values
      $this->db->bind(':PID',bin2hex(random_bytes(16)));
      $this->db->bind(':Fname', $data['FamName']);
      $this->db->bind(':Pname', $data['PersName']);
      $this->db->bind(':NID', $data['NID']);
      $this->db->bind(':email', $data['email']);
      //$this->db->bind(':pwd', $data['password']);
      $this->db->bind(':reference', $data['reference']);


      // Execute
      if($this->db->execute()){

        return $data['reference'];
      } else {
        return false;
      }
    }

    // Login User
    public function login($reference){
      $this->db->query('SELECT * FROM patient WHERE reference= :reference');
      $this->db->bind(':reference', $reference);

      $row = $this->db->single();

      if($row){
        return $row;
      } else {
        return false;
      }
    }

    // Find user by email
    public function findUserByEmail($email){
      $this->db->query('SELECT * FROM patient WHERE email = :email');
      // Bind value
      $this->db->bind(':email', $email);

      $row = $this->db->single();

      // Check row
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }

    public function getUserId($reference){
        $this->db->query('SELECT PID FROM patient WHERE reference = :reference');
        $this->db->bind(':reference', $reference);
        $row = $this->db->single();
        return $row->PID;
    }

      public function findUserByID($NID){
          $this->db->query('SELECT * FROM patient WHERE NID = :NID');
          // Bind value
          $this->db->bind(':NID', $NID);

          $row = $this->db->single();

          // Check row
          if($this->db->rowCount() > 0){
              return true;
          } else {
              return false;
          }
      }
  }
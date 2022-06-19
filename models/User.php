<?php
  class User {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Regsiter user
    public function registerModel($data){
      $this->db->query('INSERT INTO user (ID, name,  email, password) VALUES(:ID, :name, :email,  :pwd)');
      // Bind values
      $this->db->bind(':ID',bin2hex(random_bytes(16)));
      $this->db->bind(':name', $data['name']);
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':pwd', $data['pwd']);


      // Execute
      if($this->db->execute()){

        return true;
      } else {
        return false;
      }
    }

  

    // Login User
    public function login($email,$password){


      $this->db->query('SELECT * FROM user WHERE email= :email');
      $this->db->bind(':email', $email);

      $row = $this->db->single();


      if($row)
      {
        if(password_verify($password, $row->password)){
          return $row;
        } else {
          return false;
        }

      }


    }

    // Find user by email
    public function findUserByEmail($email){
      $this->db->query('SELECT * FROM user WHERE email = :email');
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

    public function getUserId($email){
        $this->db->query('SELECT ID FROM user WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        return $row->ID;
    }

    // function get user by id
    public function getUserById($id){
        $this->db->query('SELECT * FROM user WHERE ID = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;

    }

    //function update user
    public function updateUserById($data){
        $this->db->query('UPDATE user SET name = :name, email = :email, description = :description , phone = :phone  WHERE ID = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':phone', $data['phone']);
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
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


      public function createArticle($data){
          $this->db->query('INSERT INTO article ( title, body, cover, cat_ID) VALUES( :title, :content,  :article_cover, :cat_ID)');
          // Bind values
          $this->db->bind(':title', $data['title']);
          $this->db->bind(':content', $data['content']);
          $this->db->bind(':article_cover', $data['cover']);
          $this->db->bind(':cat_ID', $data['category_id']);

          if($this->db->execute()){
              return true;
          } else {
              return false;
          }
      }

      //function to get specific article
      public function getArticle($data){
          $this->db->query('SELECT A.ID, A.title, A.cover, A.body, U.name, U.profile, C.CatName, A.time  FROM article A, user U, categories C WHERE A.ID = :id AND A.UID = U.ID AND A.cat_ID = C.IDC');
          $this->db->bind(':id', $data['id']);
          $row = $this->db->single();
          return $row;
      }

      
      //function to post comment
      public function postComment($data){
          $this->db->query('INSERT INTO `comments`(`UID`, `comment`, `article_ID`) VALUES( :UID, :comment, :article_id)');
          // Bind values
          $this->db->bind(':UID', $data['UID']);
          $this->db->bind(':comment', $data['comment']);
          $this->db->bind(':article_id', $data['article_id']);

          if($this->db->execute()){
              return true;
          } else {
              return false;
          }
      }

      //function to get all comments
      public function getComments($id){
          $this->db->query('SELECT C.CID , C.comment , U.profile, U.name, C.time FROM comments C, user U WHERE C.UID = U.ID AND C.article_ID = :id ORDER BY C.time DESC');
          
          $this->db->bind(':id', $id);
          $rows = $this->db->resultSet();
          return $rows;
      }

      //function to get all categories
      public function getCategories(){
          $this->db->query('SELECT * FROM categories');
          $rows = $this->db->resultSet();
          return $rows;
      }
  }
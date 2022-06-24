<?php

class BlogModel {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    public function getThreeArticles($id, $blog_id){
      $this->db->query('SELECT * FROM article WHERE cat_ID = :id AND NOT ID = :blog_id LIMIT 3');
      $this->db->bind(':id', $id);
      $this->db->bind(':blog_id', $blog_id);
      $result = $this->db->resultSet();

      if( $result){
        return $result;
      } else {
        return false;
      }

    }

    //function to like an article
    public function likeArticle($id, $blog_id){

      $this->db->query('INSERT INTO likes (UID, AID)  VALUES( :id , :blog_id )');
      $this->db->bind(':id', $id);
      $this->db->bind(':blog_id', $blog_id);
      $result = $this->db->execute();

      if( $result){
        return true;
      } else {
        return false;
      }
    }

    //function to unlike an article
    public function unlikeArticle($id, $blog_id){

      $this->db->query('DELETE FROM likes WHERE UID = :id AND AID = :blog_id');
      $this->db->bind(':id', $id);
      $this->db->bind(':blog_id', $blog_id);
      $result = $this->db->execute();

      if( $result){
        return true;
      } else {
        return false;
      }
    }

    // already liked
    public function alreadyLiked($id, $blog_id){
      $this->db->query('SELECT * FROM likes WHERE UID = :id AND AID = :blog_id');
      $this->db->bind(':id', $id);
      $this->db->bind(':blog_id', $blog_id);

      $this->db->resultSet();
      $num = $this->db->rowCount();

      if($num > 0){
        return true;
      } else {
        return false;
      }
    }

    //function to get number of likes
    public function getNumberOfLikes($blog_id){
      $this->db->query('SELECT * FROM likes WHERE AID = :blog_id');
      $this->db->bind(':blog_id', $blog_id);
      $this->db->resultSet();
      $num = $this->db->rowCount();

      

      if( $num){
        return $num;
      } else {
        return $num;
      }
    }

    //function to get all articles

    public function getAllArticles(){

      $this->db->query('SELECT A.ID, A.title, A.cover, A.cat_ID, A.UID,A.time, C.IDC, C.CatName, U.name, U.profile
                              FROM article A, user U, categories C
                                   WHERE A.UID  = U.ID
                                       AND A.cat_ID = C.IDC');

      $result = $this->db->resultSet();

      if( $result){
        return $result;
      } else {
        return false;
      }

    }

    public function deleteArticle($id){

      $this->db->query('DELETE  FROM article WHERE ID = :id');

      $this->db->bind(':id', $id);
      $result = $this->db->execute();

      if( $result){
        return true;
      } else {
        return false;
      }

    }

    public function countComment(){
      $this->db->query('SELECT * FROM comments');
      $this->db->resultSet();
      $num = $this->db->rowCount();

      

      if( $num){
        return $num;
      } else {
        return $num;
      }
    }

    public function countArticle(){
      $this->db->query('SELECT * FROM article');
      $this->db->resultSet();
      $num = $this->db->rowCount();

      

      if( $num){
        return $num;
      } else {
        return $num;
      }
    }

    public function countUsers(){
      $this->db->query('SELECT * FROM user');
      $this->db->resultSet();
      $num = $this->db->rowCount();

      

      if( $num){
        return $num;
      } else {
        return $num;
      }
    }

    public function countLikes(){
      $this->db->query('SELECT * FROM likes');
      $this->db->resultSet();
      $num = $this->db->rowCount();

      

      if( $num){
        return $num;
      } else {
        return $num;
      }
    }

}    
<?php

require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Users extends Controller
{
  public function __construct()
  {
    $this->userModel = $this->model('User');
  }

  public function register()
  {
    // Check for POST
    $result = json_decode(file_get_contents('php://input'));


    // split string
    $arr1 = str_split($result->name, 2);
    $arr2 = str_split($result->email, 2);

    //Generate a random string.
    $token = openssl_random_pseudo_bytes(10);

    //Convert the binary data into hexadecimal representation.
    $token = bin2hex($token);

    // generate custom token
    $token = $arr1[0] . $arr2[0] . $token;

    // Init data
    $data = [

      'name' => $result->name,
      'email' => $result->email,
      'pwd' => password_hash($result->password, PASSWORD_DEFAULT)

    ];


    // Validate Email
    if (empty($data['email'])) {
      $data['email_err'] = 'Please enter email';
    } else {
      // Check email
      if ($this->userModel->findUserByEmail($data['email'])) {
        $data['email_err'] = 'Email is already taken';
      }
    }

    // Register User
    if ($this->userModel->registerModel($data)) {


      // echo json_encode($this->userModel->registerModel($data));
      echo json_encode(array(
        "reference" => "success",
      ));
    } else {
      return false;
    }
  }



  public function login()
  {
    $result = json_decode(file_get_contents('php://input'));


    // Make sure errors are empty
    if (!empty($result->email) && !empty($result->password)) {
      // Validated
      // Check and set logged in user

      $loggedInUser = $this->userModel->login($result->email, $result->password);



      if ($loggedInUser) {


        $ID = $this->userModel->getUserId($result->email);
        $secret = 'secret_key';
        $date = new DateTimeImmutable();
        $expire_at = $date->modify('+1 minutes')->getTimestamp();
        $domainName = "localhost";
        $request_data = [
          'iat' => $date->getTimestamp(),
          'iss' => $domainName,
          'nbf' => $date->getTimestamp(),
          'exp' => $expire_at,
          'id' => $ID
        ];

        $token = JWT::encode(
          $request_data,
          $secret,
          'HS512'
        );

        echo json_encode(
          array(
            'message' => "login success",
            'token' => $token,
            'expire' => $expire_at,
            'id' => $ID
          )
        );
      }
    }
  }


  //function get a user by id
  public function getUserById()
  {
    $result = json_decode(file_get_contents('php://input'));
    $id = $result->id;
    $user = $this->userModel->getUserById($id);
    printf(json_encode($user));
  }



  public function createArticle()
  {

    //   $result = json_decode(file_get_contents('php://input'));

    //   $filename = $_FILES['file']['name'];


    //   $data=[
    //     "title"=>$result->title,
    //     "content"=>$result->content,
    //     "cover"=>$result->cover
    //   ];

    //  if( $this->userModel->createArticle($data)){
    //    return true;
    //  }else{
    //     print_r(json_encode("error"));
    //  }

    // test 1
    // $file_name = $_FILES['file']['name'];
    // // new name for image
    // if ($file_name != null) {
    //     $new_name = time() . $file_name;
    // } else {
    //     $new_name = null;
    // }
    // // image path
    // $file_tmp = $_FILES['file']['tmp_name'];
    // // store image in folder
    // // $upload_folder = 'uploads/PostImage/';
    // $upload_folders = 'C:/youcode/Mouqaf.ma/front-end/mouqaf/public/uploads/PostImage/';
    // // file extension of image only jpg, png, jpeg
    // $extension = pathinfo($file_name, PATHINFO_EXTENSION);
    // // filter image extension
    // if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == '') {
    //     // move image to folder
    //     $moveFile = move_uploaded_file($file_tmp, $upload_folders . $new_name);

    // }

    // test 2


    // echo "test1";

    $content = $_POST['content'];
    $title = $_POST['title'];
    $filename = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];


    // var_dump($file_tmp);
    $upload_folders = 'C:\wamp64\www\filRougeImg/';
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == '')
     {
      
      $moveFile = move_uploaded_file($file_tmp, $upload_folders . $filename);

      if ($moveFile) {
        $data = [
          "title" => $title,
          "content" => $content,
          "cover" => $filename,
          "category_id" => $_POST['category_id']
        ];
        if ($this->userModel->createArticle($data)) {

          print_r(json_encode(array(
            "message" => "success",
          )));

        } else {
          print_r(json_encode(array(
            "message" => "error",
          )));
        }

      }
      
    } else {
      echo "test3";
      echo json_encode(array(
        "message" => "failure",
      ));
    }
  }

  //function to get specific article
  public function getArticle()
  {
    $result = json_decode(file_get_contents('php://input'));

    // $id = $result->id;

    $data=[
      "id"=>$result->id,
    ];
    

    $article = $this->userModel->getArticle($data);
    print_r(json_encode($article));

  }

  //function to post comment
  public function postComment()
  {
    $result = json_decode(file_get_contents('php://input'));

    $id = $result->UID;
    $article_id = $result->article_id;
    $comment = $result->comment;

    $data = [
      "UID" => $id,
      "comment" => $comment ,
      "article_id" => $article_id
    ];
    // echo json_encode($id);
    // $this->userModel->postComment($data);
    if ($this->userModel->postComment($data)) {
      print_r(json_encode(array(
        "message" => "success",
      )));
    } else {
      print_r(json_encode(array(
        "message" => "error",
      )));
    }


    // print_r(json_encode(array(
    //       "message" => $data['comment'],
    //     )));

  }

  //function to get all comments
  public function getComments()
  {
    $result = json_decode(file_get_contents('php://input'));

    $id = $result->id;

    $comments = $this->userModel->getComments($id);
    print_r(json_encode($comments));

  }

//function to get all categories
  public function getCategories()
  {
    $categories = $this->userModel->getCategories();
    print_r(json_encode($categories));
  }
   




  public function createUserSession($user)
  {
    $_SESSION['user_id'] = $user->id;
    // $_SESSION['user_email'] = $user->email;
    // $_SESSION['user_name'] = $user->name;
    // redirect('posts');
  }

  public function logout()
  {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    session_destroy();
    redirect('users/login');
  }
}

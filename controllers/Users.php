<?php

    require'vendor/autoload.php';
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

  class Users extends Controller {
    public function __construct(){
      $this->userModel = $this->model('User');
    }

    public function register(){
      // Check for POST
        $result = json_decode(file_get_contents('php://input'));

        // split string
        $arr1 = str_split($result->PersName, 2);
        $arr2 = str_split($result->FamName, 2);
        $arr3 = str_split($result->NID, 2);

        //Generate a random string.
        $token = openssl_random_pseudo_bytes(10);

        //Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);

        // generate custom token
        $token = $arr1[0] . $arr2[0] . $arr3[0] . $token;

        // Init data
        $data =[
          'PersName' => $result->PersName,
          'FamName' => $result->FamName,
          'NID'=>$result->NID,
          'email' => $result->email,
           'reference'=> $token,
          'name_err' => '',
          'email_err' => '',

        ];

        // Validate Email
        if(empty($data['email'])){
          $data['email_err'] = 'Please enter email';
        } else {
          // Check email
          if($this->userModel->findUserByEmail($data['email'])){
            $data['email_err'] = 'Email is already taken';
          }
        }


        // Make sure errors are empty
        if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
          // Validated
          
          

          // Register User
          if($this->userModel->registerModel($data)){
          
              
              // echo json_encode($this->userModel->registerModel($data));
             echo json_encode( array(
                "reference"=> $data['reference']
             ));
          } else {
              return false;
          }

        } else {
          
        }


    }

    public function login()
    {
        $result = json_decode(file_get_contents('php://input'));

        $reference = $result->reference;

        // Make sure errors are empty
        if (!empty($reference)) {
            // Validated
            // Check and set logged in user
            $loggedInUser = $this->userModel->login($reference);

            if ($loggedInUser){
                $ID = $this->userModel->getUserId($reference);
                $secret = 'secret_key';
                $date = new DateTimeImmutable();
                $expire_at = $date->modify('+1 minutes')->getTimestamp();
                $domainName = "localhost";
                $request_data = [
                    'iat'=> $date->getTimestamp(),
                    'iss'=> $domainName,
                    'nbf'=> $date->getTimestamp(),
                    'exp'=> $expire_at,
                    'id'=> $ID
                ];

                $token = JWT::encode(
                    $request_data,
                    $secret,
                    'HS512'
                );

                echo json_encode(
                    array(
                        'message' =>"login success",
                        'token' => $token,
                        'expire'=>$expire_at,
                        'id'=> $ID
                    )
                );
            }

           }
        }


    public function createUserSession($user){
      $_SESSION['user_id'] = $user->id;
     // $_SESSION['user_email'] = $user->email;
     // $_SESSION['user_name'] = $user->name;
     // redirect('posts');
    }

    public function logout(){
      unset($_SESSION['user_id']);
      unset($_SESSION['user_email']);
      unset($_SESSION['user_name']);
      session_destroy();
      redirect('users/login');
    }


  }
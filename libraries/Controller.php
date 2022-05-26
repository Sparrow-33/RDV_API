<?php
   require_once 'vendor/autoload.php';
   use \Firebase\JWT\JWT;
   use Firebase\JWT\Key;



    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow: POST, GET, PUT, DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers , Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With,');
  class Controller {
    public $secret = 'secret_key';
    // Load model
    public function model($model){
      // Require model file
      require_once '../app/models/' . $model . '.php';

      // Instatiate model
      return new $model();
    }

    // Load view
    public function view($view, $data = []){
      // Check for view file
      if(file_exists('../app/views/' . $view . '.php')){
        require_once '../app/views/' . $view . '.php';
      } else {
        // View does not exist
        die('View does not exist');
      }
    }


          function getAuthorizationHeader(){
              $headers = null;
              if (isset($_SERVER['Authorization'])) {
                  $headers = trim($_SERVER["Authorization"]);
              }
              else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
                  $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
              } elseif (function_exists('apache_request_headers')) {
                  $requestHeaders = apache_request_headers();
                  // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
                  $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
                  //print_r($requestHeaders);
                  if (isset($requestHeaders['Authorization'])) {
                      $headers = trim($requestHeaders['Authorization']);
                  }
              }
              return $headers;
          }

      function getBearerToken() {
          $headers = $this->getAuthorizationHeader();
          // HEADER: Get the access token from the header
          if (!empty($headers)) {
              if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                  return $matches[1];
              }
          }
          return null;
      }

      public function validateToken($token){
           $tokenParts =explode('.',$token);
          // $header = base64_decode($tokenParts[0]);
           $payload = base64_decode($tokenParts[0]);

           $expiration = json_decode($payload->exp);
           $is_token_expired = ($expiration - time()) < 0;

           if ($is_token_expired){
               return false;
           }else{
               return true;
           }
      }
  }
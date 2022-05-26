<?php
   class Appointments extends Controller{
       private $apptModel ;

       public function __construct(){
           $this->apptModel = $this->model('AppointmentModel');
       }

       public function MyAppointments($id){
         //  $result = json_decode(file_get_contents('php://input'));
       //    $id = $result->id;
           print_r(json_encode( $this->apptModel->getAppointments($id)));
       }

       public function time(){
           //  $result = json_decode(file_get_contents('php://input'));

           print_r(json_encode($this->apptModel->getTime($this->data->selectedDate)));
       }

       public function getAppointment(){
         //  $result = json_decode(file_get_contents('php://input'));
          // $header = $this->getAuthorizationHeader();
           $token = $this->getBearerToken();
           if($this->validateToken($token)){
               print_r(json_encode("true"));
           }else{
               print_r(json_encode("false"));

           }

       }

       public function getSingleAppointment($UID){
             $result = json_decode(file_get_contents('php://input'));
              $id= $result->id;
           print_r(json_encode( $this->apptModel->getSingleAppointments($UID, $id)));
       }



       public function takeAppointment(){
           $result = json_decode(file_get_contents('php://input'));

           $data=[
               "pid"=> $result->id,
               "date"=>$result->date,
               "cid"=> $result->selected,
               "sujet"=>filter_var($result->sujet,FILTER_SANITIZE_STRING)
           ];

          if ( $this->apptModel->takeAppointment($data)){
              return true;
          }else{
              return false;
          }

       }

       public function deleteAppointment(){
           $result = json_decode(file_get_contents('php://input'));

           if ( $this->apptModel->deleteAppointment($result->id)){
               return true;
           }else{
               return false;
           }
       }

       public function updateAppointment(){
           $result = json_decode(file_get_contents('php://input'));

           $data=[
               "id"=>$result->id,
               "date"=>$result->date,
               "cid"=> $result->selected,
               "sujet"=>filter_var($result->sujet,FILTER_SANITIZE_STRING)
           ];

           if ( $this->apptModel->updateAppointment($data)){
               return true;
           }else{
               return false;
           }

       }




   }

<?php
    class AppointmentModel{
        private $db;

        public function __construct(){

            $this->db = new Database;
        }

        public function getAppointments($id){

            $this->db->query('SELECT R.IDR, R.PID ,R.Sujet, R.creation, R.dateRDV, R.CID, C.begin FROM rendezvous R, creneau C WHERE R.PID = :id AND R.CID = C.CID AND R.STATUS = 0');
            $this->db->bind(':id',$id);
          return  $this->db->resultSet();

        }

        public function getSingleAppointments($UID, $id){
            $this->db->query('SELECT R.IDR, R.PID ,R.Sujet, R.creation, R.dateRDV, R.CID, C.begin , C.end FROM rendezvous R, creneau C WHERE R.PID = :id AND R.CID = C.CID AND R.IDR = :IDR');
            $this->db->bind(':id',$UID);
            $this->db->bind(':IDR', $id);
            return  $this->db->resultSet();



        }

        public function deleteAppointment($id){
            $this->db->query('DELETE from rendezvous WHERE IDR = :id');
            $this->db->bind(':id', $id);

            if ($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function getTime($date){
            $this->db->query('SELECT * FROM creneau 
                                    WHERE NOT EXISTS 
                                        (SELECT * FROM rendezvous WHERE rendezvous.CID = creneau.CID AND rendezvous.dateRDV = :date)');

            $this->db->bind(':date', $date);
            return  $this->db->resultSet();
        }

        public function takeAppointment($data){

            $this->db->query('INSERT INTO
                                          rendezvous(Sujet, dateRDV, CID, PID )
                                          VALUES (:sujet, :dateRDV, :CID, :PID)');
            $this->db->bind(':sujet',$data['sujet']);
            $this->db->bind(':dateRDV', $data['date']);
            $this->db->bind(':CID', $data['cid']);
            $this->db->bind(':PID', $data['pid']);

            if ($this->db->execute()){
                return true;
            }else{
                return false;
            }

        }




        public function updateAppointment($data){

            $this->db->query('UPDATE rendezvous
                                 SET Sujet = :sujet,
                                     dateRDV = :dateRDV,
                                     CID = :CID
                                 WHERE IDR = :IDR   
                                     ');
            $this->db->bind(':IDR', $data['id']);
            $this->db->bind(':sujet',$data['sujet']);
            $this->db->bind(':dateRDV', $data['date']);
            $this->db->bind(':CID', $data['cid']);

            if ($this->db->execute()){
                return true;
            }else{
                return false;
            }

        }


    }

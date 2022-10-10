<?php
    require_once("MySql.php");

    class InscriptionDB extends MySql {

        // CONFIG METHODS
        public function changeIState($state) {
            $this->request(
                "UPDATE website_config SET inscription = :state", 
                array(":state" => $state)
            );
        }

        public function getIState() { 
            // checks if inscription is OPEN or CLOSED (boolean)
            
            $result = $this->request(
                "SELECT inscription FROM website_config", 
                array(), 
                1
            );

            return $result["inscription"];
        }

        // CRUD METHODS

        public function get($CIN) {
            return $this->request(
                "SELECT * FROM liste_inscription WHERE CIN = :CIN",
                array(':CIN' => $CIN),
                1
            );
        }

        public function getAll() {
            return $this->request("
            SELECT l.cin as cin, nomprenom, role, case when u.CIN is NULL THEN 0 ELSE 1 END as isSubscribed
            FROM liste_inscription as l
            LEFT JOIN (
                SELECT cin
                FROM utilisateur
            ) as u ON u.CIN = l.cin", array(), 2);
        }

         public function insert($cin, $nomprenom, $role) {
            $query = "INSERT INTO liste_inscription(cin, nomprenom, role) VALUES (:cin, :nomprenom, :role)"; 
            $secureArray = array( 
                ":cin" => $cin,
                ":nomprenom" => $nomprenom,
                ":role" => $role
            );

            $this->request($query, $secureArray);
        }

        public function update($oldcin, $cin, $nomprenom, $role) {
            $query = "UPDATE liste_inscription SET cin = :cin, nomprenom = :nomprenom, role = :role WHERE cin = :oldcin"; 

            $secureArray = array( 
                ":cin" => $cin,
                ":nomprenom" => $nomprenom,
                ":role" => $role,
                ":oldcin" => $oldcin
            );

            $this->request($query, $secureArray);
        }

        public function delete($cin) {
            $query = "DELETE FROM liste_inscription WHERE cin = :cin"; 
            $secureArray = array( 
                ":cin" => $cin
            );

            $this->request($query, $secureArray);
        }

        public function clear() {
            $this->request("TRUNCATE TABLE liste_inscription", array());
        }

        /* QUERY LIST */

        public function exists($CIN) {
            return $this->request(
                "SELECT * FROM liste_inscription WHERE CIN = :CIN",
                array(':CIN' => $CIN),
                0
            );
        }

        public function getRole($CIN) {
            $resultList = $this->request(
                "SELECT role FROM liste_inscription WHERE CIN = :CIN",
                array(':CIN' => $CIN),
                1
            );
            
            // "Erreur! Cette CIN n'existe pas dans la liste!"
            if ($resultList == -1) {
                return false;
            } else {
                return $resultList["role"];
            }
        }
    }
    
?>
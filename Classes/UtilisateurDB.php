<?php
    require_once("MySql.php");

    class UtilisateurDB extends MySql {

        // INCRIPTION CHECKERS

        public static function getIState() { 
            // checks if inscription is OPEN or CLOSED (boolean)
            MySql::start_connection();
            $result = MySql::request(
                "SELECT inscription FROM website_config", array(), 1
            );
            MySql::close_connection();
            // var_dump($result);
            return $result["inscription"];
        }

        public static function userExists($CIN) {
            MySql::start_connection();
            $resultUser = MySql::request(
                "SELECT CIN FROM utilisateur WHERE CIN = :CIN",
                array(':CIN' => $CIN),
                0
            );
            MySql::close_connection();
            // "Erreur! Cette CIN déja inscrit auparavant!"
            return $resultUser;
        }

        public static function listeExists($CIN) {
            MySql::start_connection();
            $resultList = MySql::request(
                "SELECT CIN, role FROM liste_inscription WHERE CIN = :CIN",
                array(':CIN' => $CIN),
                1
            );
            MySql::close_connection();
            
            // "Erreur! Cette CIN n'existe pas dans la liste!"
            if ($resultList == -1) {
                return false;
            } else {
                return $resultList["role"];
            }
        }

        // METHODS
        public static function insert($user) {
            mySql::start_connection();
            $query = "INSERT INTO utilisateur(CIN, nom, prenom, sexe, adresse, dateNaissance, email, password, role) VALUES (:CIN, :nom, :prenom, :sexe, :adresse, :dateNaissance, :email, :password, :role)"; 
            $secureArray = array( 
                ":CIN" => $user->CIN,
                ":nom" => $user->nom,
                ":prenom" => $user->prenom,
                ":sexe" => $user->sexe,
                ":adresse" => $user->adresse,
                ":dateNaissance" => $user->dateNaissance,
                ":email" => $user->email,
                ":password" => password_hash($user->password, PASSWORD_DEFAULT),
                ":role" => $user->role
            );

            MySql::request($query, $secureArray);
            mySql::close_connection();
        }

        public static function update($user) {
            mySql::start_connection();
            $query = "UPDATE utilisateur SET nom = ?, prenom = ?, sexe = ?, adresse = ?, dateNaissance = ? WHERE CIN = ?"; 
            $secureArray = array( 
                $user->nom,
                $user->prenom,
                $user->sexe,
                $user->adresse,
                $user->dateNaissance,
                $user->CIN
            );

            MySql::request($query, $secureArray);
            mySql::close_connection();
        }
    }
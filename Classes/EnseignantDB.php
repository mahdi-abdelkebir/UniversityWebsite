<?php
    require_once("MySql.php");

    class EnseignantDB extends MySql {

        // METHODS
        public static function insert($ensg) {
            mySql::start_connection();
            $query = "INSERT INTO enseignant(matricule) VALUES (:matricule)"; 
            $secureArray = array( 
                ":matricule" => $ensg->getMatricule()
                // ":matiere" => $ensg->getMatiere()
            );

            MySql::request($query, $secureArray);
            mySql::close_connection();
        }

        public static function update($ensg) {
            // mySql::start_connection();
            // $query = "UPDATE enseignant SET matiere = :matiere WHERE marticule = :marticule"; 
            // $secureArray = array( 
            //     // ":matiere" => $ensg->getMatiere(),
            //     ":marticule" => $ensg->getMatricule()
            // );

            // MySql::request($query, $secureArray);
            // mySql::close_connection();
        }
    }
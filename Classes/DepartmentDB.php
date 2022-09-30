<?php
    require_once("MySql.php");

    class DepartmentDB extends MySql {

        // METHODS
         public static function insert($dep) {
            mySql::start_connection();
            $query = "INSERT INTO department(nom) VALUES (:nom)"; //isActive for later
            $secureArray = array( 
                ":nom" => $dep->getNom(),
            );

            MySql::request($query, $secureArray);
            mySql::stop_connection();
        }
    }
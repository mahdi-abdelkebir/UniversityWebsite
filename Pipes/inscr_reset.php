<?php
    session_start();
    
    if (isset($_SESSION["login"]) && $_SESSION["login"]["role"] == 0) {
        require_once("../Classes/AdminDB.php");
        $adminDB = new AdminDB();
        $adminDB->clearList();
    }

    header("location: ../adm_inscription.php");
?>
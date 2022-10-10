<?php
    // MAIN OBJECTIVE: check authentification, get user object OTHERWISE log-out.

    require_once($_SERVER['DOCUMENT_ROOT']."/config.php");

    // Check logged-in
    if (isset($_SESSION["login"])) {
        function deconnexion() {
            header("location: /Pipes/deconnexion.php");
        }

        // Check authentification
        if (isset($authRole) && $_SESSION["login"]["role"] != $authRole) {
            header("location: /User/redirect.php");
        } elseif (isset($leastRole) && $_SESSION["login"]["role"] > $leastRole) {
            header("location: /User/redirect.php");
        }

        // Get user object
        $matricule = $_SESSION["login"]["matricule"];
        require_once(ROOT."/Classes/UtilisateurDB.php");
        $utilisateurDB = new UtilisateurDB();
        $user = $utilisateurDB->getUserByMatricule($matricule);

        if ($user == -1) { // if user doesn't exist anymore
            deconnexion();
        } else {
            // if role user, get department and merge.
            if ($_SESSION["login"]["role"] == 3) {
                require_once(ROOT."/Classes/EtudiantDB.php");
                $etudiantDB = new EtudiantDB();
                $etd = $etudiantDB->get($matricule);

                if ($etd != 1) {
                    $user = array_merge($user, $etd);
                } else {
                    deconnexion();
                }
            } else {
                // other roles
            }
        }
    } else {
        header("location: /index.php");
    }

?>
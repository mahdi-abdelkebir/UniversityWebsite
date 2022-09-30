<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Assets/css/inscription.css">
    <link rel="stylesheet" href="Assets/css/general.css">
    <script src="Assets/js/inscription.js"></script>
    <title>Inscription</title>
</head>
<body>
   <?php 
   
   require_once("Classes/UtilisateurDB.php");
    $enabled_inscription = UtilisateurDB::getIState();
    
    if (isset($_POST["INSCRIPTION_CIN"])){

        $cin = $_POST["INSCRIPTION_CIN"];
    
        if ($enabled_inscription == 0) {
            header("Location: closed.html");
        } else if (!is_numeric($cin)) {
            $error = "Erreur! Entrer seulement des nombres!";
        } else if (UtilisateurDB::userExists($cin)) {
            $error = "Erreur! Cette CIN déja inscrit auparavant!";
        } else {
            $result = UtilisateurDB::listeExists($cin);
            if ($result == false) {
                $error = "Erreur! Cette CIN n'existe pas dans la liste!";
            } else {
                session_start();
                $_SESSION["REGISTRATION_ROLE"] = $result;
                header("Location: form.php");
                session_write_close();
            }
        }
    }

    ?>

    <!--logo and name--> 
    <div>
        <img src="Assets/imgs/LOGO.png" alt="LOGO" id="logo">
    <h1 id="nom_uni">NOM DE L’INSTITUTE </h1>
    </div>

    <!--the form and title--> 
    <div>
        <p id="bienvenue">BIENVENUE</p>
        <p id="title_2">Presenter votre CIN pour incrire </p>
        <form action="" method="post">
            <input id="cin" type="text" name="INSCRIPTION_CIN" placeholder="CIN" <?php if ($enabled_inscription == 0) echo "disabled";
            ?>>

            <?php 
                if (isset($error)) {
                    echo "<p id = 'error_message'> $error </p>";
                }
            ?>
            
        </form>
        <p id="alt_connect"><span id="part1_conn">Déja inscrit? Appuier ici pour </span><a href="" id="part2_conn"> se connecter.</a></p>
    </div>

    <!--background img--> 
    <img src="Assets/imgs/p_progresse.png" alt="person" id="b_img">
</body>
</html>
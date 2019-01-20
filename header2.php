<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Made in World &mdash; Le monde à portée d'une boite</title>
    <link rel="icon" type="image/png" href="images/favicon.png">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1,minimum-scale=1">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Roboto+Mono:300,400,500">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css"
          integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP"
          crossorigin="anonymous">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css"> <!-- Permet le zoom au survol de souris -->
    <link rel="stylesheet" href="css/aos.css"> <!-- Permet les apparitions des blocs par progression du scroll -->
    <link rel="stylesheet" href="css/style.css">
    <script src='https://api.mapbox.com/mapbox-gl-js/v0.52.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v0.52.0/mapbox-gl.css' rel='stylesheet' />
</head>

<body>


<h2 class="logo"><a href="index.php"><img class="logob" src="images/logoMIW.png" align="center"></a></h2>

<nav role='navigation'>
    <div id="menuToggle">

        <input type="checkbox"/>

        <span class="burgerm"></span>
        <span class="burgerm"></span>
        <span class="burgerm"></span>

            <ul id="menu">
                <div class="container pullRight">
                    <li><a href="produits.php">Nos Boxs</a></li><br/>
                    <li><a href="apropos.php">Qui-Sommes Nous</a></li><br/>
                    <?php if (isset($_SESSION['loggedin'])) { // Si l'utilisateur est connecté, renvoi vers la page de commentaire
                        ?><li><a href="livre.php">Livre d'Or</a></li><br/><?php
                    } else { // Sinon, renvoi vers la page de connexion pour valider un commentaire
                        ?><li><a href="connexion.php?commentaire=true">Livre d'Or</a></li><br/><?php
                    } ?>
                    <li><a href="contact.php">Contact</a></li><br/>
                    <br/><br/>
                    <?php if(isset($_SESSION['loggedin'])){ // Si l'utilisateur s'est connecté, afficher la page de profil
                      ?><li><i class="fas fa-user" style='padding-right:20px;'></i><a href="compte.php"><?php echo htmlspecialchars($_SESSION["identifiant"]); ?></a></li><?php
                    } else{ // Sinon, afficher le bouton d'inscription / connexion
                      ?><li><i class="fas fa-user" style='padding-right:20px;' ></i><a href="inscription.php">S'inscrire/Login </a></li><br/>  <?php
                    }?>
                    <?php if(isset($_SESSION['admin'])){ // Si le compte utilisateur est un admin
                      ?><li><i class="fas fa-tools" ></i><a href="admincommentaire.php"> Administration</a></li> <?php
                    }
                    ?>
            </div>
        </ul>
    </div>
</nav>

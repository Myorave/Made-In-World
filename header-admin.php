<?php
session_start();

if (!isset($_SESSION['admin'])) { // Si le compte utilisateur n'est pas un admin
    header("Location:index.php"); // Retour à la page d'accueil
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <title>Administration &mdash; Made in World</title>
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
    <link rel="stylesheet" href="css/alertify.min.css">
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
                  <li><a href="admincommentaire.php">Commentaires</a></li><br>
                  <li><a href="adminclient.php">Clients</a></li><br>
                  <li><a href="admincommande.php">Commandes</a></li><br><br>
                  <li><i class="fas fa-user"></i><a href="logout.php">Deconnexion</a></li>
                </div>
            </ul>
    </div>
</nav>

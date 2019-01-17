<?php
  session_start();

if(!isset($_SESSION['admin'])){ // Si le compte utilisateur n'est pas un admin
  header("Location:index.php"); // Retour à la page d'accueil
}
?>

<!DOCTYPE html>
<html lang="fr">

  <head>
    <title>Administration &mdash; Made in World</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Roboto+Mono:300,400,500">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/alertify.min.css" />

  </head>

  <body>

    <div class="site-wrap">

      <div class="site-navbar-wrap bg-white">
        <div class="site-navbar bg-light">
          <div class="container py-1">
            <div class="row align-items-center">
              <div class="col-2">
                <h2 class="mb-0 site-logo"><a href="index.php"><img class="logo" src="images/logo.png" align="center"></a></h2>
              </div>
              <div class="col-10">
                <nav class="site-navigation text-right" role="navigation">
                  <div class="container">
                    <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>

                    <ul class="site-menu js-clone-nav d-none d-lg-block">
                      <li><a href="admincommentaire.php">Commentaires</a></li>
                      <li><a href="adminclient.php">Clients</a></li>
                      <li><a href="admincommande.php">Commandes</a></li>
                      <li><i class="fas fa-user"></i><a href="logout.php">Deconnexion</a></li>
                    </ul>

                  </div>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>

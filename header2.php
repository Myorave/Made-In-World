<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Made in World &mdash; Le monde à portée d'une boite</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1,minimum-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Roboto+Mono:300,400,500">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP"
        crossorigin="anonymous">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css"> <!-- Permet le zoom au survol de souris -->
    <link rel="stylesheet" href="css/aos.css"> <!-- Permet les apparitions des blocs par progression du scroll -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>


 <h2 class="logo"><a href="index.php"><img class="logo" src="images/logo.png" align="center"></a></h2>

    <nav role='navigation'>
        <div id="menuToggle">

            <input type="checkbox" />

            <span class="burgerm"></span>
            <span class="burgerm"></span>
            <span class= "burgerm"></span>

            <ul id="menu">
                <div class="container pullRight">
                    <li><a href="produits.php">Nos Boxs</a></li></Br>
                    <li><a href="apropos.php">Qui-sommes nous</a></li></Br>
                    <li><a href="livre.php">Livre d'or</a></li></Br>
                    <li><a href="contact.php">Contact</a></li></Br>
                    <br/>
                    <?php if(isset($_SESSION['loggedin'])){ // Si l'utilisateur s'est connecté, afficher le bouton de deconnexion
                      ?><li><i class="fas fa-user"></i><a href="compte.php"><?php echo htmlspecialchars($_SESSION["identifiant"]); ?></a></li><?php
                    } else{ // Sinon, afficher le bouton d'inscription / connexion
                      ?><li><i class="fas fa-user"></i><a href="inscription.php">S'inscrire/Login </Br></a></li>  <?php
                    }?>
                    <?php if(isset($_SESSION['admin'])){ // Si le compte utilisateur est un admin
                      ?><li><i class="fas fa-tools"></i><a href="admincommentaire.php"> Administration</a></li> <?php
                    }
                    ?>
                </div>
            </ul>
        </div>
    </nav>
</body>
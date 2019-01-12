<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Made in World &mdash; Le monde à portée d'une boite</title>
    <meta charset="utf-8">

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




    <div class="container yellow pullRight">
        <nav role="navigation">
            <div class="menu-toggle"><span>Menu</span></div>
            <ul class="menu">
                <li><a href="produits.php"><span>Nos box</span></a></li>
                <li><a href="apropos.php"><span>Qui sommes nous? </span></a></li>
                <li><a href="livredor.php"><span>Livre d'or</span></a></li>
                <li><a href="contact.php"><span>Contact</span></a></li>

                <?php if(isset($_SESSION['loggedin'])){ // Si l'utilisateur s'est connecté, afficher le bouton de deconnexion
                      ?>
                <li><i class="fas fa-user"></i><a href="compte.php">
                        <?php echo htmlspecialchars($_SESSION["identifiant"]); ?></a></li>
                <?php
                    } else{ // Sinon, afficher le bouton d'inscription / connexion
                      ?>
                <li><i class="fas fa-user"></i><a href="inscription.php">S'inscrire/Login</a></li>
                <?php
                    }?>
                <?php if(isset($_SESSION['admin'])){ // Si le compte utilisateur est un admin
                      ?>
                <li><i class="fas fa-tools"></i><a href="admincommentaire.php">Administration</a></li>
                <?php
                    }
                    ?>
            </ul>



    </div>
    </nav>
    <script type="text/javascript">
        var menu = document.querySelector(".menu"),
            toggle = document.querySelector(".menu-toggle");

        function toggleToggle() {
            toggle.classList.toggle("menu-open");
        };

        function toggleMenu() {
            menu.classList.toggle("active");
        };

        toggle.addEventListener("click", toggleToggle, false);
        toggle.addEventListener("click", toggleMenu, false);
    </script>
</body>
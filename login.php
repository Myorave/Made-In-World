<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="UTF-8">
      <title>Bienvenue</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
      <style type="text/css">
          body{ font: 14px sans-serif; text-align: center; }
      </style>
  </head>
  <body>
      <div class="page-header">
          <h1>Bienvenue <b><?php echo htmlspecialchars($_SESSION["identifiant"]); ?></b> sur Made in World</h1>
          <h2>Vous êtes un
            <?php if(isset($_SESSION['admin'])){ // Si le compte utilisateur est un admin
              ?>administrateur.</h2>
              <?php } else { ?>
                utilisateur lambda.</h2>
                <?php }
            ?>
      </div>
      <p>
          <a href="resetmdp.php" class="btn btn-warning">Réinitialiser son mot de passe</a>
          <a href="logout.php" class="btn btn-danger">Se déconnecter</a>
      </p>
      <p>
          <a href="index.php" class="btn btn-success">Page d'accueil</a>
      </p>
  </body>
</html>

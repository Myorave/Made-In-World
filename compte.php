<?php
include("header2.php");

// Verification si l'utilisateur est deja loggé,
// Si oui, redirection vers la page d'accueil
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>

<div class="container">
    <h1>Bienvenue <b><?php echo htmlspecialchars($_SESSION["identifiant"]); ?></b></h1>
      <p>
        <a href="resetmdp.php" class="btn btn-warning">Réinitialiser son mot de passe</a>
        <a href="logout.php" class="btn btn-danger">Se déconnecter</a>
      </p>
</div>

<?php
include("footer.php");
?>

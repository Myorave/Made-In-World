<?php
include("header2.php");

// Verification si l'utilisateur est deja loggé,
// Si oui, redirection vers la page d'accueil
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

// Inclusion du fichier config
require_once "config.php";

// Je définis les variables et les initialisent avec des valeurs vides
$new_mdp = $confirm_mdp = "";
$new_mdp_err = $confirm_mdp_err = "";

// Execution du formulaire
if($_SERVER["REQUEST_METHOD"] == "POST"){

  // Validation du nom d'utilisateur
    if(empty(trim($_POST["new_mdp"]))){
        $new_mdp_err = "Veuillez entrer un nouveau mot de passe.";
    } elseif(strlen(trim($_POST["new_mdp"])) < 6){
        $new_mdp_err = "Le mot de passe doit contenir au moins 6 caractères.";
    } else{
        $new_mdp = trim($_POST["new_mdp"]);
    }

    // Validation du mot de passe de confirmation
    if(empty(trim($_POST["confirm_mdp"]))){
        $confirm_mdp_err = "Veuillez confirmer votre mot de passe.";
    } else{
        $confirm_mdp = trim($_POST["confirm_mdp"]);
        if(empty($new_mdp_err) && ($new_mdp != $confirm_mdp)){
            $confirm_mdp_err = "Le mot de passe de confirmation est différent.";
        }
    }

    // Vérification des erreurs d'input avant insertion dans la BDD
    if(empty($new_mdp_err) && empty($confirm_mdp_err)){
        // Préparation d'une requete UPDATE
        $sql = "UPDATE users SET password = :password WHERE id = :id";

        if($stmt = $pdo->prepare($sql)){
            // Liaison des variables à la requete comme parametres
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);

            // Set des parametres
            $param_password = password_hash($new_mdp, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            // Tentative d'execution de la requete
            if($stmt->execute()){
                // Mot de passe mis à jour avec succes.
                // Destruction de la session et redirection de la page de login
                session_destroy();
                header("location: connexion.php");
                exit();
            } else{
                echo "Une erreur est survenue. Veuillez recommencer.";
            }
        }

        // Fermeture de la requete
        unset($stmt);
    }

    // Fermeture de la connexion
    unset($pdo);
}
?>

<div class="ligne"></div>
<div class="site-section  "></div>
<div class="wrapper">
    <h2>Réinitialisation du mot de passe</h2>
    <p>Veuillez remplir le formulaire pour réinitaliser votre mot de passe.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($new_mdp_err)) ? 'has-error' : ''; ?>">
            <label>Nouveau mot de passe</label>
            <input type="password" name="new_mdp" class="form-control" value="<?php echo $new_mdp; ?>">
            <span class="help-block"><?php echo $new_mdp_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_mdp_err)) ? 'has-error' : ''; ?>">
            <label>Confirmation du mot de passe</label>
            <input type="password" name="confirm_mdp" class="form-control">
            <span class="help-block"><?php echo $confirm_mdp_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Réinitialiser">
            <a class="btn btn-link" href="index.php">Annuler</a>
        </div>
    </form>
</div>

<?php
include("footer.php");
?>

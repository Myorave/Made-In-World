<?php
include("header2.php");

// Verification si l'utilisateur est deja loggé,
// Si oui, redirection vers la page d'accueil
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

// Inclusion du fichier config.php
require_once "config.php";

// Je définis les variables et les initialisent avec des valeurs vides
$identite = $password = "";
$id_err = $password_err = "";

// Execution du formulaire
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validation du nom d'utilisateur
    if(empty(trim($_POST["identifiant"]))){
        $id_err = "Veuillez entrer votre identifiant.";
    } else{
        $identite = trim($_POST["identifiant"]);
    }

    // Verification si le mdp est vide
    if(empty(trim($_POST["mdp"]))){
        $password_err = "Veuillez entrer votre mot de passe.";
    } else{
        $password = trim($_POST["mdp"]);
    }

    // Validation des identifiants
    if(empty($id_err) && empty($password_err)){
        // Preparation de la requete SELECT
        $sql = "SELECT id, identifiant, password, admin FROM users WHERE identifiant = :identifiant";

        if($stmt = $pdo->prepare($sql)){
            // Liaison des variables à la requete comme parametres
            $stmt->bindParam(":identifiant", $param_id, PDO::PARAM_STR);

            // Set des parametres
            $param_id = trim($_POST["identifiant"]);

            // Tentative d'execution de la requete préparée
            if($stmt->execute()){
                // Verification si le mdp existe, si oui verification du mdp
                if($stmt->rowCount() == 1){

                    if($row = $stmt->fetch()){ // récupérer le nom des label dans la table users de la BDD
                        $id = $row["id"];
                        $identite = $row["identifiant"];
                        $hashed_mdp = $row["password"];
                        $droit_admin =$row["admin"];

                        if(password_verify($password, $hashed_mdp)){
                            // Le MDP est correct, donc initialisation d'une session
                            session_start();

                            // Enregistrement des données dans les variables de sessions
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["identifiant"] = $identite;
                            $_SESSION["admin"] = $droit_admin;

                            // Redirection vers la page de login
                            header("location: compte.php");
                        } else{
                            // Affichage d'une message d'erreur si le MDP n'est pas valide
                            $password_err = "Le mot de passe que vous avez entré n'est pas valide";
                        }
                    }
                } else{
                    // Display an error message if identifiant doesn't exist
                    $id_err = "Aucun compte trouvé avec cet identifiant.";
                }
            } else{
                echo "Une erreur est survenue. Veuillez recommencer.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
}
?>
<div class="site-section"></div>

<div class="container">
  <div class="row">
      <div class="col-md-7 col-lg-7 mb-4">
  		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  			<h2>Se connecter <small>sur Made in World</small></h2>

        <div class="form-group <?php echo (!empty($id_err)) ? 'has-error' : ''; ?>">
          <input type="text" name="identifiant" id="identifiant" class="form-control input-lg" placeholder="Identifiant" tabindex="1" value="<?php echo $identite; ?>">
          <span class="help-block"><?php echo $id_err; ?></span>
        </div>

  			<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
  				<input type="password" name="mdp" id="mdp" class="form-control input-lg" placeholder="Mot de passe" tabindex="2">
          <span class="help-block"><?php echo $password_err; ?>
        </div>

  			<div class="row">
  				<div class="col-xs-12 col-md-6"><input type="submit" value="Connexion" class="btn btn-primary btn-block btn-lg" tabindex="3"></div>
  			</div>
        <br />
        <p><a href="requetemdp.php">Mot de passe oublié ?</a></p>
  		</form>
  	</div>
  </div>
</div>

<div class="container">
  <div class="row">
      <div class="col-lg-4">
          <h2>Pas encore inscrit sur <b>Made in World</b> ?</h2>
  	</div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-md-6"><a href="inscription.php" class="btn btn-success btn-block btn-lg" tabindex="8">S'inscrire</a></div>
  </div>
</div>

<?php
include("footer.php");
?>

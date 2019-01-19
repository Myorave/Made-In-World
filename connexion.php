<?php
include("header2.php");

// Verification si l'utilisateur est deja loggé,
// Si oui, redirection vers la page d'accueil
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: /");
    exit;
}

// Création d'une variable de session "achat" permettant de renvoyer l'utilisateur vers la page de commande
if (isset($_GET['achat']) && !empty($_GET['achat'])) {
    $_SESSION["achat"] = 1;
}
// Création d'une variable de session "commentaire" permettant de renvoyer vers la page "livre.php"
if (isset($_GET['commentaire']) && !empty($_GET['commentaire'])) {
    $_SESSION["commentaire"] = 1;
}

// Inclusion du fichier config.php
require_once "config.php";

// Je définis les variables et les initialisent avec des valeurs vides
$identite = $password = "";
$id_err = $password_err = "";

// Execution du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validation du nom d'utilisateur
    if (empty(trim($_POST["identifiant"]))) {
        $id_err = "Veuillez entrer votre identifiant.";
    } else {
        $identite = trim($_POST["identifiant"]);
    }

    // Verification si le mdp est vide
    if (empty(trim($_POST["mdp"]))) {
        $password_err = "Veuillez entrer votre mot de passe.";
    } else {
        $password = trim($_POST["mdp"]);
    }

    // Validation des identifiants
    if (empty($id_err) && empty($password_err)) {
        // Preparation de la requete SELECT
        $sql = "SELECT id, identifiant, password, admin, prenom, nom FROM users WHERE identifiant = :identifiant";

        if ($stmt = $pdo->prepare($sql)) {
            // Liaison des variables à la requete comme parametres
            $stmt->bindParam(":identifiant", $param_id, PDO::PARAM_STR);

            // Set des parametres
            $param_id = trim($_POST["identifiant"]);

            // Tentative d'execution de la requete préparée
            if ($stmt->execute()) {

                // Verification si le mdp existe, si oui verification du mdp
                if ($stmt->rowCount() == 1) {

                    if ($row = $stmt->fetch()) { // récupérer le nom des label dans la table users de la BDD
                        $id = $row["id"];
                        $identite = $row["identifiant"];
                        $hashed_mdp = $row["password"];
                        $droit_admin = $row["admin"];
                        $nom_client = $row["nom"];
                        $prenom_client = $row["prenom"];


                        if (password_verify($password, $hashed_mdp)) {

                            // Enregistrement des données dans les variables de sessions
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["identifiant"] = $identite;
                            $_SESSION["admin"] = $droit_admin;
                            $_SESSION["nom"] = $nom_client;
                            $_SESSION["prenom"] = $prenom_client;

                            // Redirection vers la page de login ou de commande
                            if (isset($_SESSION['achat'])) {
                                unset($_SESSION['achat']); // destruction de la variable de session "achat"
                                header("location: produitachat.php");
                            } else if (isset($_SESSION['commentaire'])) {
                                unset($_SESSION['commentaire']); // destruction de la variable de session "commentaire"
                                header("location: livre.php");
                            } else {
                                header("location: /");

                            }

                        } else {
                            // Affichage d'une message d'erreur si le MDP n'est pas valide
                            $password_err = "Le mot de passe que vous avez entré n'est pas valide";
                        }
                    }
                } else {
                    // Display an error message if identifiant doesn't exist
                    $id_err = "Aucun compte trouvé avec cet identifiant.";
                }
            } else {
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
<div class="ligne"></div>
<div class="site-section"></div>

<div class="container">
    <div class="row">
        <div class="col-md-7 col-lg-7 mb-4">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h2>Se connecter
                    <small>sur Made in World</small>
                </h2>

                <div class="form-group <?php echo (!empty($id_err)) ? 'has-error' : ''; ?>">
                    <input type="text" name="identifiant" id="identifiant" class="form-control input-lg"
                           placeholder="Identifiant" tabindex="1" value="<?php echo $identite; ?>">
                    <span class="help-block"><?php echo $id_err; ?></span>
                </div>

                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <input type="password" name="mdp" id="mdp" class="form-control input-lg" placeholder="Mot de passe"
                           tabindex="2">
                    <span class="help-block"><?php echo $password_err; ?>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-6"><input type="submit" value="Connexion"
                                                           class="boutonprod3" tabindex="3"></div>
                </div>
                <br/>
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
        <div class="col-xs-12 col-md-6"><a href="inscription.php" class="boutonprod3" tabindex="8">S'inscrire</a>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>

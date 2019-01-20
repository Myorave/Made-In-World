<?php
include("header2.php");

use PHPMailer\PHPMailer\PHPMailer;

// Verification si l'utilisateur est deja loggé,
// Si oui, redirection vers la page d'accueil
if (!isset($_SESSION["identifiant"])) {
    header("location: /");
    exit;
}

// Inclusion du fichier config
require_once "config.php";

// Je définis les variables et les initialisent avec des valeurs vides
$adresse = $ville = $cp = $type = $prix = "";
$adresse_err = $ville_err = $cp_err = $type_err = "";

// Execution du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validation de l'adresse de livraison
    if (empty(trim($_POST["adresse"]))) {
        $adresse_err = "Veuillez entrer une adresse de livraison.";
    } else {
        $adresse = trim($_POST["adresse"]);
    }

    // Validation de la ville de livraison
    if (empty(trim($_POST["ville"]))) {
        $ville_err = "Veuillez entrer une ville de livraison.";
    } else {
        $ville = trim($_POST["ville"]);
    }

    // Validation du code postal
    if (empty(trim($_POST["cp"]))) {
        $cp_err = "Veuillez entrer un code postal.";
    } else {
        $cp = trim($_POST["cp"]);
    }

    // Validation du type de boite choisie
    if (empty(trim($_POST["type_boite"]))) {
        $type_err = "Veuillez choisir une box.";
    } else {
        $type = trim($_POST["type_boite"]);
        if ($type == "57932") {
            $description = "Boite Classique";
            $prix = 30;
        } else if ($type == "1987") {
            $description = "Boite Economique";
            $prix = 20;
        } else if ( $type == "984") {
            $description = "Boite Sur Mesure";
            $prix = 40;
        }
    }

    $nom_client = $_SESSION["prenom"] . " " . $_SESSION["nom"];

    // Validation des identifiants
    if (empty($adresse_err) && empty($ville_err) && empty($cp_err) && empty($type_err)) {

        // Préparation d'une requete INSERT
        $sql = "INSERT INTO commande (nom_livraison, addr_livraison, cp_livraison, ville_livraison, num_box, description_box, date_commande, prix)
                   VALUES (:nomclient, :adresse, :cp, :ville, :type, :description, NOW(), :prix)";    // fonction SQL qui me donne la date


        if ($stmt = $pdo->prepare($sql)) {
            // Liaison des variables à la requete comme parametres
            $stmt->bindParam(":nomclient", $nom_client, PDO::PARAM_STR);
            $stmt->bindParam(":adresse", $adresse, PDO::PARAM_STR);
            $stmt->bindParam(":cp", $cp, PDO::PARAM_STR);
            $stmt->bindParam(":ville", $ville, PDO::PARAM_STR);
            $stmt->bindParam(":type", $type, PDO::PARAM_STR);
            $stmt->bindParam(":description", $description, PDO::PARAM_STR);
            $stmt->bindParam(":prix", $prix, PDO::PARAM_STR);

            // Tentative d'execution de la requete
            if ($stmt->execute()) {

                // Envoi d'un message à l'administrateur pour le prévenir d'une commande

                $body_html = "Une nouvelle commande à été confirmée<br/><br/>
                                  Voici le récapitulatif de la commande: <br/><br/>
                                  Nom du client : $nom_client<br/>
                                  Adresse de livraison : $adresse<br/>
                                  Code Postal : $cp<br/>
                                  Ville : $ville<br/>
                                  Identifiant de la box : $type <br/>
                                  Description : $description <br/>
                                  Montant de la commande : $prix € 00<br/>";

                require 'vendor/autoload.php';

                $mail = new PHPMailer(true);

                $mail->IsSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'ns0.ovh.net';                          // Specify main and backup server
                $mail->Port = 587;                                    // Set the SMTP port
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'hello@chouania-mehdi.fr';          // SMTP username
                $mail->Password = 'Pl@yst@t10n1';                     // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'base64';

                $mail->From = 'hello@chouania-mehdi.fr';
                $mail->FromName = 'Mehdi CHOUANIA';
                $mail->AddAddress('chouania.mehdi@hotmail.fr');

                $mail->IsHTML(true);                             // Set email format to HTML

                $mail->Subject = "Nouvelle Commande - Made in World";
                $mail->Body = $body_html;

                if (!$mail->Send()) {
                    echo 'Le message n\'a pas pu être envoyé.';
                    echo 'Erreur de Mailer: ' . $mail->ErrorInfo;
                    exit;
                }

                // Redirection à la page d'accueil
                header("location: /?commandeeffectué");
            } else {

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

<div class="site-section"></div>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

            <div class="wrapper">
                <h2>Commande de votre box : <strong></strong></h2>
                <p>Veuillez remplir le formulaire ci-dessous pour initialiser votre commande.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($adresse_err)) ? 'has-error' : ''; ?>">
                        <label>Adresse de Livraison :</label>
                        <input type="text" name="adresse" class="form-control" value="<?php echo $adresse; ?>"
                               placeholder="Votre Adresse">
                        <span class="help-block"><?php echo $adresse_err; ?></span>
                    </div>

                    <div class="row">
                        <div class="col-xs-12col-sm-6 col-md-6">
                            <div class="form-group <?php echo (!empty($ville_err)) ? 'has-error' : ''; ?>">
                                <label>Ville de Livraison :</label>
                                <input type="text" name="ville" id="ville" class="form-control input-lg"
                                       placeholder="Ville" tabindex="1">
                                <span class="help-block"><?php echo $ville_err; ?></span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group <?php echo (!empty($type_err)) ? 'has-error' : ''; ?>">
                                <label>Code Postal :</label>
                                <input type="text" name="cp" id="cp" class="form-control input-lg"
                                       placeholder="Code Postal" tabindex="2">
                                <span class="help-block"><?php echo $type_err; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group <?php echo (!empty($type_err)) ? 'has-error' : ''; ?>">
                        <label>Format de boïte à commander :</label><br/>
                        <input type="radio" name="type_boite" value="57932"> Boîte <strong>Classique</strong> : 30 €<br>
                        <input type="radio" name="type_boite" value="1987"> Boîte <strong>Economique</strong> : 20 €<br>
                        <input type="radio" name="type_boite" value="984"> Boîte <strong> Sur Mesure</strong> : 40 €
                        <span class="help-block"><?php echo $type_err; ?></span>
                    </div>
                    <br/>

                    <div class="form-group">
                        <input type="submit" class="boutonprod3" value="Valider la commande">
                        <a class="boutonprod3" href="/">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    include("footer.php");
    ?>

<?php
include("header2.php");

use PHPMailer\PHPMailer\PHPMailer;

require_once "config.php";

// Execution du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupere l'email recherché
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    // Requete Select d'identification de compte via l'email
    $sql = "SELECT id, email FROM users WHERE email = :email";

    // Préparation de la requete SELECT
    $statement = $pdo->prepare($sql);

    // Liaison de la variable $name au parametre :name.
    $statement->bindValue(':email', $email);

    // Execution de la requete
    $statement->execute();

    // Fetch le resultat dans un tableau associatif
    $userInfo = $statement->fetch(PDO::FETCH_ASSOC);

    // Si la variable $userInfo est vide, l'email n'est pas présent en BDD.
    if (empty($userInfo)) {
        echo 'Cet email est inexistant.';
        exit;
    }

    // ID et Email de l'utilisateur.
    $userEmail = $userInfo['email'];
    $userId = $userInfo['id'];

    // Crée un token pour la requete d'oubli de mdp.
    $token = openssl_random_pseudo_bytes(16);
    $token = bin2hex($token);

    // Insert les informations de la requete
    // dans la table password_reset_request.

    $insertSql = "INSERT INTO password_reset_request
                (user_id, date_requested, token)
                VALUES
                (:user_id, :date_requested, :token)";

    // Préparation de la requete INSERT.
    $statement = $pdo->prepare($insertSql);

    // Execution de la requete et insert les données.
    $statement->execute(array(
        "user_id" => $userId,
        "date_requested" => date("Y-m-d H:i:s"),
        "token" => $token
    ));

    // Récupération de l'ID de la ligne insérée.
    $passwordRequestId = $pdo->lastInsertId();


    // Créer un lien URL vérifiant la requete d'oublie de mdp
    // permettant l'utlisateur de changer son mdp
    $verifyScript = 'http://localhost/made-in-world/oublimdp.php';

    // Lien de reset
    $linkToSend = $verifyScript . '?uid=' . $userId . '&id=' . $passwordRequestId . '&t=' . $token;

    $body_html = "Vous avez reçu un email de Made in World<br/><br/> 
                  Voici votre de reset de mot de passe : <br/><br/>
                  <a href='$linkToSend'>$linkToSend</a>";

    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);

    $mail->IsSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'ns0.ovh.net';                         // Specify main and backup server
    $mail->Port = 587;                                    // Set the SMTP port
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'hello@chouania-mehdi.fr';          // SMTP username
    $mail->Password = 'Pl@y$t@t10n1';                     // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    $mail->From = 'hello@chouania-mehdi.fr';
    $mail->FromName = 'Mehdi CHOUANIA';
    $mail->AddAddress($userEmail);                         // Name is optional

    $mail->IsHTML(true);                             // Set email format to HTML

    $mail->Subject = "Reset de mot de passe";
    $mail->Body = $body_html;

    if (!$mail->Send()) {
        echo 'Le message n\'a pas pu être envoyé.';
        echo 'Erreur de Mailer: ' . $mail->ErrorInfo;
        exit;
    }

    // Redirection vers la page de reset de mot de passe.
    header('Location: index.php?messageenvoye');
}
?>

<div class="site-section"></div>

<div class="site-section bg-light">
    <div class="row mb-5 justify-content-center">
        <div class="col-12 text-center">
            <h2 class="font-weight-light text-black display-4">Réinitialisation de mot de passe</h2>
        </div>

        <div class="col-md-7 text-center">
            <p>Veuillez entrer votre adresse mail pour recevoir un lien de réinitialisation de mot de passe.</p>


            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div>
                    <label>Votre adresse mail</label>
                    <input type="email" name="email">
                </div>
                <br/>
                <div>
                    <button type="submit" name="reset-password" class="boutonprod3">Envoyer</button>
                </div>
            </form>

        </div>
    </div>


</div>


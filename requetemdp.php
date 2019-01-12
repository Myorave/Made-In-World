<?php
require_once "config.php";

// Execution du formulaire
if($_SERVER["REQUEST_METHOD"] == "POST"){

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
  if(empty($userInfo)){
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

  // Test du lien de reset sur le site
  echo $linkToSend;
}
?>

<form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<h2 class="form-title">Réinitialisation de mot de passe</h2>
		<div class="form-group">
			<label>Votre adresse mail</label>
			<input type="email" name="email">
		</div>
		<div class="form-group">
			<button type="submit" name="reset-password" class="login-btn">Envoyer</button>
		</div>
</form>

<?php

require_once "config.php";

// l'ID de l'utilisateur, présent dans le GET via la variable "uid"
$userId = isset($_GET['uid']) ? trim($_GET['uid']) : '';
// Le token de la requete, présent dans le GET via la variable "t"
$token = isset($_GET['t']) ? trim($_GET['t']) : '';
// L'ID de la requete, présent dans le GET via la variable "id"
$passwordRequestId = isset($_GET['id']) ? trim($_GET['id']) : '';

$sql = "
      SELECT id, user_id, date_requested
      FROM password_reset_request
      WHERE
        user_id = :user_id AND
        token = :token AND
        id = :id
";

// Préparation de la requête
$statement = $pdo->prepare($sql);

// Execution de la requete en utilisant les paramètres recus
$statement->execute(array(
    "user_id" => $userId,
    "id" => $passwordRequestId,
    "token" => $token
));

// Fetch le resultat dans un tableau associatif
$requestInfo = $statement->fetch(PDO::FETCH_ASSOC);

// Si $requestInfo est vide,alors requete invalide.
if(empty($requestInfo)){
    echo 'Requete invalide!';
    exit;
}

// Requete valide, affectation en variable de session
// Permet d'acceder au formulaire de reset de mot de passe.
$_SESSION['reset_mdp'] = $userId;

// Redirection vers la page de reset de mot de passe.
header('Location: resetmdptoken.php');
exit;
?>

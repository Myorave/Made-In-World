<?php

require_once "config.php";

try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Mettre l'erreur PDO en exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $identifiant = $_POST['identifiant'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $id = $_POST['id'];

    $password = password_hash($password);

    $stmt = $pdo->prepare("UPDATE commentaire SET prenom = $prenom, nom = $nom, identifiant = $identifiant , email = $email, password = $password  WHERE id = $id");

    return $stmt->execute();

    // Fermeture de la requete
    unset($stmt);

} catch (PDOException $e) {
    die("ERREUR: Impossible de se connecter. " . $e->getMessage());
}
?>
<?php

function bdd_commentaire()
{ // Récupere tout les commentaires en BDD

    require_once "config.php";

    try {
        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        // Mettre l'erreur PDO en exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo->query('SELECT * FROM commentaire');
    } catch (PDOException $e) {
        die("ERREUR: Impossible de se connecter. " . $e->getMessage());
    }
}

function bdd_user()
{ // Récupère tous les clients en BDD

    require_once "config.php";

    try {
        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        // Mettre l'erreur PDO en exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo->query('SELECT * FROM users');
    } catch (PDOException $e) {
        die("ERREUR: Impossible de se connecter. " . $e->getMessage());
    }
}

function bdd_compte()
{ // Récupère les informations du client connecté

    require_once "config.php";

    try {
        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        // Mettre l'erreur PDO en exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo->query("SELECT * FROM users WHERE id ='{$_SESSION['id']}'");
    } catch (PDOException $e) {
        die("ERREUR: Impossible de se connecter. " . $e->getMessage());
    }
}

function bdd_commande()
{ // Récupère toutes les commandes en BDD

    require_once "config.php";

    try {
        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        // Mettre l'erreur PDO en exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo->query('SELECT * FROM commande');
    } catch (PDOException $e) {
        die("ERREUR: Impossible de se connecter. " . $e->getMessage());
    }
}

function insererCommentaire($a_titre, $a_contenu, $a_auteur, $a_note)
{

    require_once "config.php";

    try {
        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        // Mettre l'erreur PDO en exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO commentaire (titre, contenu, auteur, note) VALUES(:titre, :contenu, :auteur, :note)");

        $stmt->bindParam(':titre', $a_titre);
        $stmt->bindParam(':contenu', $a_contenu);
        $stmt->bindParam(':auteur', $a_auteur);
        $stmt->bindParam(':note', $a_note);
        $stmt->execute();

    } catch (PDOException $e) {
        die("ERREUR: Impossible de se connecter. " . $e->getMessage());
    }
}

function insererClient($prenom, $nom, $identifiant, $email, $password)
{

    require_once "config.php";
    try {
        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        // Mettre l'erreur PDO en exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($stmt = $pdo->prepare(
          "INSERT INTO users (prenom, nom, identifiant, email, password, created_at)
           VALUES(:prenom, :nom, :identifiant, :email, :password, NOW())"))
        {
          // Liaison des variables à la requete comme parametres
          $stmt->bindParam(':prenom', $prenom);
          $stmt->bindParam(':nom', $nom);
          $stmt->bindParam(':identifiant', $identifiant);
          $stmt->bindParam(':email', $email);
          $stmt->bindParam(':password', $password);
          $stmt->execute();
        }

        // Fermeture de la requete
        unset($stmt);

    } catch (PDOException $e) {
        die("ERREUR: Impossible de se connecter. " . $e->getMessage());
    }
}

function modifierClient($prenom, $nom, $identifiant, $email, $password, $id)
{

    require_once "config.php";

    $stmt = $pdo->prepare("UPDATE commentaire SET prenom = :prenom, nom = :nom, identifiant = :identifiant, email = :email, password = :password WHERE id = :id");

    $password = password_hash($password);

    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':id', $id);


    return $stmt->execute();

}

function modifierCommentaire($a_titre, $a_contenu, $id_commentaire)
{

    require_once "config.php";

    $stmt = $pdo->prepare("UPDATE commentaire SET titre = :titre, contenu = :contenu WHERE id = :id");

    $stmt->bindParam(':titre', $a_titre);
    $stmt->bindParam(':contenu', $a_contenu);
    $stmt->bindParam(':id', $id_commentaire);

    return $stmt->execute();

}

function deleteCommentaire($id_commentaire)
{

    require_once "config.php";

    $stmt = $pdo->prepare("DELETE FROM commentaire
    WHERE id = :id");

    $stmt->bindParam(':id', $id_commentaire);
    return $stmt->execute();

}

function deleteClient($id_client)
{

    require_once "config.php";

    $stmt = $pdo->prepare("DELETE FROM users
    WHERE id = :id");

    $stmt->bindParam(':id', $id_client);
    return $stmt->execute();

}

function deleteCommande($id_commande)
{

    require_once "config.php";

    $stmt = $pdo->prepare("DELETE FROM commande
    WHERE num_commande = :id");

    $stmt->bindParam(':id', $id_client);
    return $stmt->execute();

}

?>

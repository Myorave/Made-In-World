<?php

function bdd_commentaire()
{ // Récupere tout les commentaires en BDD

    require_once "config.php";

    return $pdo->query('SELECT * FROM commentaire');

}

function bdd_user()
{ // Récupère tous les clients en BDD

    require_once "config.php";

    return $pdo->query('SELECT * FROM users');

}

function bdd_compte()
{ // Récupère tous les clients en BDD

    require_once "config.php";

    return $pdo->query("SELECT * FROM users WHERE id ='{$_SESSION['id']}'");

}

function bdd_commande()
{ // Récupère toutes les commandes en BDD

    require_once "config.php";

    return $pdo->query('SELECT * FROM commande');

}

function insererCommentaire($a_titre, $a_contenu, $a_auteur, $a_note)
{

    require_once "config.php";

    $stmt = $pdo->prepare("INSERT INTO commentaire (titre, contenu, auteur, note) VALUES(:titre, :contenu, :auteur, :note)");

    $stmt->bindParam(':titre', $a_titre);
    $stmt->bindParam(':contenu', $a_contenu);
    $stmt->bindParam(':auteur', $a_auteur);
    $stmt->bindParam(':note', $a_note);
    $stmt->execute();

}

function insererClient($prenom, $nom, $identifiant, $email, $password)
{

    require_once "config.php";

    $stmt = $pdo->prepare("INSERT INTO users (prenom, nom, identifiant, email, password, created_at) VALUES(:prenom, :nom, :identifiant, :email, :password, NOW())");

    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

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

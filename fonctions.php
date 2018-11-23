<?php
include("init.php");

function bdd_commentaire(){ // fonction qui essaye de se connecter à la BDD
    try{
        $pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;

        $bdd=new PDO('mysql:host=localhost;dbname=projetphp','root','',$pdo_options);
        return $bdd->query('SELECT * FROM commentaire');
    }
    catch (Exception $e){
        die('Erreur : '.$e->getMessage());
    }
}

function insererCommentaire($a_titre,$a_contenu,$a_auteur){
     try{
        $pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;

        $bdd=new PDO('mysql:host=localhost;dbname=projetphp','root','',$pdo_options);
        $stmt = $bdd->prepare("INSERT INTO commentaire (titre, contenu, auteur) VALUES(:titre, :contenu, :auteur)");

        $stmt->bindParam(':titre', $a_titre);
        $stmt->bindParam(':contenu', $a_contenu);
        $stmt->bindParam(':auteur', $a_auteur);
        $stmt->execute();

        return true;
       }
       catch (Exception $e){
            die('Erreur : '.$e->getMessage());
       }
}

function deleteCommentaire($id_commentaire){
     try{
        $pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;

        $bdd=new PDO('mysql:host=localhost;dbname=projetphp','root','',$pdo_options);
        $stmt = $bdd->prepare("DELETE FROM commentaire
                                WHERE id = :id");

        $stmt->bindParam(':id', $id_commentaire);
        return $stmt->execute();

       }
       catch (Exception $e){
            die('Erreur : '.$e->getMessage());
       }
}

function modifierCommentaire($a_titre, $a_contenu, $id_commentaire){
     try{
        $pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;

        $bdd=new PDO('mysql:host=localhost;dbname=projetphp','root','',$pdo_options);
        $stmt = $bdd->prepare("UPDATE commentaire SET titre = :titre, contenu = :contenu WHERE id = :id");

        $stmt->bindParam(':titre', $a_titre);
        $stmt->bindParam(':contenu', $a_contenu);
        $stmt->bindParam(':id', $id_commentaire);

        return $stmt->execute();

       }
       catch (Exception $e){
            die('Erreur : '.$e->getMessage());
       }
}
?>

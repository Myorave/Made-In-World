<?php
include("config.php");
session_start();
?>
<html>
<head>
<title>Insertion d'une nouvelle signature</title>
</head>

<body>
<?php 

$auteur = $titre = $note = $contenu = "";
$auteur_err = $titre_err = $note_err = $contenu_err = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    // Validation du nom d'utilisateur
    if(empty(trim($_SESSION["identifiant"]))){
        $auteur_err = "Veuillez entrer votre identifiant.";
    } else{
        $auteur = trim($_SESSION["identifiant"]);
    }

    // Verification si le mdp est vide
    if(empty(trim($_POST["titre"]))){
        $titre_err = "Veuillez entrer votre mot de passe.";
    } else{
        $titre = trim($_POST["titre"]);
    }

    // Validation du nom d'utilisateur
    if(empty(trim($_POST["note"]))){
        $note_err = "Veuillez entrer votre identifiant.";
    } else{
        $note = trim($_POST["note"]);
    }

    // Verification si le mdp est vide
    if(empty(trim($_POST["contenu"]))){
        $contenu_err = "Veuillez entrer votre mot de passe.";
    } else{
        $contenu = trim($_POST["contenu"]);
    }

    // Validation des identifiants
    if(empty($titre_err) && empty($note_err) && empty($contenu_err) &&  empty($auteur_err)){

            // prepa requete
            $requete= "INSERT INTO commentaire (titre, auteur, contenu, note, date) VALUES ('$titre','$auteur', '$contenu','$note',  NOW())";    // fonction SQL qui me donne la date 
            
            //Exectution de la requete
                $resultat= $pdo -> query($requete);
            if (isset($resultat)) {
                header('Location: livre.php?messageenvoye');
            }
            else {
                echo 'Erreur à envoi';
            }
        }
    }
        //Requete pour afficher les commentaires
        $comments = "SELECT auteur, titre, contenu, note, date FROM commentaire ORDER BY date DESC";
        $tabcomments= $pdo -> query($comments);

        while ($donnees = $tabcomments->fetch()){

            echo '<div class="singlecomment"><h4>'.$donnees['auteur'].' à '.$donnees['date'].'</h4><p>'.$donnees['contenu'].'</p></div>';
            //Si l'utilisateur est connecté et que ses droits sont de 3, alors il peut supprimer un commentaire
        }
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <select id="titre" name="titre">
        <option value="">Choix de la box</option>
        <option value="Box Economique">Box Economique</option>
        <option value="Box Classique">Box Classique</option>
        <option value="Box Sur Mesure">Box Sur Mesure</option>
    </select>
    <span class="help-block"><?php echo $titre_err ?></span><br/>

    <select id="note" name="note">
        <option value="">Notez cette box</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
    </select>
    <span class="help-block"><?php echo $note_err ?></span><br/>

    <textarea name="contenu" cols="50" rows="10" placeholder="Votre message"></textarea>
    <span class="help-block"><?php echo $contenu_err ?></span><br/>

    <input type="submit" name="go" value="Signer"><br/>
</form>

</body>
</html>


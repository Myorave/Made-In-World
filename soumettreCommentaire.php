<?php
include("init.php");
include("fonctions.php");

$errors = array();


if (!isset($_POST['titre']) or empty($_POST['titre'])){
    $errors['titre'] = true;
}

if (!isset($_POST['auteur']) or empty($_POST['auteur'])){
  $errors['auteur'] = true;
}

if (!isset($_POST['contenu']) or empty($_POST['contenu'])){
    $errors['contenu'] = true;
}


if( count($errors) > 0 ) {
    foreach( $errors as $key =>$value) {
        echo "Veuillez entrer une valeur pour le champ ".$key."<br>";
    }
    exit;
}

$titre = $_POST['titre'];
$auteur = $_POST['auteur'];
$contenu = $_POST['contenu'];

insererCommentaire($titre,$auteur,$contenu);

echo "Votre commentaire a bien été ajouté, redirection vers la page d'administration dans 3 secondes";
echo '<meta http-equiv="refresh" content="3; URL=admin.php">';
?>

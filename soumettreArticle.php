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

insererArticle($titre,$auteur,$contenu);
?>

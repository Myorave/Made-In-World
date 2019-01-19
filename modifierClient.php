<?php

include("fonctions.php");

$result = array();
$result['status'] = false;

if (!isset($_POST['id']) or empty($_POST['id'])) {

    $result['error'] = "Id Obligatoire";
    echo json_encode($result);
    exit;

}

$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$identifiant = $_POST['identifiant'];
$email = $_POST['email'];
$password = $_POST['password'];
$id = $_POST['id'];

$result['status'] = modifierClient($prenom, $nom, $identifiant, $email, $password, $id);
echo json_encode($result);

?>

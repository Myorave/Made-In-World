<?php

include("fonctions.php");

$result = array();
$result['status'] = false;

if( !isset($_POST['id_commande']) or empty($_POST['id_commande'])){

    $result['error'] = "id_commande obligatoire";
    echo json_encode($result);
    exit;

}

$result['status'] = deleteCommande($_POST['id_commande']);
echo json_encode($result);

?>

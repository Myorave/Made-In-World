<?php

include("fonctions.php");

$result = array();
$result['status'] = false;

if (!isset($_POST['id_client']) or empty($_POST['id_client'])) {

    $result['error'] = "id_client obligatoire";
    echo json_encode($result);
    exit;

}

$result['status'] = deleteClient($_POST['id_client']);
echo json_encode($result);

?>

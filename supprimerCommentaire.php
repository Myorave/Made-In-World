<?php

include("fonctions.php");

$result = array();
$result['status'] = false;

if (!isset($_POST['id_commentaire']) or empty($_POST['id_commentaire'])) {

    $result['error'] = "id_commentaire obligatoire";
    echo json_encode($result);
    exit;

}

$result['status'] = deleteCommentaire($_POST['id_commentaire']);
echo json_encode($result);

?>

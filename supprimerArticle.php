<?php

include("init.php");
include("fonctions.php");

$result = array();
$result['status'] = false;

if( !isset($_POST['id_article']) or empty($_POST['id_article'])){
    
    $result['error'] = "id_article obligatoire";
    echo json_encode($result);
    exit;
    
}

$result['status'] = deleteArticle($_POST['id_article']);
echo json_encode($result);

?>
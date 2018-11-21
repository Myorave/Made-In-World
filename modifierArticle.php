<?php

include("init.php");
include("fonctions.php");

$result = array();
$result['status'] = false;

$result['status'] = modifierArticle($_POST['a_titre'],($_POST['a_contenu']));

$result['status'] = true;
echo json_encode($result);

?>
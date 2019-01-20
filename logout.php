<?php
// Initialisation de la session
session_start();

// Liberation de toutes les variables de session
$_SESSION = array();

// Destruction de la session.
session_destroy();

// Redirection vers la page de login
header("location: index.php");
exit;
?>

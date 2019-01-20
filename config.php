<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* Informations de la BDD. */
define('DB_SERVER', 'mysql-madeinworld-ducci2.alwaysdata.net');
define('DB_USERNAME', '175441_admin');
define('DB_PASSWORD', 'tropbien');

define('DB_NAME', 'madeinworld-ducci2_projetphp');

/* Tentative de connexion à la BDD MySQL */
try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Mettre l'erreur PDO en exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERREUR: Impossible de se connecter. " . $e->getMessage());
}
?>

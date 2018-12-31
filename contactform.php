<?php

if(isset($_POST['submit'])) {

  $nom = $_POST['fullname'];
  $sujet = "Contact - Made in World";
  $email = $_POST['email'];
  $message = $_POST['message'];

  $mailTo = "chouania.mehdi@hotmail.fr";
  $headers = "De: ".$email;
  $txt = "Vous avez reçu un email de ".$nom.". \n\n".$message;

  mail($mailTo, $sujet, $txt, $headers);
  header("Location: contact.php?mailsend");
}

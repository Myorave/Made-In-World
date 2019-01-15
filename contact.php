<?php
use PHPMailer\PHPMailer\PHPMailer;

include("header2.php");


if($_SERVER["REQUEST_METHOD"] === "POST"){

    $nom = $_POST['fullname'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);

    $mail->IsSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'ns0.ovh.net';                          // Specify main and backup server
    $mail->Port = 587;                                    // Set the SMTP port
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'hello@chouania-mehdi.fr';          // SMTP username
    $mail->Password = 'Pl@y$t@t10n1';                     // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    $mail->From = 'hello@chouania-mehdi.fr';
    $mail->FromName = $nom;
    $mail->AddAddress('chouania.mehdi@hotmail.fr');                         // Name is optional

    $mail->IsHTML(true);                             // Set email format to HTML

    $mail->Subject = "Contact - Made in World";
    $mail->Body = "Vous avez reçu un email de <strong>"
                . $nom ."</strong><br/>via l'adresse mail : <strong>". $email ."
                <br/></strong><br/>Message : ".$message;

    if (!$mail->Send()) {
    echo 'Le message n\'a pas pu être envoyé.';
    echo 'Erreur de Mailer: ' . $mail->ErrorInfo;
    exit;
    }

    echo 'Message bien envoyé';
    header("Location: contact.php?mailsend");
}

?>

<div class="site-section">

</div>    
<div class="site-section bg-light">
<div class=" container titre">
    <h3>Nous contacter</h3>
</div>

  <div class="container">
    <div class="row">

      <div class="col-md-7 col-lg-7 mb-4">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="p-5 bg-white3">

          <div class="row form-group">
            <div class="col-md-12 mb-3 mb-md-0">
              <label class="font" for="fullname">Nom & Prénom</label>
              <input type="text" id="fullname" name="fullname" class="form-control">
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-12">
              <label class="font" for="email">Email</label>
              <input type="email" id="email" name="email" class="form-control">
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-12">
              <label class="font" for="message">Message</label>
              <textarea name="message" id="message" cols="30" rows="5" class="form-control" ></textarea>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-12">
              <input type="submit" name="submit" value="Envoyer" class="btn btn-primary">
            </div>
          </div>

        </form>
      </div>

      <div class="col-lg-4">
        <div class="p-4 mb-3 bg-white3">
          <h3 class="h5 text-rose mb-3">Nos contacts</h3>
          <p class="mb-0 font">Adresse</p>
          <p class="mb-4">36 Avenue Général Eisenhower, Lyon 69005, FRANCE</p>

          <p class="mb-0 font">Téléphone</p>
          <p class="mb-4"><a href="#">01 23 45 67 89</a></p>

          <p class="mb-0 font">Adresse Mail</p>
          <p class="mb-0"><a href="#">email@domaine.com</a></p>

        </div>

      </div>
    </div>
  </div>
</div>

<?php
include("footer.php");
?>

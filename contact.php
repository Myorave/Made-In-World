<?php
include("header.php")
?>

<div class="site-blocks-cover inner-page overlay" style="background-image: url(images/hero_bg_2.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
  <div class="container">
    <div class="row align-items-center justify-content-center">
      <div class="col-md-7 text-center">
        <span class="sub-text">Besoin d'une information ?</span>
        <h1 class="mb-5">Nous <strong>Contacter</strong></h1>
      </div>
    </div>
  </div>
</div>

<div class="site-section bg-light">
  <div class="container">
    <div class="row">

      <div class="col-md-12 col-lg-8 mb-5">

        <form action="contactform.php" class="p-5 bg-white">

          <div class="row form-group">
            <div class="col-md-12 mb-3 mb-md-0">
              <label class="font-weight-bold" for="fullname">Nom & Prénom</label>
              <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Votre nom et prénom">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-12">
              <label class="font-weight-bold" for="email">Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Votre email">
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-12">
              <label class="font-weight-bold" for="message">Message</label>
              <textarea name="message" id="message" cols="30" rows="5" class="form-control" placeholder="Votre message"></textarea>
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
        <div class="p-4 mb-3 bg-white">
          <h3 class="h5 text-black mb-3">Nos contacts</h3>
          <p class="mb-0 font-weight-bold">Adresse</p>
          <p class="mb-4">36 Avenue Général Eisenhower, Lyon 69005, FRANCE</p>

          <p class="mb-0 font-weight-bold">Téléphone</p>
          <p class="mb-4"><a href="#">01 23 45 67 89</a></p>

          <p class="mb-0 font-weight-bold">Adresse Mail</p>
          <p class="mb-0"><a href="#">email@domaine.com</a></p>

        </div>

        <div class="p-4 mb-3 bg-white">
          <h3 class="h5 text-black mb-3">Plus d'informations</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa ad iure porro mollitia architecto hic consequuntur. Distinctio nisi perferendis dolore, ipsa consectetur?</p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include("footer.php");
?>

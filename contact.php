<?php
include("header2.php")
?>



<div class="site-section bg-light">
<div class=" container titre">
<h3> Nous contacter </h3>
</div>

  <div class="container">
    <div class="row">

      <div class="col-md-7 col-lg-7 mb-4">

        <form action="#" class="p-5 bg-white3">

          <div class="row form-group">
            <div class="col-md-12 mb-3 mb-md-0">
              <label class="font" for="fullname">Nom & Prénom</label>
              <input type="text" id="fullname" class="form-control" placeholder="">


            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-12">
              <label class="font" for="email">Email</label>
              <input type="email" id="email" class="form-control"  placeholder="">
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-12">
              <label class="font" for="message">Message</label>
              <textarea name="message" id="message" cols="30" rows="5" class="form-control" placeholder=""></textarea>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-12">
              <input type="submit" value="Envoyer" class="btn btn-primary">
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

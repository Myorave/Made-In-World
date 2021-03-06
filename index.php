<?php
include("header2.php");
include("config.php");
?>

<div class="site-section" style="min-height: 100vh; background-repeat:no-repeat; background-image: url('images/fond3.jpg');">
  <div class="container ">
    <div class="row">
      <div class="col-md-5 pr-md-5 order-md-1">
        <div class="display-3" style="color:white; font-weight:500"> </br> <strong>MADE IN WORLD</strong> </div>
        <h4 style="color:white">
          Le monde à porter d'une box
        </h4>
        </br>
        </br>
        <h6 style="color:white;line-height:1.5">
          Retrouvez chaque mois un nouveau pays
          et des recettes à partager entre amis.
          C’est à vous de vous lancer dans notre
          voyage aux saveurs !
        </h6>
        </br>
        </br>
        <p><a href="produits.php" class="boutonprod4">Voir la box du mois</a></p>
      </div>
      <div class="col-md-6 bg-image bg-sm-height mb-5 mb-md-0 order-md-2 fondjaune" style="background-image: url('images/box_3_produits_home.png');"
        data-aos="fade-up" data-aos-delay="300">
      </div>
    </div>
  </div>
</div>

<div class="site-section border-bottom bg-light py-5">
  <div class="container">
    <div class="row liste">

      <div class="col-12 text-center mb-4">
        <h1 class="text-black1 h2 text-uppercase" data-aos="fade">Ce que nous proposons toute l'année</h1>
      </div>

      <div class="col-md-6 col-lg-4 mb-0 zone" data-aos="fade" data-aos-delay="0">
        <img src="images/monde.svg" alt="Image" class="toque1">
        <div class="">
          <div class="">
            <h2 class="text-black">Voyage culinaire</h2> Au quatre coins du <strong class="text-black">monde</strong>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-4  zone" data-aos="fade" data-aos-delay="300">
        <img src="images/tray.svg" alt="Image" class="toque1">
        <div class="">
          <div class="mr-3"></div>
          <div class="">
            <h2 class="text-black">Des produits </h2> <strong class="text-black"> 100%</strong> Made in world
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-4 zone" data-aos="fade" data-aos-delay="700">
        <img src="images/chef.svg" alt="Image" class=toque2>
        <div class="">
          <div class="mr-3"></div>
          <div class="">
            <h2 class="text-black">Un livre de recette </h2> <strong class="text-black"> Voyager </strong> et retrouver
            les coutumes pays
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="site-section1">
  <div class="container">
    <div class="row">
      <div class="col-md-6 bg-image bg-sm-height mb-5 mb-md-0 order-md-2" style="background-image: url('images/fondv.png');"
        data-aos="fade-up"></div>
      <div class="col-md-6 pr-md-5 order-md-1">
        <h2 class="display-4 text-white "><strong>LA BOX</strong> </br> Made in World</h2>
        <p class=" commentaire" style="color:white">Made in World vous propose un voyage culinaire exceptionnel pour
          savourer des plats
          typiques, cuisiner des recettes originales et découvrir avec curiosité et étonnement la cuisine du monde.</p>
        <div class="site-block-check">
          <li> <strong>1- </strong> Je choisis la box qui me convient</li>
          <li> <strong>2- </strong> Je reçois la box dans ma boite aux lettres</li>
          <li> <strong>3- </strong> C'est à vous de cuisiner !</li>
        </div>
        </br>
        <p><a href="produits.php" class="boutonprod4">En savoir plus</a></p>
        </br>
      </div>
    </div>
  </div>
</div>

<div class="site-section section-about">
  <div class="container">
    <div class="row mb-5 justify-content-center">
      <div class="col-md-6 text-center">
        <h1 class="display-4 text-black1 mb-5">NOS PRODUITS</h1>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="CarteP">
          <img src="images/La_Classique.png" alt="Image" class="w-50 mb-4 rounded" data-aos="fade" data-aos-delay="0">
          <h4>La classique</h4>
          <div class="prix">30€</div>
          <a href="produit1.php" class="boutonprod">Acheter</a>
        </div>
      </div>

      <div class="col-md-4 ">
        <div class="CarteP">
          <img src="images/Sur_mesure.png" alt="Image" class="w-50 mb-4 rounded" data-aos="fade" data-aos-delay="300">
          <h4>La sur mesure</h4>
          <div class="prix">40€</div>
          <a href="produit2.php" class="boutonprod">Acheter</a>
        </div>
      </div>

      <div class="col-md-4">
        <div class="CarteP">
          <img src="images/economique.png" alt="Image" class="w-50 mb-4 rounded" data-aos="fade" data-aos-delay="700">
          <h4>L'économique </h4>
          <div class="prix">20€</div>
          <a href="produit3.php" class="boutonprod">Acheter</a>
        </div>
      </div>

    </div>
  </div>
</div>

<link rel="stylesheet" href="css/owl.carousel.min.css">

<div class="site-section bg-light">
  <div class="row mb-5 justify-content-center">
    <div class="col-12 text-center">
      <h2 class="font-weight-light text-black display-4">Derniers témoignages</h2>
    </div>
  </div>

  <div class="container">
    <div class="block-13 nonloop-block-13 owl-carousel" data-aos="fade">
      <?php

      //Requete pour afficher les 4 derniers commentaires
      $comments = "SELECT * FROM commentaire ORDER BY date DESC LIMIT 4";
      $tabcomments = $pdo->query($comments);

      while ($donnees = $tabcomments->fetch()) {
          echo '
          <div class="p-4">
            <div class="block-47 d-flex">
              <blockquote class="block-47-quote">
                <h3> ' . $donnees['titre'] . '</h3>
                <h5> Avis : ' . $donnees['note'] . ' / 5</h5>
                <p>&ldquo;' . $donnees['contenu'] . '&rdquo;</p>
                <cite class="block-47-quote-author">&mdash; ' . $donnees['auteur'] . '</cite>
              </blockquote>
            </div>
          </div>
          ';
      }
      ?>

    </div>
  </div>
</div>

<?php
include("footer.php");
?>
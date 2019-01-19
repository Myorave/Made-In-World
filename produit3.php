<?php
include("header2.php")
?>
<div class="ligne"></div>
<div class="site-section"></div>
<div class="site-section3">
    <div class="container">
        <div class="row">
            <div class="col-md-4 pr-md-5 order-md-1">
                <h2 class="display-4">LA BOX économique </h2>
                <p>On vous propose dans cette box de vous immerger dans les traditions culinaires de l'Italie. La box
                    économique est parfaite pour des repas à deux. Cette box à petit prix est un bon compromis pour
                    découvrir un pays chaque mois. </p>
            </div>

            <div class="col-md-4 order-md-1">
                <img class="imgboite" src="images/box-forfait.png" alt="boite economique">
            </div>

            <div class="col-md-4  order-md-1 prixdesc">
                <h2 class="display-3 mb-5 prixs"><strong>20 €</br></strong></h2>
                <?php if (isset($_SESSION['loggedin'])) { // Si l'utilisateur s'est connecté, afficher le bouton de deconnexion
                    ?>
                <p><a href="produitachat.php" class="boutonprod1">Acheter la box</a></p>
                <?php
                } else { // Sinon, afficher le bouton d'inscription / connexion
                    ?><p><a href="connexion.php?achat=true" class="boutonprod1">Acheter la box</a></p><?php
                } ?>
            </div>
        </div>
    </div>
</div>

<div class="site-section site-block-3 bg-light">
    <div class="container">
        <div class="gallery">
            <div class="gallery-item"><img src="images/sauce_tomates.png" alt="Sauce tomate"><span class="text-wrapper"><span
                        class="name">La sauce tomate</span><span class="title">Véritable base pour les pâtes et pizza</span></span>
            </div>

            <div class="gallery-item"><img src="images/pates.png" alt="Boite de pâtes"><span class="text-wrapper"><span
                        class="name">La boite de pâtes</span><span class="title">L'incontournable ingrédients de
                        l'Italie</span></span></div>

            <div class="gallery-item"><img src="images/vinr.png" alt="Une bouteille de vin"><span class="text-wrapper"><span
                        class="name">Le vin rouge</span><span class="title"> Un vin en bouche, chaud et velouté
                        selectioné par notre chef</span></span></div>

            <div class="gallery-item"><img src="images/livreb.png" alt="Livre de recette "><span class="text-wrapper"><span
                        class="name">Le livre de recette</span><span class="title">Les recettes classiques italiens
                        d'une simplicité absolue</span></span></div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>
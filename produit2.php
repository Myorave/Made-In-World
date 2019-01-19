<?php
include("header2.php")
?>
<div class="ligne"></div>
<div class="site-section"></div>
<div class="site-section3">
    <div class="container">
        <div class="row">
            <div class="col-md-4 pr-md-5 order-md-1">
                <h2 class="display-4">LA BOX <br>sur mesure </h2>
                <p> Le plus de cette box est de pouvoir recevoir les 2 derniers produits du mois précédents. Les produits sélectionné du mois précédents sont les bananes séchées et le thé d'ici et d'ailleurs.</p>
            </div>

            <div class="col-md-4 order-md-1">
                <img class="imgboite" src="images/box-forfait.png" alt="boite sur mesure">
            </div>

            <div class="col-md-4  order-md-1 prixdesc">
                <h2 class="display-3 mb-5 prixs"><strong>40 €</br></strong></h2>
                <?php if (isset($_SESSION['loggedin'])) { // Si l'utilisateur s'est connecté, afficher le bouton de deconnexion
                    ?><p><a href="produitachat.php" class="boutonprod1">Acheter la box</a></p><?php
                } else { // Sinon, afficher le bouton d'inscription / connexion
                    ?><p><a href="connexion.php?achat=1" class="boutonprod1">Acheter la box</a></p><?php
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

            <div class="gallery-item"><img src="images/oliveb.png" alt="Olive verte"><span class="text-wrapper"><span
                            class="name">Les olives vertes</span><span class="title">Olives typiques, les plus grosses du
                        monde</span></span></div>

            <div class="gallery-item"><img src="images/grainesj.png" alt="Sachet de graine"><span
                        class="text-wrapper"><span
                            class="name">Les graines</span><span class="title">Cultiver d'authentiques variétés potagères
                        anciennes italiennes</span></span></div>

            <div class="gallery-item"><img src="images/livrer.png" alt="Livre de recette "><span
                        class="text-wrapper"><span
                            class="name">Le livre de recette</span><span class="title">Les recettes classiques italiens
                        d'une simplicité absolue</span></span></div>

            <div class="gallery-item"><img src="images/vinb.png" alt="Une bouteille de vin"><span
                        class="text-wrapper"><span
                            class="name">Le vin rouge</span><span class="title"> Un vin en bouche, chaud et velouté
                        selectioné par notre chef</span></span></div>

            <div class="gallery-item"><img src="images/bananej.png" alt="Le sachet de banane "><span
                        class="text-wrapper"><span
                            class="name">Le sachet de banane </span><span class="title">Aliment aux grandes qualités nutritives, pour les recettes sucré et salé</span></span>
            </div>

            <div class="gallery-item"><img src="images/the.png" alt="La boite de thé"><span class="text-wrapper"><span
                            class="name">La boite de Thé </span><span class="title"> Un Thés d’excellence et de douceurs pour voyager à travers les saveurs</span></span>
            </div>

        </div>

    </div>
</div>

<?php
include("footer.php");
?>
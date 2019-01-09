<?php
include("header2.php");
?>

<script src="js/connexion.js"></script>

<div class="site-section bg-light">
    <div class=" container titre">
        <h3> Faire partie de l'ecpérience Made In World</h3>
    </div>
    <!-- formulaire 1 nouveau participant-->
    <div class="container">
        <div class="row">

            <div class="col-md-7 col-lg-7 mb-4">

                <form action="#" class="p-5 bg-white3">

                    <div class="row form-group">
                        <div class="col-md-12 mb-3 mb-md-0">
                            <label class="font" for="first_name">Prénom</label>
                            <input type="text" name="first_name" id="first_name" class="form-control input-lg"
                                placeholder="Prénom" tabindex="1">


                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="font" for="last_name">Nom</label>
                            <input type="text" name="last_name" id="last_name" class="form-control input-lg"
                                placeholder="Nom" tabindex="2">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="font" for="identifiant">Identifiant</label>
                            <input type="text" name="identifiant" id="identifiant" class="form-control input-lg"
                                placeholder="Identifiant" tabindex="3">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="font" for="password">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control input-lg"
                                placeholder="Mot de passe" tabindex="4">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="font" for="password">Confirmer Mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-lg"
                                placeholder="Confirmez le Mot de Passe" tabindex="5">
                        </div>
                    </div>


                    <div class="col-xs-5 col-sm-3 col-md-3">
                        <span class="button-checkbox">
                            <button type="button" class="btn" data-color="info" tabindex="7">J'accepte</button>
                            <input type="checkbox" name="t_and_c" id="t_and_c" class="hidden" value="1">
                        </span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        En cliquant sur <strong class="label label-primary">S'inscrire</strong>, vous acceptez les <a
                            href="#" data-toggle="modal" data-target="#t_and_c_m">Termes & Conditions</a> établies par
                        ce site.
                    </div>

                    <div class="row form-group">
                        <div class="col-xs-12 col-md-6"><input type="submit" value="S'inscrire" class="btn btn-primary"
                                tabindex="7"></div>

                    </div>

                </form>

            </div>
            <!-- formulaire dejà membre-->



            <div class="col-lg-4">
                <div class="p-4 mb-3 bg-white3">

                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="font" for="password">Identifiant</label>
                            <input type="text" name="identifiant" id="identifiant" class="form-control input-lg"
                                placeholder="Identifiant" tabindex="3">

                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="font" for="password">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control input-lg"
                                placeholder="Mot de passe" tabindex="2">

                        </div>


                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-6"><input type="submit" value="Connexion" class="btn btn-primary"
                                tabindex="3"></div>

                    </div>


                    </form>
                </div>


            </div>

        </div>
    </div>
</div>

<?php
include("footer.php");
?>
<?php
include("header.php");
?>

<div class="container">
  <div class="row">
      <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
  		<form role="form">
  			<h2>Se connecter <small>sur Made in World</small></h2>


        <div class="form-group">
          <input type="text" name="identifiant" id="identifiant" class="form-control input-lg" placeholder="Identifiant" tabindex="1">
        </div>
  			<div class="form-group">
  				<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Mot de passe" tabindex="2">
  			</div>


  			<div class="row">
  				<div class="col-xs-12 col-md-6"><input type="submit" value="Connexion" class="btn btn-primary btn-block btn-lg" tabindex="3"></div>
  				<div class="col-xs-12 col-md-6"><a href="inscription.php" class="btn btn-success btn-block btn-lg">S'inscrire</a></div>
  			</div>
  		</form>
  	</div>
  </div>
</div>

<?php
include("footer.php");
?>

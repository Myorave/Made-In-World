<?php
include("header.php");
?>

<script src="js/connexion.js"></script>

<div class="container">
  <div class="row">
      
  		<form class="form" role="form">
  			<h2>Inscription<small> : Made in World</small></h2>
  			
  			<div class="row">
  				<div class="col-xs-12col-sm-6 col-md-6">
  					<div class="form-group">
              <input type="text" name="first_name" id="first_name" class="form-control input-lg" placeholder="Prénom" tabindex="1">
  					</div>
  				</div>
  				<div class="col-xs-12 col-sm-6 col-md-6">
  					<div class="form-group">
  						<input type="text" name="last_name" id="last_name" class="form-control input-lg" placeholder="Nom" tabindex="2">
  					</div>
  				</div>
  			</div>
        <div class="form-group">
          <input type="text" name="identifiant" id="identifiant" class="form-control input-lg" placeholder="Identifiant" tabindex="3">
        </div>
  			<div class="form-group">
  				<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Adresse Email" tabindex="3">
  			</div>
  			<div class="row">
  				<div class="col-xs-12 col-sm-6 col-md-6">
  					<div class="form-group">
  						<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Mot de passe" tabindex="4">
  					</div>
  				</div>
  				<div class="col-xs-12 col-sm-6 col-md-6">
  					<div class="form-group">
  						<input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-lg" placeholder="Confirmez le Mot de Passe" tabindex="5">
  					</div>
  				</div>
  			</div>
  			<div class="row">
  				<div class="col-xs-4 col-sm-3 col-md-3">
  					<span class="button-checkbox">
  						<button type="button" class="btn" data-color="info" tabindex="7">J'accepte</button>
                <input type="checkbox" name="t_and_c" id="t_and_c" class="hidden" value="1">
  					</span>
  				</div>
  				<div class="col-xs-8 col-sm-9 col-md-9">
  					 En cliquant sur <strong class="label label-primary">S'inscrire</strong>, vous acceptez les <a href="#" data-toggle="modal" data-target="#t_and_c_m">Termes & Conditions</a> établies par ce site.
  				</div>
  			</div>

  			
  			<div class="row">
  				<div class="col-xs-12 col-md-6"><input type="submit" value="S'inscrire" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
  				<div class="col-xs-12 col-md-6"><a href="connexion.php" class="btn btn-success btn-block btn-lg">Connexion</a></div>
  			</div>
  		</form>
  	
  </div>
  
  <!-- Modal -->
  <div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-lg">
  		<div class="modal-content">
  			<div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Termes & Conditions</h4>
  				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  			</div>
  			<div class="modal-body">
  				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
  				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
  				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
  				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
  				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
  				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
  				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
  			</div>
  			<div class="modal-footer">
  				<button type="button" class="btn btn-primary" data-dismiss="modal">J'accepte</button>
  			</div>
  		</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</div>

<?php
include("footer.php");
?>

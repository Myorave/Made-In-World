<?php
  include("header-admin.php");
  include("fonctions.php");
?>

<div class="ligne"></div>
<div class="site-section"></div>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <h1 class="page-header">Administration du site <a href= "" class="btn btn-success event-ajout">Ajouter un client</a></h1>
      <h2 class="sub-header">Liste des utilisateurs</h2>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Prénom</th>
              <th>Nom</th>
              <th>Pseudo</th>
              <th>Email</th>
              <th>Date de Création</th>
            </tr>
          </thead>

          <tbody>
            <?php
                $users = bdd_user();
                while($user = $users->fetch()){
            ?>

            <tr data-id="<?php echo $user['id']; ?>">
              <td><?php echo $user['id']; ?></td>
              <td><?php echo $user['prenom']; ?></td>
              <td><?php echo $user['nom']; ?></td>
              <td><?php echo $user['identifiant']; ?></td>
              <td><?php echo $user['email']; ?></td>
              <td><?php echo $user['created_at']; ?></td>

              <td>
                <a href="" class="btn btn-warning event-edit">Edition</a><br><br>
                <a href="" class="btn btn-danger event-delete">Supprimer</a>
              </td>
            </tr>

            <?php }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div id="modal-edition" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" >Edition de Commentaire</h4>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-primary">Modifier</button>
      </div>
    </div>
  </div>
</div>

<div id="modal-ajout" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <?php
                // Inclusion du fichier config
                require_once "config.php";

                // Je définis les variables et les initialisent avec des valeurs vides
                $identifiant = $mdp = $email = $mdp2 = "";
                $identifiant_err = $mdp_err = $email_err = $mdp2_err = "";

                // Execution du formulaire
                if($_SERVER["REQUEST_METHOD"] == "POST"){

                // Validation du nom d'utilisateur
                if(empty(trim($_POST["identifiant"]))){
                $identifiant_err = "Veuillez entrer un mot de passe d'utilisateur.";
                } else {
                // Préparation de la requete SELECT
                $sql = "SELECT id FROM users WHERE identifiant = :identifiant";

                if($stmt = $pdo->prepare($sql)){
                // Liaison des variables à la requete comme parametres
                $stmt->bindParam(":identifiant", $param_identifiant, PDO::PARAM_STR);

                // Set des parametres
                $param_identifiant = trim($_POST["identifiant"]);

                // Tentative d'execution de la requete
                if($stmt->execute()){
                if($stmt->rowCount() == 1){
                $identifiant_err = "This identifiant is already taken.";
                } else{
                $identifiant = trim($_POST["identifiant"]);
                }
                } else{
                echo "Oops! Une erreur est survenue. Reessayez plus tard.";
                }
                }

                // Fermeture de la requete
                unset($stmt);
                }

                // Validation de l'email
                if(empty(trim($_POST["email"]))){
                $email_err = "Veuillez entrer un email.";
                } else {
                // Préparation de la requete SELECT
                $sql = "SELECT email FROM users WHERE email = :email";

                if($stmt = $pdo->prepare($sql)){
                // Liaison des variables à la requete comme parametres
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

                // Set des parametres
                $param_email = trim($_POST["email"]);

                // Tentative d'execution de la requete
                if($stmt->execute()){
                if($stmt->rowCount() == 1){
                $email_err = "Cet email est déjà pris.";
                } else{
                $email = trim($_POST["email"]);
                }
                } else{
                echo "Oops! Une erreur est survenue. Reessayez plus tard.";
                }
                }

                // Fermeture de la requete
                unset($stmt);
                }

                // Validation du mot de passe
                if(empty(trim($_POST["mdp"]))){
                $mdp_err = "Entrez un mot de passe.";
                } elseif(strlen(trim($_POST["mdp"])) < 6){
                $mdp_err = "Votre mot de passe doit contenir au moins 6 caractères.";
                } else{
                $mdp = trim($_POST["mdp"]);
                }

                // Validation du mot de passe de confirmation
                if(empty(trim($_POST["mdp2"]))){
                $mdp2_err = "Confirmez votre mot de passe.";
                } else{
                $mdp2 = trim($_POST["mdp2"]);
                if(empty($mdp_err) && ($mdp != $mdp2)){
                $mdp2_err = "Le mot de passe de confirmation est différent.";
                }
                }

                // Vérification des erreurs d'input avant insertion dans la BDD
                if(empty($identifiant_err) && empty($mdp_err) && empty($mdp2_err)){

                // Préparation d'une requete INSERT
                $sql = "INSERT INTO users (identifiant, password, prenom, nom, email) VALUES (:identifiant, :password, :prenom, :nom, :email)";

                if($stmt = $pdo->prepare($sql)){
                // Liaison des variables à la requete comme parametres
                $stmt->bindParam(":identifiant", $param_identifiant, PDO::PARAM_STR);
                $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
                $stmt->bindParam(":prenom", $param_prenom, PDO::PARAM_STR);
                $stmt->bindParam(":nom", $param_nom, PDO::PARAM_STR);
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

                // Set des parametres
                $param_identifiant = $identifiant;
                $param_password = password_hash($mdp, PASSWORD_DEFAULT); // Creates a password hash
                $param_prenom = trim($_POST["prenom"]);
                $param_nom = trim($_POST["nom"]);
                $param_email = trim($_POST["email"]);

                // Tentative d'execution de la requete
                if($stmt->execute()){
                // Redirection à la page de connexion
                header("location: connexion.php");
                } else{
                echo "Une erreur est survenue. Veuillez recommencer.";
                }
                }

                // Fermeture de la requete
                unset($stmt);
                }

                // Fermeture de la connexion
                unset($pdo);
                }
                ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <h2>Inscription<small> : Made in World</small></h2>

                    <div class="row">
                        <div class="col-xs-12col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="prenom" id="prenom" class="form-control input-lg" placeholder="Prénom" tabindex="1">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="nom" id="nom" class="form-control input-lg" placeholder="Nom" tabindex="2">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="text" name="identifiant" id="identifiant" class="form-control input-lg" placeholder="Identifiant" tabindex="3" value="<?php echo $identifiant; ?>">
                        <span class="help-block"><?php echo $identifiant_err; ?></span>
                    </div>

                    <div class="form-group          ">
                        <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Adresse Email" tabindex="4" value="<?php echo $identifiant; ?>">
                        <span class="help-block"><?php echo $email_err; ?></span>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="password" name="mdp" id="mdp" class="form-control input-lg" placeholder="Mot de passe" tabindex="5" value="<?php echo $mdp; ?>">
                                <span class="help-block"><?php echo $mdp_err; ?></span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="password" name="mdp2" id="mdp2" class="form-control input-lg" placeholder="Confirmez le Mot de Passe" tabindex="6" value="<?php echo $mdp2; ?>">
                                <span class="help-block"><?php echo $mdp2_err; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-6"><input type="submit" value="S'inscrire" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-3.3.1.min.js"><\/script>')</script>
<script src="js/alertify.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){

      $('.event-delete').on('click',function(e){
          e.preventDefault();

          var id = $(this).parents('tr').data('id');
          var tr = $(this).parents('tr');

          alertify.confirm('Confirmez-vous la suppression ?', 'Êtes-vous sûr de vouloir supprimer ce commentaire ?', function(){
             $.ajax({
              method: "POST",
              url: "supprimerClient.php",
              data: { id_client: id },
              dataType: 'json'
            })
              .done(function(result) {
                console.log(result);
                 if(result.status){
                     tr.remove();
                 }
                 else{
                     alert("Une erreur est survenue lors de la suppression");
                 }
            });
          }
          ,function(){});
      });

      $('.event-edit').on('click',function(e){
        e.preventDefault();
          $('#modal-edit').modal('show');
        });

      $('.event-ajout').on('click',function(e){
          e.preventDefault();
          $('#modal-ajout').modal('show');
      });

    });
</script>

<?php
  include("footer.php");
?>

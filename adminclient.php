<?php
  include("header-admin.php");
  include("fonctions.php");
?>
<div class="site-section"></div>

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar"></div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <h1 class="page-header">Administration du site
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

<div id="modal-edit" class="modal fade" tabindex="-1" role="dialog">
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
    });
</script>

<?php
  include("footer.php");
?>

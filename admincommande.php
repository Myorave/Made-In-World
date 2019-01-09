<?php
  include("header-admin.php");
  include("fonctions.php");
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <h1 class="page-header">Administration du site
      <h2 class="sub-header">Liste des commandes</h2>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Adresse de Livraison</th>
              <th>Code Postal</th>
              <th>Ville</th>
              <th>Pays</th>
              <th>Numéro Box</th>
              <th>Date de commande</th>
            </tr>
          </thead>

          <tbody>
            <?php
                $commandes = bdd_commande();
                while($commande = $commandes->fetch()){
            ?>

            <tr data-id="<?php echo $commande['num_commande']; ?>">
              <td><?php echo $commande['num_commande']; ?></td>
              <td><?php echo $commande['addr_livraison']; ?></td>
              <td><?php echo $commande['cp_livraison']; ?></td>
              <td><?php echo $commande['ville_livraison']; ?></td>
              <td><?php echo $commande['pays_livraison']; ?></td>
              <td><?php echo $commande['num_box']; ?></td>
              <td><?php echo $commande['date_commande']; ?></td>

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
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script>window.jQuery || document.write('<script src="js/jquery-3.3.1.min.js"><\/script>')</script>

<!-- include the script -->
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
              url: "supprimerCommentaire.php",
              data: { id_commentaire: id },
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
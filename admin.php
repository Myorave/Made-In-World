<?php
include("init.php");
include("fonctions.php");
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- include the style -->
    <link rel="stylesheet" href="css/alertify.min.css" />
    <link rel="stylesheet" href="css/themes/bootstrap.min.css" />

    <title>Administration</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css/admin.css" rel="stylesheet">

  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">

          <a class="navbar-brand" href="#">Projet PHP</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Profil</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Commentaires <span class="sr-only">(current)</span></a></li><br>
            <li class="active"><a href="#/clients">Clients <span class="sr-only"></span></a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard
            <a href="ajout-article.php" class="btn btn-success pull-right">Ajouter un commentaire</a></h1>
          <h2 class="sub-header">Liste des commentaires</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Titre</th>
                  <th>Contenu</th>
                  <th>Auteur</th>
                </tr>
              </thead>

              <tbody>

                <?php
                    $articles = bdd_article();
                    while($article = $articles->fetch()){
                ?>

                <tr data-id="<?php echo $article['id']; ?>">
                  <td><?php echo $article['id']; ?></td>
                  <td><?php echo $article['titre']; ?></td>
                  <td><?php echo $article['contenu']; ?></td>
                  <td><?php echo $article['auteur']; ?></td>
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
            <h4 class="modal-title" >test
            </h4>
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

    <script>window.jQuery || document.write('<script src="js/jquery.js"><\/script>')</script>

    <!-- include the script -->
    <script src="js/alertify.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function(){

          $('.event-delete').on('click',function(e){
              e.preventDefault();

              var id = $(this).parents('tr').data('id');
              var tr = $(this).parents('tr');

              alertify.confirm('Confirmez-vous la suppression ?', 'Êtes-vous sûr de vouloir supprimer ce commentaire ?', function(){
                 $.ajax({
                  method: "POST",
                  url: "supprimerArticle.php",
                  data: { id_article: id },
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

//                  $.ajax({
//                  method: "POST",
//                  url: "form-modifierArticle.php",
//                  data: { id_article: id },
//                  dataType: 'json'
//                })
            });
        });
    </script>
  </body>
</html>

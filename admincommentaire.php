<?php
include("header-admin.php");
include("fonctions.php");
?>
<div class="ligne"></div>
<div class="site-section4">
    <div class="row">
        <div class="container">
            <h2 class="page-header">Administration du site</h2>
                <h3 class="sub-header">Liste des commentaires</h3><br>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Titre</th>
                            <th>Contenu</th>
                            <th>Auteur</th>
                            <th>Notation</th>
                            <th>Date de publication</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $commentaires = bdd_commentaire();
                        while ($commentaire = $commentaires->fetch()) {
                            ?>

                            <tr data-id="<?php echo $commentaire['id']; ?>">
                                <td><?php echo $commentaire['id']; ?></td>
                                <td><?php echo $commentaire['titre']; ?></td>
                                <td><?php echo $commentaire['contenu']; ?></td>
                                <td><?php echo $commentaire['auteur']; ?></td>
                                <td><?php echo $commentaire['note']; ?></td>
                                <td><?php echo $commentaire['date']; ?></td>

                                <td>
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

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script>window.jQuery || document.write('<script src="js/jquery-3.3.1.min.js"><\/script>')</script>

<!-- include the script -->
<script src="js/alertify.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {

        $('.event-delete').on('click', function (e) {
            e.preventDefault();

            var id = $(this).parents('tr').data('id');
            var tr = $(this).parents('tr');

            alertify.confirm('Confirmez-vous la suppression ?', 'Êtes-vous sûr de vouloir supprimer ce commentaire ?', function () {
                    $.ajax({
                        method: "POST",
                        url: "supprimerCommentaire.php",
                        data: {id_commentaire: id},
                        dataType: 'json'
                    })
                        .done(function (result) {
                            console.log(result);
                            if (result.status) {
                                tr.remove();
                            } else {
                                alert("Une erreur est survenue lors de la suppression");
                            }
                        });
                }
                , function () {
                });
        });

    });
</script>

<?php
include("footer.php");
?>

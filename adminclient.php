<?php
include("header-admin.php");
include("fonctions.php");
?>

<?php

// Execution du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $prenom = trim($_POST['prenom']);
    $nom = trim($_POST['nom']);
    $identifiant = trim($_POST['identifiant']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

    insererClient($prenom,
        $nom,
        $identifiant,
        $email,
        $password);

    unset($pdo);
}
?>

<div class="ligne"></div>
<div class="site-section"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Administration du site <a href="" class="btn btn-success event-ajout">Ajouter un
                    client</a></h1>
            <h2 class="sub-header">Liste des Utilisateurs</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Pseudo</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Droit Admin</th>
                            <th>Date de Création</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $users = bdd_user();
                    while ($user = $users->fetch()) {
                        ?>

                        <tr id="<?php echo $user['id']; ?>">

                            <td><?php echo $user['id']; ?></td>
                            <td data-target="prenom"><?php echo $user['prenom']; ?></td>
                            <td data-target="nom"><?php echo $user['nom']; ?></td>
                            <td data-target="identifiant"><?php echo $user['identifiant']; ?></td>
                            <td data-target="email"><?php echo $user['email']; ?></td>
                            <td data-target="password"><?php echo $user['password']; ?></td>
                            <td data-target="admin"><?php echo $user['admin']; ?></td>
                            <td data-target="date_crea"><?php echo $user['created_at']; ?></td>

                            <td>
                                <a href="#update" data-role="update" data-id="<?php echo $user['id']; ?>"
                                   class="btn btn-warning event-edit">Edition</a><br><br>
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

<!-- Modal -->
<div id="modal-edit" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <h2>Edition d'Utilisateur</h2>
                <div class="row">
                    <div class="col-xs-12col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" id="prenom" class="form-control input-lg"
                                   placeholder="Prénom" tabindex="1">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" id="nom" class="form-control input-lg" placeholder="Nom"
                                   tabindex="2">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="text" id="identifiant" class="form-control input-lg"
                           placeholder="Identifiant" tabindex="3">
                </div>

                <div class="form-group">
                    <input type="email" id="email" class="form-control input-lg"
                           placeholder="Adresse Email" tabindex="4">
                </div>

                <div class="form-group">
                    <input type="password" id="password" class="form-control input-lg"
                           placeholder="Mot de passe" tabindex="5">
                </div>
                <input type="hidden" id="userId" class="form-control">
            </div>

            <div class="modal-footer">
                <a href="" id="save" class="btn btn-primary pull-right">Mettre à jour</a>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<div id="modal-ajout" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="modal-body">
                    <h2>Inscription
                        <small> : Made in World</small>
                    </h2>

                    <div class="row">
                        <div class="col-xs-12col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="prenom" class="form-control input-lg"
                                       placeholder="Prénom" tabindex="1">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="nom" class="form-control input-lg" placeholder="Nom"
                                       tabindex="2">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="text" name="identifiant" class="form-control input-lg"
                               placeholder="Identifiant" tabindex="3">
                    </div>

                    <div class="form-group">
                        <input type="email" name="email" class="form-control input-lg"
                               placeholder="Adresse Email" tabindex="4">
                    </div>

                    <div class="form-group">
                        <input type="password" name="mdp" class="form-control input-lg"
                               placeholder="Mot de passe" tabindex="5">
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-6"><input type="submit" value="S'inscrire"
                                                               class="btn btn-primary btn-block btn-lg" tabindex="6">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-3.3.1.min.js"><\/script>')</script>
<script src="js/alertify.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {

        // Modal d'ajout de client en BDD
        $('.event-ajout').on('click', function (e) {
            e.preventDefault();
            $('#modal-ajout').modal('show');
        });

        // Récupération des données de la modal pour la requete d'edition
        $(document).on('click', 'a[data-role=update]', function () {
            var id = $(this).data('id');
            var prenom = $('#'+id).children('td[data-target=prenom]').text();
            var nom = $('#'+id).children('td[data-target=nom]').text();
            var identifiant = $('#'+id).children('td[data-target=identifiant]').text();
            var email = $('#'+id).children('td[data-target=email]').text();
            var password = $('#'+id).children('td[data-target=password]').text();

            $('#userId').val(id);
            $('#prenom').val(prenom);
            $('#nom').val(nom);
            $('#email').val(email);
            $('#identifiant').val(identifiant);
            $('#password').val(password);
            $('#modal-edit').modal('toggle');

        });

        // Création d'evenement pour mettre les données dans les Champs
        // et mise a jour en BDD
        $('#save').click(function () {
            var id = $('#userId').val();
            var prenom = $('#prenom').val();
            var nom = $('#nom').val();
            var identifiant = $('#identifiant').val();
            var email = $('#email').val();
            var password = $('#password').val();

            $.ajax({
                url: 'modifClient.php',
                method: 'post',
                data: {prenom: prenom, nom: nom, identifiant: identifiant, email: email, password: password, id: id},
                success: function (response) {
                    // Mise a jour dans la table Users
                    $('#'+id).children('td[data-target=prenom]').text(prenom);
                    $('#'+id).children('td[data-target=nom]').text(nom);
                    $('#'+id).children('td[data-target=identifiant]').text(identifiant);
                    $('#'+id).children('td[data-target=email]').text(email);
                    $('#'+id).children('td[data-target=password]').text(password);
                    $('#modal-edit').modal('toggle');
                }
            });
        });

        // Evenement de suppression
        $('.event-delete').on('click', function (e) {
            e.preventDefault();

            var id = $(this).parents('tr').data('id');
            var tr = $(this).parents('tr');

            alertify.confirm('Confirmez-vous la suppression ?', 'Êtes-vous sûr de vouloir supprimer ce commentaire ?', function () {
                    $.ajax({
                        method: "POST",
                        url: "supprimerClient.php",
                        data: {id_client: id},
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

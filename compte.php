<?php
include("header2.php");
include("fonctions.php");

// Verification si l'utilisateur est deja loggé,
// Si oui, redirection vers la page d'accueil
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true) {
    header("location: /");
    exit;
}
?>

<div class="site-section"></div>
<div class="container">
    <h2>Bienvenue <b><?php echo htmlspecialchars($_SESSION["identifiant"]); ?></b></h2>
    <h3>Vos informations personnelles :</h3><br/>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Date d'Inscription</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $users = bdd_compte();
            while ($user = $users->fetch()) {
                ?>

                <tr data-id="<?php echo $user['id']; ?>">
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['prenom']; ?></td>
                    <td><?php echo $user['nom']; ?></td>
                    <td><?php echo $user['identifiant']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['created_at']; ?></td>
                </tr>

            <?php }
            ?>
            </tbody>
        </table>
    </div>

    <p>
        <a href="resetmdp.php" class="btn btn-warning">Réinitialiser son mot de passe</a>
        <a href="logout.php" class="btn btn-danger">Se déconnecter</a>
    </p>
</div>


<?php
include("footer.php");
?>

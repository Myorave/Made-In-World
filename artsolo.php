
<?php
include("fonctions.php");

include("header.php");

$id = $_GET['id'];
$article = article_solo($id);

?>

    <section>
        <article>
            <h2><?php echo $article['titre']; ?></h2>
            <p><?php echo $article['contenu']; ?></p>
        </article>
    </section>

<?php
include("footer.php");
?>


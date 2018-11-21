<?php
include("init.php");
?>
<form action="soumettreArticle.php" method="POST">
    <label for="titre">Titre :</label>
    <input type="text" name="titre">
    
    <label for="contenu">Contenu :</label>
    <input type="text" name="contenu">
    
    <button type="submit" class="btn btn-success">Enregistrer</button>     
</form>
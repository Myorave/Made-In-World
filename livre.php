<?php
include("header2.php");
include("config.php");
session_start();
?>

<div class="ligne"></div>
    <div class="site-section"></div>  

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="p-5 bg-white3">
        <div class="site-section  ">
        <div class="row mb-5 justify-content-center text-center">
            <div class="col-12 text-center" >
            <h2 class="font-weight-light text-black display-4">Donner votre avis</h2> </br>
            </div>
            
        <div class="col-4 ">
            <select class="form-control form-control-lg id="titre" name="titre">
                <option value="">Choix de la box</option>
                <option value="Box Economique">Box Economique</option>
                <option value="Box Classique">Box Classique</option>
                <option value="Box Sur Mesure">Box Sur Mesure</option>
            </select>
            <span class="help-block"><?php echo $titre_err ?></span><br/>
        </div>
        <div class="col-4 ">
            <select class="form-control form-control-lg option" id="note" name="note">
                <option value="">Notez cette box</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>   

            <span class="help-block"><?php echo $note_err ?></span><br/>
            <div class="col-8">
            <textarea class="form-control form-rounded " name="contenu" cols="50" rows="10" placeholder="Votre message"></textarea><br/>
        </div>
            <span class="help-block"><?php echo $contenu_err ?></span><br/>
            <div class="col-8">
            <input class="btn btn-primary center" type="submit" name="go" value="Valider"><br/>
        </div>
    </form>
    
    </div>
</div>

<div class="site-section bg-light">
  <div class="row mb-5 justify-content-center">
    <div class="col-12 text-center">
      <h2 class="font-weight-light text-black display-4">Derniers temoignages</h2>
    </div>
    <div class="col-md-7 text-center">
      <p>Voici quelques-uns des temoignages de nos clients.</p>
    </div>
  </div>
  
<?php 

$auteur = $titre = $note = $contenu = "";
$auteur_err = $titre_err = $note_err = $contenu_err = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    // Validation du nom d'utilisateur
    if(empty(trim($_SESSION["identifiant"]))){
        $auteur_err = "Veuillez entrer votre identifiant.";
    } else{
        $auteur = trim($_SESSION["identifiant"]);
    }

    // Verification si le mdp est vide
    if(empty(trim($_POST["titre"]))){
        $titre_err = "Veuillez entrer entrer un titre ";
    } else{
        $titre = trim($_POST["titre"]);
    }

    // Validation de la note
    if(empty(trim($_POST["note"]))){
        $note_err = "Veuillez entrer une note";
    } else{
        $note = trim($_POST["note"]);
    }

    // Verification du contenu
    if(empty(trim($_POST["contenu"]))){
        $contenu_err = "Veuillez entrer votre commentaire";
    } else{
        $contenu = trim($_POST["contenu"]);
    }

    // Debut de requete d'insertion
    if(empty($titre_err) && empty($note_err) && empty($contenu_err) &&  empty($auteur_err)){

            // Préparationn de requete
            $sql= "INSERT INTO commentaire (titre, auteur, contenu, note, date) VALUES (:titre, :auteur, :contenu, :note,  NOW())";    // fonction SQL qui me donne la date 

            if ($resultat) {
                header('Location: livre.php?messageenvoye');
            }

            if($stmt = $pdo->prepare($sql)){
                // Liaison des variables à la requete comme parametres
                $stmt->bindParam(":titre", $titre, PDO::PARAM_STR);
                $stmt->bindParam(":auteur", $auteur, PDO::PARAM_STR);
                $stmt->bindParam(":contenu", $contenu, PDO::PARAM_STR);
                $stmt->bindParam(":note", $note, PDO::PARAM_STR);
    
                // Tentative d'execution de la requete
                if($stmt->execute()){

                  // Redirection à la page de connexion
                    header('Location: livre.php?messageenvoye');

                } else{
                    echo "Une erreur est survenue. Veuillez recommencer.";
                }
            }

            // Fermeture de la requete
            unset($stmt);
        }
    }
        //Requete pour afficher les commentaires
        $comments = "SELECT auteur, titre, contenu, note, date FROM commentaire ORDER BY date DESC";
        $tabcomments= $pdo -> query($comments);

        while ($donnees = $tabcomments->fetch()){
          echo '
          <div class="container">

          <div class="p-4">
            <div class="block-47 d-flex">
              <blockquote class="block-47-quote">
                <h3> '.$donnees['titre'].'</h3>
                <p>&ldquo;'.$donnees['contenu'].'&rdquo;</p>
                <cite class="block-47-quote-author">&mdash; '.$donnees['auteur'].'</cite>
              </blockquote>
            </div>
          </div>
          </div>
        ';
          
           
        }
?>


</div>
</body>
</html>

<?php
include("footer.php");
?>

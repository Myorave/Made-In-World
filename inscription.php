<?php
include("header2.php");

// Verification si l'utilisateur est deja loggé,
// Si oui, redirection vers la page d'accueil
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

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

<div class="site-section"></div>

<div class="container">
  <div class="row">

      <!-- Formulaire d'Inscription -->
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

        <div class="form-group <?php echo (!empty($identifiant_err)) ? 'has-error' : ''; ?>">
            <input type="text" name="identifiant" id="identifiant" class="form-control input-lg" placeholder="Identifiant" tabindex="3" value="<?php echo $identifiant; ?>">
            <span class="help-block"><?php echo $identifiant_err; ?></span>
          </div>

  			<div class="form-group <?php echo (!empty($email)) ? 'has-error' : ''; ?>">
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
  				<div class="col-xs-8 col-sm-9 col-md-12">
  					 En cliquant sur <strong class="label label-primary">"S'inscrire"</strong>, vous acceptez les <strong><a href="#" data-toggle="modal" data-target="#t_and_c_m"><b>Termes & Conditions</b></a></strong> établies par ce site.
  				</div><br/><br/>
  			</div>

  			<div class="row">
  				<div class="col-xs-12 col-md-6"><input type="submit" value="S'inscrire" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
  			</div>
  		</form>

  </div>

  <!-- Modal de Termes et Conditions -->
  <div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-lg">
  		<div class="modal-content">
  			<div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Termes & Conditions</h4>
  				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  			</div>
  			<div class="modal-body">
  				<p>

            <p><b>1 Préambule</b></p>

            <p><b>1.1 Objet des Conditions Générales de Services</b></p>

            <p>Les présentes Conditions Générales de Services (« CGS »), ainsi que les Conditions Particulières (« CP ») spécifiques au(x) Service(s) (telle que la notion est définie ci-après) commandé(s), ont pour objet de définir les conditions et modalités de souscription, de mise à disposition et d’utilisation des Services proposés par Made-in-World sur son site Internet www.Made-in-World.fr.</p>

            <p><b>1.2 Acceptation des CGS</b></p>

            <p>L’acceptation et/ou la validation par le Client (telle que la notion est définie ci-après) d’un Bon de Commande (telle que la notion est définie ci-après) généré par Made-in-World emporte l’acceptation pleine et entière, sans restrictions ni réserves, des présentes CGS et des CP applicables au(x) Service(s) concerné(s). Le Contrat (telle que la notion est définie ci-après) entre Made-in-World et le Client ne prendra effet qu’à l’encaissement complet du paiement des Services souscrits et définis dans le(s) Bon(s) de Commande correspondant(s).</p>

            <p><b>1.3 Contrat – hiérarchie contractuelle</b></p>

            <p>Les présentes CGS, les CP spécifiques au(x) Service(s) souscrit(s) et le(s) Bon(s) de Commande forment le contrat conclu entre les Parties (ci-après le « Contrat »).

            Ces documents contractuels prévalent sur toute proposition, offre commerciale, échange de lettres antérieures et postérieures à la conclusion des présentes, ainsi que sur toute autre disposition figurant dans les documents échangés entre les Parties et relatifs à l’objet des CGS et des CP.

            En cas de contradiction entre les présentes CGS, les CP applicables au(x) Service(s) souscrit(s) et le(s) Bon(s) de Commande correspondant(s), les dispositions contractuelles d’un rang supérieur prévaudront sur celles du rang inférieur dans l’ordre suivant : (i) les présentes CGS ; (ii) les CP et (iii) le Bon de Commande.</p>

            <p><b>1.4 Modifications des CGS et/ou des CP</b></p>

            <p>Le Client est informé que les présentes CGS et les CP peuvent faire l’objet de modifications à tout moment. Ces modifications seront applicables immédiatement aux nouveaux Bons de Commande et/ou aux nouveaux Clients. Pour les Clients dont les Services sont en cours d’utilisation, Made-in-World les informera des modifications ainsi apportées aux présentes CGS et/ou aux CP applicables au(x) Service(s) souscrit(s).

            Toutefois, les modifications des CGS et/ou des CP résultant d’une mise en conformité légale ou réglementaire pourront intervenir immédiatement et sans préavis, dans la mesure où Made-in-World ne les maîtrise pas.

             Si le Client refuse les modifications apportées, il aura la faculté soit de résilier le(s) Service(s) concerné(s) dans un délai maximum d’un (1) mois à compter de la notification adressée par Made-in-World, soit de demander à ce que les anciennes CGS restent applicables jusqu’à l’échéance de son Contrat. Passé ce délai, les modifications apportées aux CGS et aux CP applicables seront considérées comme acceptées par le Client.</p>

            <p><b>2 Modifications des Services</b></p>

            <p>Afin d’améliorer ses Services, Made-in-World se réserve le droit de modifier, à tout moment (soit par l’ajout, soit par la suppression de nouvelles fonctionnalités) les caractéristiques de ses Services, sans que lesdites modifications n’entraînent de modifications substantielles. Ces modifications de caractéristiques des Services seront notifiées au Client par courrier électronique ou via leur Espace Client et seront applicables dès qu’elles seront disponibles.

            Dans l’hypothèse d’une modification substantielle des caractéristiques des Services, ces dernières ne seront applicables que lors du renouvellement des Services souscrits par le Client. A cet égard, Made-in-World fera ses meilleurs efforts pour avertir les Clients de ces modifications avant l’entrée en vigueur de ces dernières.</p>

            <p><b>3 Définitions</b></p>

            <p>Les termes et expressions commençant par une majuscule dans les présentes CGS, qu’ils soient employés au singulier ou au pluriel selon le contexte de leur emploi, auront la signification suivante :</p>

            <p><b>3.1 Made-in-World :</b> désigne la société AGENCE DES MEDIAS NUMERIQUES (Made-in-World), Société par Actions Simplifiées Unipersonnelle, dont le siège social est 12-14 Rond-Point des Champs Elysées - 75008 PARIS, immatriculée au Registre du Commerce et des Sociétés de PARIS sous le numéro B 421 527 797. Made-in-World est une filiale du Groupe DADA et propose différents services Internet, en particulier, l’enregistrement de Noms de domaine, l’hébergement dédié ou mutualisé de sites Internet, le référencement de sites Internet, la création de sites internet et plus généralement tous les services proposés sur le site Internet www.Made-in-World.fr ;</p>

            <p><b>3.2 Autorité(s) :</b> désigne l’ensemble des organismes nationaux ou internationaux responsables de la définition des règles, des procédures et des modalités d’attribution des noms de domaine, de la gestion des bases Whois d’une ou plusieurs extensions de nom de domaine (.COM, .INFO, .BIZ etc.). L’Autorité chargée d’allouer l’espace des adresses de Protocole Internet (IP), d’attribuer les identificateurs de protocole, de gérer le système de nom de domaine de premier niveau pour les codes génériques (gTLD ou ngTLD) et les codes nationaux (ccTLD), et d’assurer les fonctions de gestion du système de serveurs racines est l’ICANN (Internet Corporation for Assigned Names and Numbers), organisation de droit privé à but non lucratif. L’Autorité chargée de l’enregistrement d’un nom de domaine dans une extension nationale (ccTLD) est le NIC (Network Information Center), tel que par exemple l’AFNIC en France pour le « .fr » ;</p>

            <p><b>3.3 Bande Passante :</b> désigne le débit maximum de transmission de données sur le réseau Internet, généralement spécifiée en nombre de bits par seconde, dont le niveau est déterminé par Made-in-World. Elle peut être allouée de manière mutualisée entre plusieurs Clients (Hébergement Mutualisé) ou de manière dédiée à un Client unique (Hébergement Dédié) ;</p>

            <p><b>3.4 Base Whois :</b> désigne la base de données mise à disposition par les Autorités accessible au Client et/ou à tout tiers permettant de déterminer, suivant une requête de recherche, différentes informations concernant un Nom de Domaine, en particulier sa disponibilité, son titulaire, les coordonnées déclarées de ce dernier, le Registrar, etc. et donnant lieu à un Extrait Whois ;</p>

            <p><b>3.5 Bon de Commande :</b> désigne le bon de commande accessible en ligne sur le site Internet de la société Made-in-World https://www.Made-in-World.fr, dûment complété suivant les Services et les caractéristiques techniques de chacun d’entre eux choisis par le Client sur le site Internet d’Made-in-World et transmis par le Client à Made-in-World ;</p>

            <p><b>3.6 Client(s) :</b> désigne toute personne physique ou morale de droit privé ou de droit public, en ce compris le(s) Revendeur(s), souscrivant au(x) Service(s) proposés par Made-in-World pour ses besoins personnels ou pour son activité professionnelle ;</p>

            <p><b>3.7 Conditions Particulières ou CP :</b> désignent les conditions contractuelles spécifiques applicables au(x) Service(s) souscrit(s) par le Client auprès d’Made-in-World ;</p>

            <p><b>3.8 DNS (Domain Name System) :</b> désigne la base de données permettant d’assurer la concordance entre un Nom de Domaine et une Adresse IP ;</p>

            <p><b>3.9 Donnée(s) ou Donnée (s) Client :</b> désigne(nt) l’ensemble des données, contenus graphiques, textuels, vidéos, infographiques, photographiques, logiciels, scripts, développements informatiques, sites internet, etc. de toutes sortes, protégés ou non par un droit de propriété intellectuelle, dont le Client est l’auteur, le propriétaire et/ou le concessionnaire des droits associés et que le Client entend utiliser et exploiter dans le cadre des Services et/ou faire héberger sur des Serveurs attribués dans le cadre du Contrat et des Services y afférents ;</p>

            <p><b>3.10 Données d’Identification :</b> désignent toute information renseignée par le Client permettant à ce dernier de s’identifier auprès d’Made-in-World (nom, prénom, adresse postale, adresse de courrier électronique, numéro de téléphone, raison sociale, et nom d’organisation le cas échéant etc.) ;</p>

            <p><b>3.11 Données Personnelles :</b> désignent les données à caractère personnel des Clients, y compris les Données d’Identification, traitées par Made-in-World dans le cadre du Contrat, ’conformément à la Règlementation sur les Données Personnelles et à la Politique de Confidentialité accessible à l’adresse URL suivante : https://www.Made-in-World.fr/company/privacy.html ;</p>

            <p><b>3.12 Editeur ou Editeur de Logiciels :</b> désigne la personne physique ou morale qui édite un Logiciel et qui est titulaire des droits de propriété intellectuelle sur ce dernier ;</p>

            <p><b>3.13 Eléments d’Identification :</b> désignent l’identifiant de connexion (« Username ») et mot de passe (« Password ») transmis par Made-in-World au Client permettant à ce dernier d’accéder au(x) Service(s) et de le(s) gérer et/ou l’/les administrer via l’Espace Client ;</p>

            <p><b>3.14 Email ou Mail :</b> désigne le courrier électronique transmis via le réseau Internet suivant différents protocoles : POP3, IMAP etc. ;</p>

            <p><b>3.15 Espace Client :</b> désigne l’espace privatif du Client accessible en ligne sur le site Internet de la société Made-in-World à l’adresse URL suivante https://controlpanel.Made-in-World.fr, contenant notamment les informations relatives aux Services fournis par la société Made-in-World et permettant d’y effectuer les opérations de gestion des Services ;</p>

            <p><b>3.16 Extrait Whois ou Whois :</b> désigne la fiche d’identité d’un Nom de Domaine contenant les informations fournies notamment par son titulaire (nom, prénom, coordonnées postales et téléphonique, etc.) gérée par les Autorités (dont notamment les NIC) et les Registrars par le biais de bases de données appelées bases Whois ;</p>

            <p><b>3.17 IP ou Adresse IP :</b> désigne l’adresse sous forme d’une suite de chiffres qui permet d’identifier de manière unique chaque serveur connecté sur Internet, dont l’attribution est effectuée par Made-in-World dans le cadre du Service ;</p>

            <p><b>3.18 Logiciel :</b> désigne l’ensemble des programmes informatiques, bases de données, scripts, procédés, systèmes d’exploitation, etc., ayant pour objet le traitement automatique de données, mis à la disposition du Client par Made-in-World et/ou par leur Editeur respectif dans le cadre du Service ;</p>

            <p><b>3.19 Netiquette :</b> désigne l’ensemble des règles de conduite et de politesse recommandées pour l’usage d’Internet ;</p>

            <p><b>3.20 Nom(s) de Domaine :</b> désigne un identifiant ou une adresse sur le réseau Internet quelle que soit l’extension générique (gTLD – generic Top Level Domain : « .com », « .net », « .biz », etc.) ou nationale (ccTLD : country code Top Level Domain : « .fr », « .be », etc.) ou encore nouvelle (NgTLDs : new generic Top Level Domain https ://newgtlds.icann.org/en/applicants/agb) enregistré par le Client par l’intermédiaire de la société Made-in-World auprès de l’Autorité (en particulier du NIC) ou du Registrar compétent et/ou dont la gestion a été confiée par le Client à Made-in-World ;</p>

            <p><b>3.21 Partie(s) :</b> désigne Made-in-World et/ou le Client ;</p>

            <p><b>3.22 Plateforme :</b> désigne l’ensemble d’équipements techniques tels que les Serveurs, switch, load balancer, etc., permettant à Made-in-World d’assurer le(s) Service(s) ;</p>

            <p><b>3.23 Politique de Confidentialité :</b> document accessible à l’adresse URL https://www.Made-in-World.fr/company/privacy.html faisant partie intégrante des présentes CGS et ayant pour objet de définir les conditions dans lesquelles Made-in-World collecte et traite les Données Personnelles des Clients et utilisateurs de ses Services ;</p>

            <p><b>3.24 Quarantaine ou Rédemption : </b>désigne le statut dans lequel passent certains Noms de domaine (.eu, .be notamment), une fois expirés faute de renouvellement. Les Noms de domaine restent sous ce statut pendant une période de temps fixée et gérée par l’Autorité concernée, avant leur suppression définitive des bases de données de cette dernière. Une fois en période dite de « quarantaine » (pour les Noms de domaine en « .be » notamment) ou dite de « rédemption » (pour les Noms de domaine génériques ou gTLDs), des frais supplémentaires sont imposés par l’Autorité concernée pour réactiver le Nom de domaine et sont dus par le Client en plus des frais de renouvellement du Nom de domaine ;</p>

            <p><b>3.25 Registrar :</b> désigne l’organisation autorisée par le Registry à intervenir dans la base de données de l’extension concernée (par exemple le « .com », le « .net ») pour y effectuer les opérations de gestion telles que l’enregistrement, le renouvellement, le transfert de noms de domaine, etc. ;</p>

            <p><b>3.26 Registry :</b> désigne l’organisme habilité par l’Autorité, en particulier l’ICANN, à gérer une ou plusieurs extensions de noms de domaine, à définir les règles de nommage et à gérer la base de données correspondante. Par exemple Afilias pour les « .info », Verisign pour les « .com » et les « .net », Dotmobi pour les « .mobi », etc. ;</p>

            <p><b>3.27 Réglementation sur les Données Personnelles :</b> désigne la Loi n°78-17 du 6 janvier 1978 relative à l’informatique, aux fichiers et aux libertés, modifiée le 7 octobre 2016, ainsi que toute réglementation qui viendrait à s’appliquer en matière de données personnelles, en particulier en application du Règlement communautaire du 27 avril 2016 publié au Journal Officiel de l’Union Européenne le 4 mai 2016 relatif à la protection des personnes physiques à l’égard du traitement des données à caractère personnel et à la libre circulation de ces données ;</p>

            <p><b>3.28 Ressources Système :</b> désignent la capacité de stockage, de mémoire vive (RAM) et de mémoire morte (ROM) du Serveur, ainsi que de son processeur, les Logiciels qui y sont associés, ainsi que la capacité en Bande Passante mis à la disposition des Clients par Made-in-World dans le cadre du Service ;</p>

            <p><b>3.29 Restrictions Techniques :</b> désignent les restrictions techniques d’utilisation et d’exploitation du Service fixées par Made-in-World du fait notamment des caractéristiques du Serveur/des Plateformes, de la politique commerciale d’Made-in-World, des choix technologiques d’Made-in-World et des évolutions technologiques, etc. ;</p>
             
            <p><b>3.30 Revendeur(s) :</b> désigne toute personne physique ou morale exerçant son activité en qualité de professionnel de l’Internet, à l’exclusion de tout consommateur, qui contracte en son nom auprès de la société Made-in-World et pour le compte de ses propres clients finaux. Dans le cadre des présentes CGS, il souscrit aux mêmes engagements et obligations que ceux impartis au Client ;</p>

            <p><b>3.31 Serveur(s) :</b> désigne(nt) le(s) serveur(s) informatique(s), à l’exception des Logiciels, permettant à Made-in-World d’assurer le(s) Service(s) ;</p>

            <p><b>3.32 Service(s) :</b> désigne(nt) l’ensemble des prestations et services fournis par Made-in-World, décrits sur son site Internet www.Made-in-World.fr et dont la souscription et l’utilisation sont régies par les présentes CGS et les CP spécifiques applicables ;</p>

            <p><b>3.33 Service(s) Additionnel(s) :</b> désigne(nt) les prestations non fournies dans le cadre du Service et dont le Client souhaiterait bénéficier. Ils font alors l’objet d’une commande spécifique ou complémentaire de la part du Client auprès d’Made-in-World et sont régis par des CP spécifiques ;</p>

            <p><b>3.34 Service(s) Gratuit(s) :</b> désigne(nt) les prestations fournies par Made-in-World ou son sous-traitant sans contrepartie financière dans le cadre du Service ;</p>

            <p><b>3.35 Services d’Hébergements Dédiés :</b> désignent les services par lesquels Made-in-World fournit des prestations de stockage des Données Client par la mise à disposition d’un Serveur de Ressources Système, de Logiciels et de Bande Passante à un seul Client qui en est l’administrateur unique, permettant de rendre accessible les Données Client sur le réseau Internet. Les Services d’Hébergements Dédiés sont régis par les CP accessibles en cliquant ici : https://www.Made-in-World.fr/a-propos/information-legale/conditions-particulieres-serveur-virtuel/ et https://www.Made-in-World.fr/a-propos/information-legale/conditions-particulieres-serveur-dedie/ ;</p>

            <p><b>3.36 Service(s) d’Hébergement Mutualisé :</b> désigne(nt) le(s) service(s) par le(s)quel(s) Made-in-World met à disposition du Client un espace de stockage, tel que défini dans le Bon de Commande, sur le Serveur/les Plateformes de la société Made-in-World, auquel sont associées des Ressources Système, dont l’utilisation est partagée par plusieurs Clients, permettant de rendre accessible les Données Client sur le réseau Internet. Le(s) Service(s) d’Hébergement Mutualisé est/sont régi(s) par les CP accessibles en cliquant ici : https://www.Made-in-World.fr/a-propos/information-legale/conditions-particulieres-hebergement/ ;</p>

            <p><b>3.37 Services de courrier électronique :</b> désigne(nt) le(s) service(s) de courrier électronique fournis par Made-in-World, à l’exception du Service de Redirection ;</p>

            <p><b>3.38 Service de Redirection : </b>désigne le service de redirection automatique d’un Nom de Domaine vers une adresse Internet ou une URL (Uniform Ressource Locator) déterminée par le Client et/ou d’une adresse de courrier électronique établie sur la base d’un Nom de Domaine vers une autre adresse de courrier électronique ;</p>

            <p><b>3.39 Spam :</b> désigne la communication électronique non sollicitée par son destinataire envoyée par mail, en masse ou isolé, le plus souvent à des fins publicitaires, frauduleuses, commerciales, etc., dont l’envoi est notamment et pour partie réprimé par les dispositions de l’article L.34-5 du Code des postes et communications électroniques ;</p>

            <p><b>3.40 Trafic :</b> désigne la quantité de données informatiques transmises ou reçues par le Client sur ou en provenance du Serveur et/ou du Site Internet pour une période donnée. Le trafic mensuel est mesuré en quantité de données transférées depuis et vers le Site Internet ou le Serveur du Client et exprimé en Méga Octets (Mo), en Giga Octets (Go) ou en Téra Octets (To).</b></p>
             
            <p><b>4 Durée – Renouvellement des Services</b></p>

            <p><b>4.1 Mise à disposition des Services</b></p>

            <p>Les présentes CGS prennent effet au jour de la transmission par le Client à Made-in-World du Bon de Commande et du paiement corrélatif. Elles sont conclues pour la durée déterminée définie dans le Bon de Commande. La mise à disposition du/des Service(s) sera effective au jour de l’encaissement par Made-in-World du complet paiement des Services souscrits par le Client.</p>

            <p><b>4.2 Renouvellement des Services</b></p>

            <p>Sauf dans l’hypothèse où le Client choisit l’option de renouvellement automatique des Services dans les conditions définies à l’article 4.3 et si le Client ne les a pas dûment reconduits et réglés avant leur date d’expiration selon les modalités décrites ci-après ou à la date maximale à laquelle les Services pourront être renouvelés le cas échéant, le Client est informé que tous les Services seront automatiquement interrompus et supprimés à leur date d’échéance telle que mentionnée dans le Bon de Commande, l’Espace Client et dans la confirmation de souscription aux Services adressée au Client par courrier électronique lors de la conclusion du Contrat.

            Au plus tôt trente (30) jours avant la date d’expiration des Services ou au plus tard à la date maximale à laquelle ils pourront être renouvelés le cas échéant, Made-in-World notifiera au Client par courrier électronique, l’échéance prochaine de son Contrat en l’invitant – s’il souhaite continuer à bénéficier des Services – à le renouveler avant cette date. Pour ce faire, le Client sera invité à adresser avant la date limite mentionnée dans son Espace Client et au plus tard sept (7) jours avant le terme du présent Contrat, un Bon de Commande dûment complété ainsi que le paiement effectif entre les mains d’Made-in-World, du prix des Services renouvelés.</p>

            <p><b>4.3 Option de renouvellement automatique des Services</b></p>

            <p><b>4.3.1 Description de l’option</b></p>

            <p>Made-in-World propose au Client, au moment de la souscription au Service, de choisir l’option de « Renouvellement automatique » du Contrat aux termes de laquelle, le Contrat et l’ensemble des Services souscrits par le Client seront automatiquement renouvelés pour une durée identique à celle prévue dans le Bon de Commande.

            Le Client est informé qu’il aura la faculté, à tout moment au cours de l’exécution du Contrat et au plus tard vingt-et-un (21) jours avant le terme de son Contrat lorsque le paiement des Services s’effectue par Carte Bancaire et par PayPal et au plus tard dix-neuf (19) jours avant le terme de son Contrat lorsque le paiement des Services s’effectue par crédit compte sur son Espace Client, d’annuler l’option de renouvellement automatique en se connectant à son Espace client ou en contactant Made-in-World dans les délais impartis via la messagerie électronique accessible depuis la rubrique Assistance de son Espace Client.</p>

            <p><b>4.3.2 Mode de paiement requis</b></p>

            <p>Dans l’hypothèse du choix par le Client de l’option de renouvellement automatique, le Client est informé qu’il devra sélectionner exclusivement l’un des trois (3) modes de paiement suivants : règlement par carte bancaire ou via un compte PayPal ou via leur crédit compte sur leur Espace Client.</p>

            <p><b>4.3.3 Avis de renouvellement automatique</b></p>

            <p>Conformément aux dispositions des articles L.215-1 et suivants du Code de la Consommation dont les termes sont reproduits ci-dessous, Made-in-World informera le Client au plus tôt trois (3) mois et au plus tard un (1) mois avant la date à laquelle le Client aura la faculté de refuser le renouvellement automatique de son Contrat, par courrier électronique dédié, de la possibilité de ne pas procéder à la reconduction des Services souscrits, ainsi que la date à laquelle le Client pourra – au plus tard le 21ème jour avant la date d’expiration du Service en cas de paiement par carte bancaire et Paypal, au plus tard le 19ème jour avant la date d’expiration du Service en cas de paiement par crédit compte – informer Made-in-World de son intention de ne pas renouveler le Contrat.

            L’article L.215-1 du Code de la consommation dispose que : « Pour les contrats de prestations de services conclus pour une durée déterminée avec une clause de reconduction tacite, le professionnel prestataire de services informe le consommateur par écrit, par lettre nominative ou courrier électronique dédiés, au plus tôt trois mois et au plus tard un mois avant le terme de la période autorisant le rejet de la reconduction, de la possibilité de ne pas reconduire le contrat qu’il a conclu avec une clause de reconduction tacite. Cette information, délivrée dans des termes clairs et compréhensibles, mentionne, dans un encadré apparent, la date limite de non-reconduction. Lorsque cette information ne lui a pas été adressée conformément aux dispositions du premier alinéa, le consommateur peut mettre gratuitement un terme au contrat, à tout moment à compter de la date de reconduction. Les avances effectuées après la dernière date de reconduction ou, s’agissant des contrats à durée indéterminée, après la date de transformation du contrat initial à durée déterminée, sont dans ce cas remboursées dans un délai de trente jours à compter de la date de résiliation, déduction faite des sommes correspondant, jusqu’à celle-ci, à l’exécution du contrat. Les dispositions du présent article s’appliquent sans préjudice de celles qui soumettent légalement certains contrats à des règles particulières en ce qui concerne l’information du consommateur ».

            L’article L.215-2 du Code de la consommation dispose que : « Les dispositions du présent chapitre ne sont pas applicables aux exploitants des services d’eau potable et d’assainissement ».

            L’article L.215-3 du Code de la consommation dispose que : « Les dispositions du présent chapitre sont également applicables aux contrats conclus entre des professionnels et des non-professionnels ».

            L’article L.241-3 du Code de la consommation dispose que : « Lorsque le professionnel n’a pas procédé au remboursement dans les conditions prévues à l’article L. 215-1, les sommes dues sont productives d’intérêts au taux légal ».

            Dès que le Contrat sera renouvelé de manière automatique, Made-in-World adressera au Client, sans délai, un courrier électronique confirmant son renouvellement, le prix du Contrat et la durée pour laquelle les Services ont été renouvelés.

            Les présentes CGS resteront en vigueur jusqu’à l’expiration des dernières CP applicables aux Services dont la durée est prévue dans le Bon de Commande. Aucun paiement ne fera l’objet d’un remboursement, même en cas de suspension, d’annulation ou de transfert de Services avant l’issue de la période contractuelle, sauf dispositions particulières prévues ci-dessous.

            Dans l’hypothèse où l’encaissement échouerait après trois (3) tentatives, le renouvellement automatique se transformera en renouvellement manuel. Le Client reconnaît et accepte dans ce cas qu’il lui incombera de renouveler lui-même ses Services avant la date indiquée dans l’avis d’échéance des Services et ce, en se rendant directement dans son Espace Client et suivant les instructions de renouvellement, faute de quoi les Services seront désactivés sans récupération possible.</p>

            <p><b>5 Droit de rétractation du Client Consommateur</b></p>

            <p>Les stipulations qui suivent sont applicables exclusivement au Client ayant la qualité de Consommateur au sens des dispositions du Code de la consommation.</p>

            <p><b>5.1 Modalités d’exercice du droit de rétractation du Client Consommateur</b></p>

            <p>Conformément aux dispositions des articles L.221-18 du Code de la consommation et suivants, le Client Consommateur bénéficie d’un droit de rétractation qu’il pourra exercer dans un délai de quatorze (14) jours à compter du lendemain de la date de souscription de son Bon de Commande, pour demander à Made-in-World l’annulation des Services souscrits et le remboursement corrélatif du prix des Services.

            Pour ce faire, le Client Consommateur est invité à : (i) soit adresser à Made-in-World une demande libre en ce sens et dénuée de toute ambigüité exprimant son intention de se rétracter ; (ii) soit adresser à Made-in-World le formulaire type de rétractation accessible sur le site internet d’Made-in-World en cliquant ici https://www.Made-in-World.fr/wp-content/uploads/Formulaire_de_retractation.pdf.

            Le Client Consommateur peut ainsi faire parvenir à Made-in-World sa demande de rétractation du Contrat : (i) soit par lettre recommandée avec accusé de réception adressée au siège social d’Made-in-World dont les coordonnées figurent à l’article 3.1 des présentes CGS ; (ii) soit par courrier électronique à l’adresse suivante : office@Made-in-World.fr ; (iii) soit par le biais de son Espace Client.

            Si le Client a valablement exercé son droit de rétractation, le remboursement interviendra dans les conditions de l’article L.221-24 du Code de la consommation au plus tard dans un délai de quatorze (14) jours, par le même moyen que celui utilisé pour régler son Bon de Commande, excepté lorsque la carte bancaire qui a servi au paiement n’est plus valide. Dans ce cas, le remboursement interviendra par virement bancaire. Le Client devra pour ce faire nécessairement joindre un Relevé d’Identité Bancaire (RIB) à sa demande afin qu’elle aboutisse.

            Le délai de remboursement peut varier en fonction du mode de règlement de la commande choisi par le Client.

            Le Client a la possibilité de demander expressément que l’exécution immédiate du Service commandé commence avant la fin du délai de rétractation mentionné à l’article L. 221-18 du Code de la consommation et de renoncer par-là de manière expresse à son droit de rétractation.</p>

            <p><b>5.2 Services exclus</b></p>

            <p>Conformément aux dispositions de l’article L.221-28 du Code de la consommation, le Client Consommateur est informé qu’il ne pourra pas exercer son droit de rétractation pour :

            (i) le prix et tous les frais associés au Nom de Domaine, y compris en cas d’échec de l’enregistrement et/ou du transfert et/ou du renouvellement pour des raisons indépendantes d’Made-in-World et/ou du fait du Client ;
            (ii) toute commande de renouvellement, d’upgrade et/ou de modification de Service(s) ; (iii) tous les services additionnels.
            (iii) les Services pleinement exécutés avant la fin du délai de rétractation ou pour les biens et Services confectionnés selon les spécifications du consommateur ou nettement personnalisés (ex : Services d’enregistrement de Noms de Domaine, etc.)
            (iv) ainsi que plus généralement pour les Services additionnels souscrits pendant l’exécution du Contrat.

            Le Client Consommateur en sera informé lors de la souscription de son Bon de Commande et sera invité à confirmer sa renonciation au bénéfice de son droit de rétractation.</p>

            <p><b>6 Services à l’essai</b></p>

            <p>Made-in-World pourra offrir à ses Clients des Services à l’essai pour la durée et selon les modalités prévues sur le site Internet de la société Made-in-World et/ou dans l’Espace Client.

            Le Service sera considéré expiré à la fin de la période d’essai telle qu’indiquée sur le site Internet de la société Made-in-World. Tout au long de la période, le Client a le choix entre souscrire au Service objet de l’essai, ou ne pas y souscrire. Si le Client décide d’y souscrire, il pourra commander le Service en suivant les modalités telles que fournies par Made-in-World, avant l’expiration de la période d’essai.

            Chaque offre de Service à l’essai bénéficie automatiquement de l’option de renouvellement automatique telle que prévue à l’article 4.3 des présentes CGS. Le Client en sera informé au préalable et aura la possibilité de s’opposer à ce renouvellement tacite. Dans le cas où le Service ne serait pas régulièrement commandé et réglé avant la fin de la période d’essai, il sera supprimé à échéance.

            Il appartient au Client, en tant que de besoin, d’effectuer la sauvegarde de ses Données associées au Service à l’essai, lesquelles ne seront plus accessibles ni récupérables après échéance.

            Il est entendu que la souscription aux Service(s) par le Client, y compris pour une période d’essai, conformément aux modalités indiquées par Made-in-World, implique l’acceptation totale des termes des présentes CGS et des CP correspondantes.</p>

            <p><b>7 Procédure d’inscription et de souscription aux Services Made-in-World</b></p>

            <p><b>7.1 Modalités d’inscription et/ou de souscription aux Services Made-in-World</b></p>

            <p>L’inscription et/ou la souscription aux Services Made-in-World se fait essentiellement en ligne via le site Internet www.Made-in-World.fr et via les réseaux sociaux en créant et/ou en associant le compte social à un compte Made-in-World existant. Cependant, le Client est informé que l’inscription et/ou à la souscription aux Services par téléphone est également possible, de manière occasionnelle et lorsque cela est précisé sur la page de présentation du Service en cause.</p>

            <p><b>7.2 Données d’Identification</b></p>

            <p>Lors de son inscription et de la souscription aux Services Made-in-World, le Client s’engage à suivre les indications fournies sur le site Internet www.Made-in-World.fr et/ou par le téléopérateur Made-in-World et/ou sur le réseau social en question et à lui fournir ses Données d’Identification (nom, prénom, adresse postale, adresse email, raison sociale et nom d’organisation le cas échéant, etc.) de façon correcte, exacte et véridique.

            Le Client a également la possibilité de s’inscrire en se connectant avec son compte « Facebook », en cliquant simplement sur le lien « Connexion avec Facebook ».

            Dans cette hypothèse, Facebook enverra automatiquement à Made-in-World certaines des données personnelles spécifiées dans la fenêtre contextuelle correspondante affichée au moment de la demande, et le Client n’aura pas besoin de remplir le formulaire d’inscription.

            Le Client a également la possibilité de lier son compte Made-in-World avec son compte Facebook en cliquant sur « Connexion avec Facebook » puis « Lier le compte » : de cette façon, ses Données d’Identification seront liées au mot de passe utilisateur Facebook du Client, après quoi il suffira simplement cliquer sur "Connexion avec Facebook" pour accéder directement au panneau de configuration Made-in-World sans avoir besoin d’entrer d'autres données.
             
            De la même manière, Made-in-World permet également de lier le compte Made-in-World avec un compte Google, Twitter et LinkedIn. Dans ces cas également, les sites de réseaux sociaux concernés envoient certaines des données à Made-in-World, comme indiqué dans la fenêtre contextuelle relative affichée au moment de la demande.

            S’il communique ses Données d’Identification par téléphone au téléopérateur, le Client devra suivre une procédure de confirmation de ses coordonnées. Cette confirmation devra être effectuée dans un délai de dix (10) jours calendaires maximum. Passé ce délai et en l’absence de confirmation de ses Données d’Identification par le Client, le(s) Service(s) souscrit(s) ne lui sera/seront pas délivrés. L’absence de confirmation par le Client de ses Données d’Identification dans le délai précité, sera considérée comme un manquement grave aux obligations du Client emportant la résiliation de plein droit du Contrat. La confirmation par le Client de ses Données d’Identification exonérera Made-in-World de toute responsabilité quant à la qualité et l’authenticité de ses Données d’Identification fournies par le Client.

            Dans tous les cas de souscription de la commande – selon la procédure en ligne ou par téléphone – le Client est tenu de tenir régulièrement à jour ses Données d’Identification en suivant les procédures fournies par Made-in-World et en se connectant sur son Espace Client.

            <p><b>7.3 Attribution au Client d’Eléments d’Identification</b></p>

            <p>Lors de son inscription et de la souscription aux Services Made-in-World, le Client se verra attribuer des Eléments d’Identification. Le Client reconnaît et accepte que ces Eléments d’Identification constituent l’unique système de validation des accès du Client aux Services et à l’Espace Client, à l’exclusion de tout autre moyen.

            Le Client accepte que tous les actes effectués en utilisant ses Eléments d’Identification susmentionnés soient considérés comme ayant été effectués de plein droit par le Client lui-même et fassent foi.

            Le Client reconnaît être l’unique responsable des actes effectués au moyen de ses Eléments d’Identification. Il s’oblige à maintenir et à conserver ces Eléments d’Identification strictement confidentiels, à ne pas les divulguer à des tiers même temporairement sous quelque forme que ce soit et à ne les utiliser qu’à titre strictement personnel.

            Il appartient au Client en cas de perte, de vol ou de tout acte frauduleux à l’égard des Eléments d’Identification d’en informer Made-in-World dans les meilleurs délais par courrier électronique à l’adresse suivante office@Made-in-World.fr et de justifier de son identité par tous moyens.

            A réception de cette notification écrite dûment justifiée, Made-in-World procédera à l’étude du dossier et pourra, par mesure de sécurité, suspendre tout accès à l’Espace Client. Made-in-World traitera la demande du Client dans les meilleurs délais et lui transmettra en retour par courrier électronique les nouveaux Eléments d’Identification. Le Client demeure responsable de l’utilisation du Service par des tiers jusqu’à la modification par Made-in-World des Eléments d’Identification ou la suspension du Service.

            Le Client garantit et relève indemne Made-in-World de toute réclamation ou action du fait de la perte de Nom de Domaine ou de Données Client résultant de la perte ou de l’usage frauduleux des Eléments d’Identification. La modification de tout ou partie des Eléments d’Identification du Client donnera lieu, le cas échéant, à facturation, sauf modification de ceux-ci à l’initiative d’Made-in-World.</p>

            <p><b>8 Nature des Services – montants et paiements</b></p>

            <p><b>8.1 Nature des Services</b></p>

            <p>La nature et le type des Services fournis par Made-in-World sont décrits dans le Bon de Commande accepté par le Client et les CP applicables dont le Client aura accepté les termes lors de la souscription auxdits Services sur le site Internet https://www.Made-in-World.fr.</p>

            <p><b>8.2 Montants requis pour les Services</b></p>

            <p>Les montants requis pour les Services ainsi que les modalités, les termes et les délais de paiement sont communiqués par courrier électronique dédié et/ou sur le site Internet d’Made-in-World en tout état de cause avant la conclusion du Contrat.</p>

            <p><b>8.3 Conditions et modalités de paiement des Services</b></p>

            <p>Le Client est informé que la mise à disposition des Services souscrits ne sera effective qu’au jour du parfait encaissement par Made-in-World des sommes dues et de la transmission par Made-in-World au Client de ses Eléments d’Identification lui permettant d’accéder à son Espace Client.

            Le Client est tenu de régler les montants totaux tels que précisés dans le Bon de Commande, y compris la TVA, et de prendre à sa charge tous les frais associés au règlement, notamment les frais de virement (tant en émission qu’en réception).

            Le Client est également tenu de payer tous les frais supplémentaires requis par Made-in-World inhérents à l’enregistrement et au renouvellement des Noms de Domaine et/ou par les Autorités tels que les frais de renouvellement en retard, les frais de Rédemption ou de Quarantaine pour les Noms de Domaine expirés, etc. Ces éventuels frais supplémentaires sont indiqués dans l’Espace Client et/ou sur le Site Internet d’Made-in-World.

            En cas de paiement par chèque ou par virement bancaire, le Client est tenu de communiquer le numéro de commande, ses Données d’Identification, le numéro de son compte client, le cas échéant, le Nom de Domaine concerné, ainsi que tout élément permettant d’identifier le règlement et la commande correspondante.

            Le Client est informé que tout paiement partiel ou incident de paiement résultant, notamment, du fait de l’expiration de la carte bancaire renseignée ou d’un solde insuffisant sur le compte bancaire empêchera l’exécution du Contrat et/ou la reconduction de ce dernier par Made-in-World. Il appartient donc au Client de s’assurer que ses informations de facturation sont à jour, complètes et exactes et que son compte bancaire est suffisamment approvisionné.

            Le Client est informé que dans le cas où il souscrit au Service d’enregistrement d’un Nom de Domaine inclus dans le Bon de Commande, ce dernier ne sera enregistré auprès des Autorités compétentes qu’après encaissement du complet règlement par Made-in-World. Il est entendu qu’une commande non réglée comportant l’enregistrement d’un Nom de Domaine, ne peut valoir réservation effective dudit Nom de Domaine, ce dernier pouvant en conséquence être enregistré par un tiers au moment de l’encaissement par Made-in-World de la somme due.

            Made-in-World ne saurait être tenue responsable de toute perte de Nom de Domaine, de Données Client, de retard dans le traitement de la commande, etc., du fait du non-respect par le Client de l’une quelconque des dispositions prévues au présent article 8.</p>

            <p><b>8.4 Modification des prix des Services</b></p>

            <p>Made-in-World se réserve la faculté de modifier à tout moment le prix de ses Services. Les changements de prix seront applicables immédiatement à tout nouveau Bon de Commande.

            Dans l’hypothèse d’une augmentation du prix du Service en cours, le Client en sera informé suivant un délai d’un (1) mois avant l’augmentation effective du prix du Service en cours.

            Le Client disposera ainsi d’un délai d’un (1) mois pour résilier sans pénalités le(s) Service(s) en cours (i) soit par courrier électronique à l’adresse suivante : office@Made-in-World.fr ; (ii) soit par le biais de son Espace Client. A défaut de résiliation, le Client est réputé avoir accepté la modification du prix du Service.

            Le délai précité est étendu à trois (3) mois dans l’hypothèse d’un Client ayant la qualité de Consommateur au sens des dispositions du Code de la consommation. La résiliation entraînera un remboursement du prix du Service sur la période comprise entre la date d’augmentation du prix du Service et la date de résiliation du Service par le Client Consommateur.

            La faculté de résiliation telle que ci-avant précisée n’est pas applicable en cas d’augmentation des prix des Services résultant de circonstances imprévisibles au sens de l’article 1195 du Code civil. Dans cette hypothèse, il sera fait application des dispositions de l’article précité.</p>

            <p><b>8.5 Données de paiement du Client</b></p>

            <p>Le Client est informé qu’en se rendant sur son Espace Client pour désactiver l’option de renouvellement automatique des Services, il aura la faculté de demander, à tout moment, la suppression de ses données bancaires auprès du prestataire de paiement d’Made-in-World.

            En cas de paiement des Services via son compte PayPal® le Client aura également la faculté d’annuler son accord de facturation en se rendant pour ce faire sur la page dédiée de son compte PayPal®.</p>

            <p><b>8.6 Facture</b></p>

            <p>Les factures seront disponibles via l’Espace Client et seront adressées par courrier électronique à l’adresse de courrier électronique renseignée dans l’Espace Client. Le Client est donc tenu de mettre à jour son adresse de courrier électronique renseignée dans son Espace Client en toute circonstance.

            Toute contestation relative à la facturation et la nature des Services devra être notifiée à Made-in-World, via l’Espace Client dans un délai de trente (30) jours à compter de la date d’émission de la facture par Made-in-World. Faute de respecter ce délai, et sans préjudice de la faculté du Client de contester la facturation a posteriori, le Client est tenu de s’acquitter des factures impayées dans les conditions prévues au Contrat.</p>

            <p><b>9 Utilisation des Services et responsabilité du Client</b></p>

            <p><b>9.1 Déclarations et garanties du Client</b></p>

            <p>Le Client s’engage, déclare et garantit :

            - avoir procédé, préalablement à la souscription au(x) Service(s), à la vérification de l’adéquation du/desdit(s) Service(s) à ses besoins ;

            - avoir reçu d’Made-in-World toutes les informations et conseils qui lui étaient nécessaires pour souscrire au présent Contrat et aux CP applicables, et qu’en conséquence, il renonce à toute contestation sur ce point ;

            - disposer des connaissances, compétences et des ressources, notamment humaines et techniques, requises pour l’utilisation du/des Service(s) ;

            - fournir des Données d’Identification parfaitement exactes, justes et sincères, en tout temps et veiller à les mettre à jour tout au long de la durée de son Contrat ;

            - utiliser les Services avec le plus grand soin, en respectant les règles d’utilisation et Restrictions Techniques indiquées dans les CP et/ou sur le site Internet d’Made-in-World et/ou précisés par Made-in-World (notamment lors de ses échanges avec Made-in-World en rapport avec les Services) ;

            - ne pas utiliser les Services à des fins illicites et ne violer aucune norme nationale et internationale, dispositions législatives, règlementaires et administratives applicables, telles que notamment les dispositions relatives au fonctionnement du commerce électronique, à l’information notamment des consommateurs, à la protection des mineurs, au respect de la dignité humaine, à la propriété intellectuelle, à la protection de la vie privée et, plus généralement, aux droits des tiers, notamment par la publication de contenus diffamants, dénigrants, obscènes, révisionnistes, faisant l’apologie de la commission de crimes ou de délits et, plus généralement, contraires aux lois et/ou aux règlements et/ou à la jurisprudence en vigueur. Le Client garantit en particulier qu’il dispose, pour l’utilisation et l’exploitation du/des Service(s), de l’ensemble i) des droits de propriété intellectuelle y afférents notamment en ce qui concerne les Données Client, ii) des autorisations requises de tiers, notamment au titre de l’exploitation de leur image, biens, etc., ainsi qu’à la mise en place de liens hypertextes. Le Client s’engage en outre à respecter les règles de la Netiquette ;

            - disposer de l’ensemble des autorisations et déclarations administratives nécessaires à l’exploitation du Service et notamment de l’utilisation sous toute forme (stockage, diffusion, communication, modification, représentation, reproduction, etc.) des Données Client. Il garantit en particulier i) avoir procédé aux déclarations préalables de traitements de Données Personnelles collectées ou exploitées à partir du Service souscrit auprès de la Commission Nationale de l’Informatique et des Libertés (CNIL : www.cnil.fr) ii) indiquer sur son site Internet toutes mentions légales obligatoires, en particulier le nom du directeur de la publication de son site Internet ou les noms et coordonnées complètes du Client, ainsi que les noms et coordonnées d’Made-in-World en qualité d’hébergeur. Le Client s’engage à procéder lui-même, sans une quelconque intervention d’Made-in-World à toutes les démarches imposées par les lois et règlements. Made-in-World ne saurait être tenue responsable de tout litige ou condamnation qui pourrait survenir du fait du non-respect par le Client des réglementations applicables ;

            - consulter régulièrement son Espace Client et prendre connaissance de toutes les communications que lui transmet Made-in-World. Il s’engage également à coopérer activement avec Made-in-World pour l’activation et/ou le bon fonctionnement du/des Service(s) ;

            Toute utilisation du Service à des fins d’attaque, de piratage, d’intrusion, de déni de service, d’hameçonnage (phishing), d’envoi de courrier électronique non sollicité (en masse spamming ou isolé), d’envoi de virus ou toutes autres activités illégales, telles que définies par la loi et/ou les règlements et/ou la jurisprudence sont parfaitement interdites.</p>

            <p><b>9.2 Responsabilité du Client</b></p>

            <p>Le Client assume l’ensemble des risques et périls liés à ses activités directement ou indirectement effectuées par l’intermédiaire des Services ou pouvant y être liées (contenu diffusé ou hébergé, emails, etc.) et demeure le seul et unique responsable de l’utilisation des Services mis à sa disposition et du respect des présentes CGS.

            Si le Client souscrit au(x) Service(s) dans le cadre de son activité professionnelle, il s’’engage à souscrire et maintenir en vigueur, auprès d’un organisme notoirement solvable, une assurance couvrant l’ensemble des risques liés à l’exploitation de son activité et l’ensemble des dommages susceptibles de lui être imputés dans le cadre de l’utilisation des Services, en particulier les dommages indirects qui pourraient en résulter.</p>

            <p><b>9.3 Garanties</b></p>

            <p>Made-in-World, les autres sociétés du groupe DADA et leurs sous-traitants déclinent toute responsabilité pour tout litige, plainte, réclamation, contestation, condamnation, poursuite, etc. de quelque nature que ce soit, liés directement ou indirectement à l’utilisation des Services à des fins illicites ou en contravention de l’une quelconque des obligations incombant au Client au titre des présentes CGS et des CP. Le Client s’engage en toutes circonstances à relever Made-in-World, les autres sociétés du groupe DADA et leurs sous-traitants, indemnes à cet égard.

            Le Client accepte sans restrictions ni réserves que si la responsabilité d’Made-in-World devait être engagée directement ou indirectement notamment en sa qualité d’intermédiaire technique et/ou de bureau d’enregistrement de Noms de Domaine, par quelque tiers que ce soit, Made-in-World se réserve le droit de prendre toute mesure administrative et/ou technique permettant de sauvegarder ses intérêts et/ou de se conformer aux obligations qui lui incombent.

            Le Client s’’engage également à informer Made-in-World dans les meilleurs délais par lettre recommandée avec accusé de réception, de toute demande, réclamation, plainte, action judiciaire, directement ou indirectement liée à son utilisation et/son exploitation des Services.</p>

            <p><b>9.4 Sauvegarde des Données Client</b></p>

            <p>Le Client est informé qu’Made-in-World n’effectue aucune sauvegarde des Données Client, ni n’intervient dans la manipulation desdits Données Client. Le Client est donc tenu de prendre toutes les mesures nécessaires à la sauvegarde des Données Client sur des supports extérieurs non hébergés ou gérés par Made-in-World, ainsi qu’à la gestion de ses Contenus.

            Made-in-World décline toute responsabilité quant aux conséquences du non-respect de cette obligation par le Client ou par toute autre personne.</p>

            <p><b>10 Communications entre les Parties – correspondance – preuve</b></p>

            <p>Sauf disposition particulière des présentes CGS et des CP ou indications contraires d’Made-in-World, les correspondances échangées entre les Parties sont assurées essentiellement par voie électronique, via l’Espace Client et en suivant les modalités fournies par Made-in-World et par téléphone.

            En application des dispositions des articles 1365 et suivants du Code civil et, le cas échéant, de l’article L.110-3 du Code de commerce, les Parties déclarent que les informations délivrées via l’Espace Client et le site Internet d’Made-in-World font foi entre les Parties. Les éléments tels que le moment de la réception ou de l’émission, ainsi que la qualité des données reçues feront foi par priorité telles que figurant sur les systèmes d’information d’Made-in-World et/ou de ses propres fournisseurs, ou telles qu’authentifiées par les procédures informatisées d’Made-in-World, sauf à en apporter la preuve écrite et contraire par le Client.

            La portée de la preuve des informations délivrées par les systèmes informatiques d’Made-in-World et/ou de ses propres fournisseurs est celle qui est accordée à un original au sens d’un document écrit papier, signé de manière manuscrite.
             
            Le Client reconnaît et accepte que les enregistrements informatiques ou électroniques effectués par Made-in-World et/ou par ses fournisseurs pour la délivrance des Services, de toutes opérations accomplies notamment par l’intermédiaire de son Espace Client, puissent être opposés ou utilisés devant toute autorité compétente (Police, Justice, etc.) en tant que preuve.</p>

            <p><b>11 Droits de propriété intellectuelle et/ou industrielle</b></p>

            <p>Les Logiciels qui peuvent être mis à la disposition du Client dans le cadre du Service demeurent la propriété entière d’Made-in-World et/ou des entités du groupe DADA et/ou de leur Editeur de Logiciels respectif, notamment concernant les droits de propriété intellectuelle y associés. En conséquence, les licences accordées dans le cadre du Service ne constituent en aucun cas une cession des droits de propriété intellectuelle des Logiciels mis à la disposition du Client.

            Par les présentes, Made-in-World concède au Client, pour la durée du Service, une licence d’utilisation, non-exclusive, non-transférable et strictement personnelle, portant sur les Logiciels mis à sa disposition dans le cadre du Service souscrit par le Client. L’usage des Logiciels est limité exclusivement à l’utilisation du Service souscrit. Sauf disposition contraire, Made-in-World et/ou l’Editeur de Logiciels sont réputés conserver le droit de modification et de correction des Logiciels.

            Dans le cas où le Service comporte des Logiciels d’Editeurs de Logiciels, les termes des licences de ces derniers s’appliqueront cumulativement avec les présentes CGS. A cet égard Made-in-World ne peut, en aucun cas, concéder au Client plus de droits que l’Editeur de Logiciels.

            Les Logiciels fournis dans le cadre du Service sont livrés « tels quels » et sans garantie d’aucune sorte de la part d’Made-in-World, notamment quant à l’adéquation des fonctionnalités desdits Logiciels aux besoins et exigences du Client, la non-interruption ou l’absence d’erreur, la correction de défauts, de bogues, etc. Il est convenu que la garantie prévue aux articles 1641 et suivants du Code Civil ne s’applique pas aux Logiciels.

            Compte tenu des évolutions techniques et économiques propres aux activités d’Editeur de Logiciels, le Client reconnaît et accepte sans restrictions ni réserves qu’Made-in-World :

            - n’est pas responsable de la fin de vie, du support ou de la politique d’évolution du Logiciel de l’Editeur de Logiciels concerné ;

            - se réserve le droit de remplacer un Logiciel par un autre équivalent sur le plan fonctionnel dans le cadre du Service ;

            - se réserve le droit de mettre à jour un Logiciel vers une nouvelle version.

            Aucune de ces circonstances ne sauraient constituer une cause de résiliation du Contrat et/ou des CP concernées, ni ne pourront donner lieu à aucun remboursement, avoir ou indemnisation en faveur du Client.

            Dans le cas particulier où le Logiciel ne serait plus édité par l’Editeur de Logiciels concerné pour quelque raison que ce soit (cessation d’activité, ouverture d’une procédure collective, incident technique, etc.) et ne pourrait être remplacé, Made-in-World en informera alors le Client dans les meilleurs délais.

            Le Client s’interdit toute utilisation des Logiciels en dehors du Service tel que défini dans le Bon de Commande, le site Internet d’Made-in-World et les CP correspondantes. Sauf disposition spécifique prévue dans des CP correspondantes, le Client s’interdit de copier, reproduire, représenter, adapter, modifier, décompiler de quelque manière que ce soit les Logiciels et/ou, le cas échéant, leur documentation.

            Le détail des licences mises à disposition du Client dans le cadre des Services souscrits est disponible dans le Bon de Commande et/ou sur le site Internet d’Made-in-World accessible à l’adresse URL suivante https://www.Made-in-World.fr et/ou dans les CP correspondantes. Le Client reconnaît s’être parfaitement renseigné sur les spécificités des licences et plus généralement de tous les composants du Service et des Logiciels, sur les modalités de la mise en œuvre des Services.

            Le Client reconnaît en outre s’être renseigné auprès d’Made-in-World afin de déterminer ses besoins avec précision, connaître les difficultés pouvant surgir de l’utilisation de ces licences dans le cadre du Service souscrit.

            Le Client s’engage à utiliser les licences dans la stricte limite du Service tel que défini dans le Bon de Commande et dans les CP correspondantes ; en conséquence, toute utilisation abusive, inadéquate ou tout choix non-conforme aux besoins du Client relève de son entière responsabilité.

            Made-in-World se réserve le droit de suspendre et/ou d’arrêter la licence et/ou ou l’accès au Service, jusqu’à la mise en conformité de l’utilisation du Service par du Client ou, le cas échéant, de résilier le Service concerné, sans que le Client ne puisse prétendre à aucun remboursement ou indemnisation d’un quelconque préjudice subi par lui ou par tout tiers.

            A l’issue du Contrat intervenue pour quelque raison que ce soit, le Client s’engage, sans délai, à effacer et détruire tous les Logiciels de tous ses systèmes informatiques, supports de stockage et autres dossiers ainsi que tous les documents y afférents.</p>

            <p><b>12 Responsabilité d’Made-in-World</b></p>

            <p><b>12.1 Disponibilité des Services</b></p>

            <p>Made-in-World n’est pas en mesure de garantir au Client une disponibilité continue et permanente des Services et propose, pour certains d’entre eux et conformément à leurs CP, des niveaux de services (ou SLA) spécifiques. Made-in-World fait toutefois ses meilleurs efforts pour rendre ses Services disponibles en continu, sous réserve des périodes de maintenance.</p>

            <p><b>12.2 Contrôle des Services</b></p>

            <p>A des fins de contrôle et de maintien de la sécurité et afin d’éviter l’altération de la sécurité des Plateformes, des systèmes et des infrastructures, Made-in-World pourra procéder à des opérations de surveillance ciblées et ponctuelles relatives à l’utilisation des Services et, le cas échéant, interrompre l’accès aux Services.</p>

            <p><b>12.3 Rétablissement et continuité des Services</b></p>

            <p>En cas d’inaccessibilité du/des Services due à des dysfonctionnements techniques du ressort d’Made-in-World, Made-in-World fera ses meilleurs efforts afin de résoudre ce(s) dysfonctionnement(s) dans les meilleurs délais à compter de la notification écrite adressée, par le biais exclusif de l’Espace Client, à Made-in-World sous les réserves cumulatives suivantes que i) le Client décrive précisément les dysfonctionnements constatés ii) lesdits dysfonctionnements puissent être reproductibles iii) le Client collabore pleinement avec Made-in-World iv) lesdits dysfonctionnements ne trouvent pas pour origine une mauvaise utilisation du/des Service(s) et/ou des Données Client et/ou du Site Internet par le Client.

            Made-in-World décline toute responsabilité en cas d’interruption et/ou de dysfonctionnements du/des Service(s) dus soit : (i) à la violation ou au non-respect du Client de l’une quelconque de ses obligations aux titres des CGS et des CP ou des indications fournies par Made-in-World, (ii) au mauvais fonctionnement ou à l’utilisation inappropriée des moyens d’accès au Service utilisés par le Client et/ou de l’utilisation inappropriée du Service par le Client (iii) aux évènements de force majeure, (iv) aux évènements dépendants de faits de tiers tels que, à titre d’exemple, l’interruption ou le mauvais fonctionnement des services des opérateurs de télécommunication et/ou des lignes électriques ou bien des actes d’omission ou d’erreur de l’Autorité compétente (v) au mauvais fonctionnement des terminaux ou des autres systèmes de communication utilisés par le Client (vi) au fait du Client.

            Made-in-World fait ses meilleurs efforts pour assurer la continuité des Services, cependant, compte tenu de la complexité et des circonstances spécifiques à son activité d’intermédiaire technique et plus précisément d’hébergeur au sens de la Loi du 21 Juin 2004 dite Loi pour la Confiance dans l’Economie Numérique (« LCEN »), Made-in-World ne peut être tenue qu’à une obligation de moyens au titre des présentes CGS et des CP. En conséquence, Made-in-World ne saurait être tenue responsable des retards ou problèmes dans l’acheminent des courriers électroniques et données informatiques, de la perte de données, des difficultés ou impossibilités d’accès, de la lenteur de la connexion, ou tout autre problème technique dus à des circonstances et/ou à des intermédiaires techniques extérieurs à Made-in-World. De plus, le Client s’engage à procéder à toute opération sollicitée par Made-in-World dans les délais requis, y compris la réinstallation et/ou la reconfiguration de son Service. Le Client en sera préalablement informé dans son Espace Client ou par courrier électronique. Il disposera en outre d’informations générales sur le site Internet d’Made-in-World et/ou dans son Espace Client. Il est entendu qu’Made-in-World ne se charge d’aucune de ces opérations de (re)configuration pour le compte du Client, ni ne prend à sa charge aucun des frais afférents à ces opérations.</p>

            <p><b>12.4 Limitation de responsabilité</b></p>

            <p>Made-in-World ne saurait être tenue pour responsable de l’indemnisation des dommages directs et indirects subis par le Client du fait directement ou indirectement de l’exécution ou la mauvaise exécution des Services, tels que, à titre indicatif et de manière non exhaustive, la perte de chiffre d’affaires, de clientèle, de bénéfices, de Données informatiques, le préjudice moral, etc.

            A TITRE DE CONDITION ESSENTIELLE ET DETERMINANTE DES PRESENTES CGS, SI LE CLIENT SOUSCRIT AU SERVICE DANS LE CADRE DE SES ACTIVITES PROFESSIONNELLES, SI LA RESPONSABILITE D’Made-in-World ETAIT RETENUE, LE CLIENT NE POURRAIT PRETENDRE, A D’AUTRES INDEMNITES ET DOMMAGES ET INTERETS OU REGLEMENT QUELCONQUE, TOUTES CAUSES CONFONDUES, QU’AU MONTANT DE 5.000 EUROS PAR SINISTRE TOUT PREJUDICE CONFONDU.

            Il est convenu que les dispositions du présent article 12 engagent tant Made-in-World que toute société qui viendrait à la contrôler au sens des dispositions des articles L.233-1 et suivants du Code du Commerce ainsi que toutes société à laquelle elle aurait transféré tout ou partie des droits et/ou des obligations du Contrat.</p>

            <p><b>13 Appareils</b></p>

            <p>Sous réserves des Conditions Particulières applicables à certains Services, le Client reconnaît et accepte que :

            (a) Made-in-World ne fournit, ne distribue, ne loue ni ne vend aucun appareil et/ou équipement au Client.

            (b) A aucun moment, il ne pourra accéder aux Serveurs, Plateforme et autres infrastructures utilisé(s) par Made-in-World pour la fourniture des Services, lesquels demeurent la propriété exclusive d’Made-in-World et/ou des autres sociétés du groupe DADA.</p>

            <p><b>14 Interruption - Suspension - Résiliation - Terme</b></p>

            <p><b>14.1 Interruption des Services pour maintenance</b></p>

            <p>Made-in-World se réserve le droit d’interrompre le Service pour des travaux de maintenance et/ou d’amélioration du Service. Ces interruptions de Service seront, dans la mesure des possibilités d’Made-in-World, préalablement notifiées au Client.

            En cas d’urgence, Made-in-World se réserve néanmoins le droit de suspendre partiellement ou totalement, pendant une durée raisonnable, le Service pour conduire toute opération technique requise. Ces interruptions de Service ne pourront donner lieu à une quelconque indemnisation en faveur du Client et ne seront pas imputées dans les « heures d’interruption » du Service des éventuels contrats de niveaux de service.</p>

            <p><b>14.2 Suspension des Services pour non-respect des présentes CGS</b></p>

            <p>En cas de non-respect manifeste par le Client de l’une quelconque de ses obligations prévues au Contrat (comme en particulier une utilisation manifestement illégale et/ou illicite et/ou en violation des droits d’un tiers), le cas échéant sur notification d’un tiers au sens des dispositions de l’article 6 de la LCEN, Made-in-World se réserve le droit de suspendre, à titre conservatoire, sans délais, les Services concernés ou l’accès à l’Espace Client et ce, jusqu’au parfait respect par le Client de ses obligations.

            Made-in-World fera son possible, sans s’y obliger, pour adresser au Client un préavis avant suspension et dont la durée sera évaluée en fonction des circonstances.

            Ainsi, en cas de défaut de paiement par le Client, y compris pour annulation ou répudiation du paiement (le cas échant par une banque et/ou le titulaire de la carte de crédit/bancaire utilisée), par le Client du renouvellement d’un Service déjà en cours, Made-in-World avertit le Client de cet évènement, lui donnant injonction de régulariser, dans un délai raisonnable, le paiement et se réserve le droit de suspendre le Service en cours jusqu’au complet paiement du prix. A l’issue dudit délai, et en l’absence de régularisation, Made-in-World informera le Client de l’absence de renouvellement du Service. Made-in-World ne saurait être tenue responsable des conséquences liées au non-renouvellement du Contrat.

            Par ailleurs, la déclaration par le Client d’informations inexactes et/ou douteuses et/ou fantaisistes, l’absence par le Client de mise à jour des informations fournies à Made-in-World conformément à ses obligations au titre des présentes CGS, en particulier les Données d’Identification ou l’absence de réponse par le Client aux demandes d’Made-in-World, notamment relatives à l’exactitude des Données d’Identification, entraîneront la suspension de plein droit des Services.

            De la même façon, le Client est informé que dans le cadre de l’exécution des Services, Made-in-World pourra être Made-in-Worldée à demander au Client de lui transmettre une copie de pièce d’identité correspondant à ses Données d’Identification, comme en particulier dans l’hypothèse d’une perte des Eléments d’Identification. Tout défaut du Client à produire un tel document dans les délais requis entraînera la suspension.

            La suspension des Services pour les raisons évoquées ci-dessus et/ou l’annulation et/ou le transfert des Services du fait du Client ne permettent pas au Client de prétendre à un remboursement, avoir ou une quelconque indemnisation, sauf dispositions particulières prévues à l’article 4 des présentes CGS.</p>
             
            <p><b>14.3 Suspension pour trouble aux Services</b></p>

            <p>Le Client s’engage à ce que l’utilisation des Services n’affecte ni ne compromette la stabilité, la sécurité et la qualité des Services, de la Plateforme, des Serveurs, de la Bande Passante, du Trafic et de façon générale des infrastructures d’Made-in-World, et/ou des autres Clients d’Made-in-World et/ou des tiers. Dans le cas contraire, Made-in-World se réserve le droit de suspendre la fourniture du Service au Client, y compris sans notification préalable.

            Made-in-World prendra attache avec le Client afin de lui recommander les mesures à prendre afin de mettre fin au trouble à l’origine de la suspension. Sans respect par le Client de ses recommandations et après un préavis raisonnable, Made-in-World se réserve le droit de mettre un terme au Contrat dans les conditions de l’article 14.5 ci-après.</p>

            <p><b>14.4 Suspension sur demande d’une Autorité et/ou d’une autorité administrative ou judiciaire</b></p>

            <p>Dans l’hypothèse où Made-in-World devait être rendue destinataire d’une réquisition, ordonnance sur requête ou d’une décision émanant d’une Autorité et/ou d’une autorité administrative ou judiciaire compétente lui enjoignant de suspendre les Services souscrits et utilisés par le Client, Made-in-World se réserve le droit de suspendre, sans préavis et jusqu’à instruction contraire de l’autorité dont émane la demande, les Services concernés ou l’accès à l’Espace Client.</p>

            <p><b>14.5 Résiliation</b></p>

            <p>Sauf disposition particulière, en cas de manquement par l’une des Parties à l’une quelconque de ses obligations issues du présent Contrat et à défaut pour cette Partie d’y remédier, l’autre Partie pourra résilier de plein droit le présent Contrat, par lettre recommandée avec demande d’avis de réception, quinze (15) jours après une mise en demeure restée infructueuse. Dans cette hypothèse, le Contrat sera résilié, sans préjudice de tous dommages et intérêts qui pourraient être réclamés à la Partie défaillante et sans que le Client ne puisse prétendre à aucun remboursement ou indemnisation du préjudice subi par lui ou tout tiers.

            Dans l’hypothèse d’une suspension des Services réalisée par Made-in-World dans les conditions des articles 14.1, 14.2, 14.3 et 14.4 ci-dessus et en l’absence de réponse du Client et/ou de régularisation du fait générateur de la suspension et/ou de suivi des recommandations d’Made-in-World et, en tout état de cause après un préavis raisonnable, Made-in-World pourra résilier le Contrat et l’ensemble des Services souscrits par le Client.

            En cas d’utilisation du Service en contravention avec les termes des articles 7, 8, 9 et 11 des présentes CGS, le Client sera réputé en inexécution grave de ses obligations contractuelles autorisant Made-in-World, à sa convenance, à : i) suspendre le(s) Service(s) et/ou l’accès à l’Espace Client jusqu’au parfait respect par le Client de ses obligations et/ou ii) mettre en demeure le Client de respecter ses obligations et/ou iii) résilier de plein droit le présent Contrat, et ce sans préjudice de tous dommages et intérêts pour dommages directs et/ou indirects auxquels Made-in-World pourrait prétendre.

            Made-in-World se réserve en outre le droit de poursuivre le Client de manière judiciaire ou extrajudiciaire afin d’être indemnisée du préjudice direct et indirect subi par Made-in-World du fait du Client.</p>

            <p><b>14.6 Conséquences de la résiliation</b></p>

            <p>Conformément aux dispositions de l’article 9.4 des présentes CGS, le Client est informé qu’Made-in-World ne procède à aucune sauvegarde des Données Client, si bien qu’en l’absence de sauvegarde personnelle par le Client, la suppression des Données Client liée à la résiliation est définitive.</p>

            <p><b>14.7 Terme</b></p>

            <p>En cas de résiliation pour quelle que cause que ce soit ou d’arrivée à son terme du présent Contrat, le Client devra faire son affaire, avant l’échéance qui lui est impartie (soit au plus tard soixante-douze (72) heures avant la date d’expiration des Services) de la récupération de l’intégralité des Données Client et plus généralement de toutes données lui appartenant et/ou présentes sur les Serveurs d’Made-in-World alloués aux Services. A défaut de quoi, ces éléments seront définitivement supprimés par Made-in-World sans restauration possible.</p>

            <p><b>15 Force majeure</b></p>

            <p>Tout événement échappant au contrôle de l’une ou l’autre Partie, qui ne pouvait être raisonnablement prévu lors de la conclusion du Contrat et dont les effets ne peuvent être évités par des mesures appropriées constitue un cas de force majeure, tel que définie par l’article 1218 du Code civil et la jurisprudence des tribunaux français, et suspend à ce titre l’exécution des obligations des Parties.

            Dans le cas où la suspension du Contrat se poursuivrait au-delà d’un délai d’un (1) mois, chacune des Parties se réserve la possibilité de résilier immédiatement et de plein droit, sans indemnité, les présentes CGS sans préavis après l’envoi d’une lettre recommandée avec accusé de réception notifiant cette décision.</p>

            <p><b>16 Données Personnelles</b></p>

            <p><b>16.1 Traitement des Données Personnelles</b></p>

            <p>Made-in-World s’engage à respecter la vie privée de ses Clients et la Règlementation sur les Données Personnelles.

            La collecte et le traitement par Made-in-World des Données Personnelles de ses Clients sont établis conformément à sa Politique de Confidentialité accessible en cliquant ici : https://www.Made-in-World.fr/company/privacy.html.

            Certaines de ces Données Personnelles (telles que notamment les nom, adresse postale, adresse de courrier électronique, numéro de téléphone et de télécopie, Nom de Domaine, DNS et adresses IP des serveurs de Noms de Domaine) seront rendues publiques par Made-in-World et les autres sociétés du groupe DADA suivant les règles imposées par les Autorités dont en particulier l’ICANN et les NIC, afin d’être incluses dans la Base Whois et l’Extrait Whois du Nom de Domaine du Client.

            Made-in-World n’utilise pas et ne divulgue aucune Donnée personnelle sans le consentement explicite du Client. Made-in-World divulguera uniquement les Données Personnelles des Clients sans préavis, si elle y est obligée par la loi ou si elle est convaincue, en toute bonne foi, qu’une telle action est nécessaire dans les conditions prévues par la Politique de Confidentialité.

            Le Client accepte le traitement des Données Personnelles le concernant dans le cadre du présent Contrat. Le Client déclare qu’il a préalablement notifié et obtenu l’autorisation des personnes physiques dont il a fourni les noms et coordonnées dans le cadre du présent Contrat, notamment pour l’enregistrement, le transfert et la gestion du Nom de Domaine.

            Le Client accepte que les Données Personnelles le concernant soient transférées, par Made-in-World, pour les besoins d’exécution du Service aux fournisseurs d’Made-in-World, à la centrale d’appel chargée par Made-in-World de recueillir les appels téléphoniques des Clients, à tout prestataire sous-traitant, notamment tout prestataire informatique intervenant dans le cadre du fonctionnement, de l’exploitation et de la maintenance des Services et, plus généralement à toute société du groupe DADA.

            Dans l’hypothèse où le Client a fait le choix du renouvellement automatique du Contrat suivant les dispositions prévues à l’article 4.3 ci-dessus, il est informé que ses coordonnées bancaires seront conservées par le prestataire de paiement de la société Made-in-World. Pour ce faire, le Client, lors du choix du renouvellement automatique lors de la souscription au(x) Service(s), est invité, sur le site Internet d’Made-in-World, à donner son autorisation expresse pour la collecte et la conservation de ses coordonnées bancaires par le prestataire de paiement de la société Made-in-World.

            Il est indiqué au Client, qui l’accepte, que tant la société Made-in-World que le prestataire bancaire de cette dernière prend toute précaution utile aux fins d’assurer la sauvegarde et la sécurité de ses données bancaires en garantissant un service de protection répondant a minima à celui imposé par la Règlementation sur les Données Personnelles. Le Client est notamment averti que ses données bancaires seront conservées dans l’Union Européenne.

            La conservation des données bancaires du Client est assurée pendant toute la durée du Contrat, puis archivées conformément aux obligations légales en la matière.</p>

            <p><b>16.2 Modalités d’exercice des droits d’accès des Clients à leurs Données Personnelles</b></p>

            <p>Conformément aux dispositions de la Règlementation sur les Données Personnelles, le Client a la faculté, à tout moment, de :

            - s’opposer et/ou supprimer et/ou limiter à tout ou partie du traitement de ses Données Personnelles pour des motifs légitimes ;
            - accéder à l’ensemble de ses Données Personnelles traitées dans le cadre de son utilisation des Services, y compris à des fins de portabilité à condition de le préciser ;
            - rectifier, compléter, actualiser, verrouiller ou effacer des Données Personnelles qu’il a communiquées lorsqu’ont été décelées des erreurs, des inexactitudes ou la présence de données dont la collecte, l’utilisation, la communication est interdite.

            En outre, le Client a la possibilité de définir auprès d’Made-in-World des directives relatives à la conservation, à l’effacement
            et à la communication des Données Personnelles après son décès, lesquelles directives peuvent être enregistrées également auprès
            « d’un tiers de confiance numérique certifié ». Ces directives, ou sorte de « testMade-in-Worldt numérique », peuvent désigner une personne chargée de leur exécution ; à défaut, les héritiers du Client seront désignés.

            En l’absence de toute directive, les héritiers peuvent s’adresser à Made-in-World afin de :

            - accéder aux traitements de Données Personnelles permettant « l’organisation et le règlement de la succession du défunt »;
            - recevoir communication des « biens numériques » ou des « données s’apparentant à des souvenirs de famille, transmissibles aux héritiers » ;
            - faire procéder à la clôture de son compte et s’opposer à la poursuite du traitement de ses Données Personnelles.

            En tout état de cause, le Client a la possibilité d’indiquer, à tout moment, à Mad</p>e-in-World qu’il ne souhaite pas,
            en cas de décès, que ses Données personnelles soient communiquées à un tiers.

            Pour mettre en œuvre son droit d’accès, de modification, de rectification et d’opposition des Données Personnelles le concernant,
            le Client adressera pour ce faire un courrier électronique à l’adresse suivante : cnil@Made-in-World.fr.</p>
             
            <p><b>17 Confidentialité</b></p>

            <p>Les Parties s’engagent à ne pas divulguer, pendant la durée du présent Contrat sous quelque forme que ce soit, toutes les informations
              relatives à l’autre Partie ou à ses activités, échangées ou portées à sa connaissance lors de la conclusion, de l’exécution ou de la résiliation
              du présent Contrat, qu’elles soient orales ou écrites, à l’état d’ébauche ou finalisées, sous forme lisible par l’homme ou la machine,
              qu’elles concernent des aspects techniques, commerciaux, financiers, administratifs ou autres.

            Les Parties prendront toutes les dispositions nécessaires afin de conserver auxdites informations leur caractère strictement confidentiel, afin d’en limiter la diffusion.

            Lesdites informations pourront, néanmoins, être transmises aux sociétés du groupe DADA et/ou à des tiers ayant une mission de conseil auprès
            d’Made-in-World ou auprès desquels Made-in-World sous-traite certaines prestations d’ordre technique et/ou administratif (comptables, expert-comptable,
             avocats, cabinet d’audit, etc.), lesquels sont liés avec Made-in-World par des clauses contractuelles de confidentialité et/ou soumis au secret professionnel
             permettant de garantir la sécurité et la confidentialité desdites informations.</p>

            <p><b>18 Divers</b></p>

            <p><b>18.1 Non validité partielle</b></p>

            <p>Si une ou plusieurs dispositions des présentes CGS et/ou des CP devaient être tenues pour non valides ou déclarées comme telles en application d’une loi,
              d’un règlement ou à la suite d’une décision devenue définitive d’une juridiction compétente, les autres stipulations garderont toute leur force et leur portée.</p>

            <p><b>18.2 Non renonciation</b></p>

            <p>Le fait que l’une ou l’autre des Parties n’ait pas exigé, temporairement ou définitivement, l’application d’une disposition des présentes
              CGS et des CP ne pourra être considéré comme une renonciation aux droits détenus par cette Partie. Tout échange de correspondances, d’écrits,
              de courriers électroniques, etc. ne saurait remettre en cause les termes des présentes CGS et des CP, sauf avenant dûment signé par les Parties ou par leurs représentants.</p>

            <p><b>18.3 Sous-traitance</b></p>

            <p>Le Client autorise expressément Made-in-World à sous-traiter tout ou partie des Services objet des présentes.</p>

            <p><b>18.4 Incessibilité du Contrat</b></p>

            <p>Sauf accord préalable et écrit d’Made-in-World, le Client n’est pas autorisé à transférer tout ou partie des droits et obligations issues des présentes CGS et des CP,
               en particulier de faire bénéficier à des tiers de tout ou partie du Service, sauf dispositions contraires, en particulier à l’article 4 des présentes CGS.</p>

            <p><b>18.5 Référence commerciale</b></p>

            <p>Pendant toute la durée des Services, le Client autorise expressément Made-in-World à citer comme référence commerciale, le Client et/ou ses Noms de Domaine
              , y compris le Site Internet qui y est associé et les signes distinctifs qui y sont publiés, tels que la dénomination sociale, l’enseigne, le nom commercial,
              les marques, logos, etc. sur lesquels le Client déclare et garantit être titulaire ou licencié des droits d’exploitation sur tous supports.</p>

            <p><b>19 Assistance d’Made-in-World</b></p>

            <p>Pour l’ensemble des Services, le Client dispose gratuitement d’une assistance en ligne par courrier électronique depuis son Espace Client
              durant les jours et heures ouvrés d’Made-in-World, apportant une aide technique et/ou administrative concernant le Service en répondant dans les meilleurs
              délais aux questions et commentaires du Client via son Espace Client, sans engagement d’Made-in-World d’apporter une solution au Client, ni de délai de réponse.</p>

            <p><b>20 Loi applicable – Résolution des litiges – Attribution de compétence</b></p>

            <p><b>20.1 Loi applicable</b></p>

            <p>Les présentes CGS et tout litige en rapport avec les Services sont régis et interprétés au regard du droit français.</p>

            <p><b>20.2 Résolution des litiges</b></p>

            <p>Dans la mesure autorisée par la loi, avant d’entamer toute procédure judiciaire concernant un litige susceptible de survenir impliquant les présentes CGS,
              leur interprétation et leurs conséquences ou avec les actes les complétant ou les modifiant et/ou les Services, le Client devra en aviser Made-in-World afin de
              rechercher une résolution amiable. Toute réclamation auprès d’Made-in-World doit être formulée de manière écrite. Le Client et Made-in-World devront fournir tous les efforts nécessaires pour parvenir à une résolution amiable du litige.

            A défaut de règlement amiable, le Client Consommateur au sens du Code de la consommation, peut choisir :

            - de recourir à une solution de médiation amiable dans un délai maximal d’un (1) an à compter de sa réclamation écrite formulée par le Client
            auprès d’Made-in-World en saisissant, (i) soit un médiateur de son choix, (ii) soit en recourant au système de règlement en ligne des litiges accessible à l’adresse suivante :
            https://webgate.ec.europa.eu/odr/main/index.cfm?event=main.home.chooseLanguage, étant précisé que le processus de médiation proposé ne saurait être une conditions préalable à une saisine des tribunaux compétents pour le Client.

            - de porter sa réclamation devant les juridictions françaises compétentes selon les présentes CGS.</p>

            <p><b>20.3 Clause attributive de juridiction pour les Clients professionnels</b></p>

            <p>Il est fait attribution expresse et exclusive de compétence au Tribunal de Commerce de Paris, pour tout litige susceptible de survenir entre
              Made-in-World et un Client ayant souscrit à l’un des Services fournis par Made-in-World dans le cadre de ses activités professionnelles,
              en rapport avec les présentes CGS, leur interprétation et les conséquences ainsi que tout acte les complétant ou les modifiant, notamment les CP relatives
              aux différents Services, nonobstant pluralité de défendeurs, appels en garantie, référés et expertises.

            En vigueur au 06 février 2018</p>
          </p>
  				</div>
  			<div class="modal-footer">
  				<button type="button" class="btn btn-primary" data-dismiss="modal">J'accepte</button>
  			</div>
  		</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</div>

<div class="container">
  <div class="row">
      <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
          <h2>Déjà inscrit ? <small>sur Made in World</small></h2>
  	</div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-md-6"><a href="connexion.php" class="btn btn-success btn-block btn-lg" tabindex="8">Connexion</a></div>
  </div>
</div>

<?php
include("footer.php");
?>

<?php


// INIT.INC.PHP 

include("../inc/init.inc.php");


// POUR TEST


// FIN TEST


// DEBUT DU CODE PHP


// restriction d'accès au back office

/*if(!utilisateur_est_admin()) // si l'utilisateur n'est pas admin
{
	header("location:../connexion.php"); // header erdirige, mais le code ci-dessous peut être tout de même exécuté
	exit(); // si on passe dans cette condition (pas admin), exit() bloque l'éxécution du code ci-dessous
}
*/

// SUPPRESSION SALLE

if(isset($_GET['action']) && $_GET['action'] == 'suppression')
{
	// requete SQL pour suppr un produit suivant son id_produit :
	$salle_a_suppr = $_GET['id_salle'];
	
	$suppression = $pdo->prepare("DELETE FROM salle WHERE id_salle = :id_salle");
	$suppression->bindParam(':id_salle', $salle_a_suppr, PDO::PARAM_STR);
	$suppression->execute();

	$_GET['action'] = 'voir';
	/* ici, on change la valeur de 'action' dans l'url.
	Donc quand plus bas le if 'action' = 'voir' permettant d'afficher le tableau verra que l'indice 'action' dans le _GET sera 'voir', il affichera le tableau des salles */
}  

// FIN SUPPR SALLE


// déclaration des variables vides utilisées plus bas

$titre = "";
$description = "";
$photo = "";
$pays = "";
$ville = "";
$adresse = "";
$cp = "";
$capacite = "";
$categorie = "";

/* pour la modif uniquement : */
$id_salle ="";


// MODIFICATION SALLE

if(isset($_GET['action']) && $_GET['action'] == 'modification')
{
	$salle_a_modif = $_GET['id_salle'];
	
	$recup_info = $pdo->prepare("SELECT * FROM salle WHERE id_salle = :id_salle");
	$recup_info->bindParam(":id_salle", $salle_a_modif, PDO::PARAM_STR);
	$recup_info->execute();

	// pour que les champs du formulaire soient pré-remplis
	$salle_actuel = $recup_info->fetch(PDO::FETCH_ASSOC);

	
	$id_salle = $salle_actuel['id_salle'];
	$titre = $salle_actuel['titre'];
	$description = $salle_actuel['description'];
	$photo = $salle_actuel['photo'];
	$pays = $salle_actuel['pays'];
	$ville = $salle_actuel['ville'];
	$adresse = $salle_actuel['adresse'];
	$cp = $salle_actuel['cp'];
	$capacite = $salle_actuel['capacite'];
	$categorie = $salle_actuel['categorie'];
}

// FIN MODIFICATION SALLE


// Controles

if(isset($_POST['titre']) &&
	isset($_POST['description']) &&
	/*isset($_POST['photo']) &&*/
	isset($_POST['pays']) &&
	isset($_POST['ville']) &&
	isset($_POST['adresse']) &&
	isset($_POST['cp']) &&
	isset($_POST['capacite']) &&
	isset($_POST['categorie']) )
{
	$id_salle = $_POST['id_salle'];
	$titre = $_POST['titre'];
	$description = $_POST['description'];
	//$photo = $_POST['photo'];
	$pays = $_POST['pays'];
	$ville = $_POST['ville'];
	$adresse = $_POST['adresse'];
	$cp = $_POST['cp'];
	$capacite = $_POST['capacite'];
	$categorie = $_POST['categorie'];

	// vérification de la disponibilité du titre

	$erreur = false;

	$verif_titre = $pdo->prepare("SELECT * FROM salle WHERE titre = :titre");

	$verif_titre->bindParam(":titre", $titre, PDO::PARAM_STR);

	$verif_titre->execute();

	if($verif_titre->rowCount() > 0 && empty($id_salle))
	// on vérifie si il y a un titre (donc si oui : erreur car le titre doit être unique)
	// on vérifie aussi si le id_salle est vide (cad si ce n'est pas dans un cas de modification : voir plus haut)
	{
		$erreur = true;
		$message .= '<div class="alert alert-danger" style="">Attention,<br>Le titre existe dèjà !</div>';
	} 


	// Vérification si il n'y a pas eu d'erreurs dans les controles ci-dessus

	if(!$erreur)
	{
		// récupération de la photo

		$photo_bdd = ""; // on déclare cette variable vide avant le if qui suit. Ainsi, même si l'utilisateur ne rentre pas de photo, le reste du code ne sera pas affecté


		// $_FILES

		/* superglobale permettant de gérer les fichiers joints chargés via un formulaire */
		/* $_FILES est un tableau array multidimensionnel */

		if(!empty($_FILES['photo']['name']))
		{
			// mise en place du src :
			$photo_bdd = 'img/' . $titre . $_FILES['photo']['name'];
			// on utilise la variable 'reference' pour donner un nom unique à chaque lien

			// COPY()

			/* fonction prédéfinie permet de copier un fichier depuis un emplacement (1er argument) vers un emplacement cible (2ème argumument) */

			$chemin = RACINE_SERVEUR . $photo_bdd;
			// racine_serveur est déclaré dans init.inc.php

			copy($_FILES['photo']['tmp_name'], $chemin);
		}

		// enregistrement des produits dans la BDD :

		if(empty($id_salle))
		// si id_produit est vide, donc dans le cas où ce n'est pas une demande de modif)
		{
			$enregistrement = $pdo->prepare("INSERT INTO salle (titre, description, photo, pays, ville, adresse, cp, capacite, categorie) VALUES (:titre, :description, '$photo_bdd', :pays, :ville, :adresse, :cp, :capacite, :categorie)");
		} else { // si c'est une demande de modif
			$enregistrement = $pdo->prepare("UPDATE salle SET titre = :titre, description = :description, photo = '$photo_bdd', pays = :pays, ville = :ville, adresse = :adresse, cp = :cp, capacite = :capacite, categorie = :categorie WHERE id_salle = :id_salle");
			$enregistrement->bindParam(":id_salle", $id_salle, PDO::PARAM_STR);
		}

		$enregistrement->bindParam(":titre", $titre, PDO::PARAM_STR);
		$enregistrement->bindParam(":description", $description, PDO::PARAM_STR);
		$enregistrement->bindParam(":pays", $pays, PDO::PARAM_STR);
		$enregistrement->bindParam(":ville", $ville, PDO::PARAM_STR);
		$enregistrement->bindParam(":adresse", $adresse, PDO::PARAM_STR);
		$enregistrement->bindParam(":cp", $cp, PDO::PARAM_STR);
		$enregistrement->bindParam(":capacite", $capacite, PDO::PARAM_STR);
		$enregistrement->bindParam(":categorie", $categorie, PDO::PARAM_STR);
		
		
		$enregistrement->execute();
	}
}


// FIN DU CODE PHP


// INSERTION DES INCLUDES AVANT LE BODY

/*include("inc/header.inc.php");

include("inc/nav.inc.php");*/

?>
 <!-- DEBUT HTML -->
<div class="container">

     	<div class="starter-template">
        	<h1><span class="glyphicon glyphicon-cog"></span><br>GESTION DES SALLES</h1>

<!--         	<?php echo $message; ?>
 -->
    	</div>


    	<!-- BOUTONS -->

    	<div class="row">
      			<div class="col-sm-12 text-center ">
      				<a href="?action=ajouter" class="btn btn-warning">Ajouter une salle</a>
      				<a href="?action=voir" class="btn btn-primary">Voir les salles</a>
      			</div>
      	
      		<!-- FORMULAIRE AJOUT ET MODIFICATION PRODUIT -->

      		<<?php 
      		if(isset($_GET['action']) && ($_GET['action'] == 'ajouter'|| $_GET['action'] == 'modification')) 
      		{ ?>

      		<div class="col-sm-4 col-sm-offset-4">
				<form method="post" action="" enctype="multipart/form-data">
				<!-- enctype "multipart/form-data" est obligatoire pour les formulaires permettant de joindre un fichier -->


				<!-- CHAMPS CACHE (type hidden) pour avoir l'id_produit lors d'une modification : -->
					<input type="hidden" name="id_salle" value="<?php echo $id_salle; ?>">

				<!-- FORMULAIRE D'AJOUT de produit -->
					<div class="form-group">				
						<label for="titre">Titre</label>
						<input type="text" class="form-control" id="titre" name="titre" placeholder="Titre..." value="<?php echo $titre; ?>" >
						<!-- rajout de php dans 'value' pour que la sélection reste dans le champs -->
					</div>

					<div class="form-group">				
						<label for="description">Description</label>
						<input type="text" class="form-control" id="description" name="description" placeholder="Description..." value="<?php echo $description; ?>" >
						<!-- rajout de php dans 'value' pour que la sélection reste dans le champs -->
					</div>

					<div class="form-group">				
						<label for="photo">Photo</label>
						<input type="file" class="form-control" id="photo" name="photo" >
					</div>

					<div class="form-group">				
						<label for="pays">Pays</label>
						<input type="text" class="form-control" id="pays" name="pays" placeholder="Pays..." value="<?php echo $pays; ?>" >
						<!-- rajout de php dans 'value' pour que la sélection reste dans le champs -->
					</div>

					<div class="form-group">				
						<label for="ville">Ville</label>
						<input type="text" class="form-control" id="ville" name="ville" placeholder="Ville..." value="<?php echo $ville; ?>" >
						<!-- rajout de php dans 'value' pour que la sélection reste dans le champs -->
					</div>

					<div class="form-group">				
						<label for="adresse">Adresse</label>
						<input type="text" class="form-control" id="adresse" name="adresse" placeholder="Adresse..." value="<?php echo $adresse; ?>" >
					</div>

					<div class="form-group">				
						<label for="cp">Code Postal</label>
						<input type="text" class="form-control" id="cp" name="cp" placeholder="Code Postal..." value="<?php echo $cp; ?>" >
					</div>		

					<div class="form-group">				
						<label for="capacite">Capacité</label>
						<input type="text" class="form-control" id="capacite" name="capacite" placeholder="Capacité..." value="<?php echo $capacite; ?>" >
					</div>

					<div class="form-group">				
						<label for="categorie">Catégorie</label>
						<select class="form-control" name="categorie" id="categorie">
							<option value="réunion" >Réunion</option>
							<option <?php if($categorie == "bureau") { echo "selected"; } ?> value="bureau" >Bureau</option>
							<option <?php if($categorie == "formation") { echo "selected"; } ?> value="formation" >Formation</option>
						</select>
					</div>

					<hr>
					<button type="submit" class="btn btn-info col-sm-12"><span class="glyphicon glyphicon-ok" name="ajouter"></span> Ajouter</button>

				</form>
			</div>

      		<!-- <?php } ?> -->
      		<!-- / FIN FORMULAIRE AJOUT PRODUIT -->


			<!-- FORMULAIRE VOIR PRODUIT -->

      		<?php 
      		if(isset($_GET['action']) && $_GET['action'] == 'voir')
      		{ 
      			$les_salles = $pdo->query("SELECT * FROM salle");
      			// on SELECT tous les produits de la table et on les enregistre dans la variable

      			echo '<div class="col-sm-12">';
      			echo '<table class="table table-bordered">';

      			echo '<tr>';
      			echo '<th>id_salle</th>';
      			echo '<th>Titre</th>';
      			echo '<th>Description</th>';
      			echo '<th>Photo</th>';
      			echo '<th>Pays</th>';
      			echo '<th>Ville</th>';
      			echo '<th>Adresse</th>';
      			echo '<th>Code Postal</th>';
      			echo '<th>Capacité</th>';
      			echo '<th>Catégorie</th>';
   				// rajout des boutons
      			echo '<th>Modif</th>';
      			echo '<th>Suppr</th>';
      			echo '</tr>';

      			while($salle = $les_salles->fetch(PDO::FETCH_ASSOC))
      			{
      				echo '<tr>';

      				echo '<td>' . $salle['id_salle'] . '</td>';
      				echo '<td>' . $salle['titre'] . '</td>';
					echo '<td>' . substr($salle['description'], 0, 14) . '...' . '</td>';
      				// pour faire un apreçut de la description      				
      				echo '<td><img src="' . URL_back . $salle['photo'] . '"alt="image_salle" class="img-responsive" width="100"></td>';
      				echo '<td>' . $salle['pays'];
      				echo '<td>' . $salle['ville'] . '</td>';
      				echo '<td>' . $salle['adresse'] . '</td>';
      				echo '<td>' . $salle['cp'] . '</td>';      				
      				echo '<td>' . $salle['capacite'] . '</td>';
      				echo '<td>' . $salle['categorie'] . '</td>';
      				// rajout des boutons
      				echo '<td><a href="?action=modification&id_produit=' . $salle['id_produit'] . '" class="btn btn-warning"><span class="glyphicon glyphicon-refresh"></span></a></td>';
      				echo '<td><a href="?action=suppression&id_produit=' . $salle['id_produit'] . '" class="btn btn-danger" onclick="return(confirm(\'Etes-vous sûr ?\'));"><span class="glyphicon glyphicon-trash"></span></a></td>';
      					// onclick="return()" permet d'afficher une fenetre pop-up de confirmation



      				echo '</tr>';

      			}

      			echo '</table>';
      			echo '</div>';
      			
      		 }

      		 ?>
      		<!-- / FIN FORMULAIRE VOIR PRODUIT -->

    	</div><!-- /.row -->

    	<a href="" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-up"></span> Retour Haut de Page <span class="glyphicon glyphicon-arrow-up"></span></a>

    </div><!-- /.container -->

 <!-- FIN HTML -->

<?php


// INSERTION DES INCLUDES APRES LE BODY

include("../inc/footer.inc.php");
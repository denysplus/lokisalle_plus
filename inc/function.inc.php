<?php

// fonction pour savoir si l'utilisateur est connecté
function utilisateur_est_connecte()
{
    if (!empty($_SESSION['membre']))
    {
        // si l'indice membre dans SESSION n'est pas vide alors forcément l'utilisateur est passé par la connexion et s'est connecté
        return true;
    }
    return false;
}

// fonction pour savoir si l'utilisateur est connecté et a le statut administrateur
function utilisateur_est_admin()
{
    if(utilisateur_est_connecte() && $_SESSION['membre']['statut'] == 1)
    {
        return true;
    }
    return false;
}


// DECLARATION DES VARIABLES
$pseudo ='';
$mdp = '';
$nom = '';
$prenom = '';
$email = '';
$civilite = '';


// LOG IN FORMULAIRE START //

if ( isset($_POST['pseudo']) &&
    isset($_POST['mdp']) &&
    isset($_POST['nom']) &&
    isset($_POST['prenom']) &&
    isset($_POST['email']) &&
    isset($_POST['civilite'])) {
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['mdp'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $civilite = $_POST['civilite'];


    //variable de contrôle initialisée par défaut sur false.
   $erreur = false;

    // contrôle sur la taille du pseudo
    if (iconv_strlen($pseudo) < 4 || iconv_strlen($pseudo) > 20)
    {
        $erreur = true; // un cas d'erreur
        $message .= '<div class="alert alert-danger col-sm-4 col-sm-offset-4">Attention,<br>Le pseudo doit contenir entre 4 et 20 caractères inclus!</div>';
    }

    //vérification du pseudo selon les caractères autorisés via une expression régulière.
    //preg_match() renvoi true si les caractères correspondent à l'expression régulière fournie en 1er argument sinon false.
    $verif_pseudo = preg_match('#^[a-zA-Z0-9._-]+$#', $pseudo);
    /*
        les # indiquent le début et la fin de l'expression.
        ^ indique le début de la chaine sinon la chaine pourrait commencer par autre chose
        $ indique la fin de la chaine sinon la chaine pourrait finir par autre chose/
        + indique que l'on peux avoir plusieurs fois les mêmes caractères.
     */

    if (!$verif_pseudo) // si $verif_pseudo == false (valeur implicite)
    {
        $erreur = true; // un cas d'erreur
        $message .= '<div class="alert alert-danger col-sm-4 col-sm-offset-4">Attention,<br>Caractères autorisés pour le pseudo : A - Z et 0 - 9</div>';
    }

    // vérification du format du mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $erreur = true; // un cas d'erreur
        $message .= '<div class="alert alert-danger col-sm-4 col-sm-offset-4">Attention,<br>Le format du mail est incorrect, veuillez vérifier votre saisie</div>';
    }

    // vérification de la disponibilité du pseudo
    // requête en BDD pour vérifier l'existence.
    $verif_dispo = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
    $verif_dispo->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
    $verif_dispo->execute();

    if ($verif_dispo->rowCount() > 0)
    {
        // s'il y a au moins une ligne alors le pseudo est déjà pris
        $erreur = false; // un cas d'erreur
        $message .= '<div class="alert alert-danger col-sm-4 col-sm-offset-4">Attention,<br>Pseudo indisponible</div>';
    }

    // vérification d'il y a eu au moins un cas d'erreur, sinon on enregistre en BDD
    if (!$erreur) // si $erreur == false
    {
        // crypter le mdp lors de l'enregistrement
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);

        // pour un enregistrement dans la BDD
        $enregistrement = $pdo->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, statut, date_enregistrement) VALUES(:pseudo, :mdp, :nom, :prenom, :email, :civilite, 0, NOW())");
        $enregistrement->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
        $enregistrement->bindParam(":mdp", $mdp, PDO::PARAM_STR);
        $enregistrement->bindParam(":nom", $nom, PDO::PARAM_STR);
        $enregistrement->bindParam(":prenom", $prenom, PDO::PARAM_STR);
        $enregistrement->bindParam(":email", $email, PDO::PARAM_STR);
        $enregistrement->bindParam(":civilite", $civilite, PDO::PARAM_STR);

        $enregistrement->execute();

        // message en cas de validation du formulaire et inscription dans la BDD
        $message .= '<div class="alert alert-success col-sm-4 col-sm-offset-4">Enregistrement terminé avec succès <br> <span class="glyphicon glyphicon-ok"></span> </div>';
    }
}

// LOG IN FORMULAIRE END //















?>

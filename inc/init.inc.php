<?php
//connexion à la BDD
$arg1 = "mysql:host=localhost;dbname=lokisalle";
$arg2 = 'root';
$arg3 = '';
$arg4 = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
);

$pdo = new PDO($arg1, $arg2, $arg3, $arg4);

// ouverture d'une session
session_start();

// déclaration d'une variable permettant d'afficher des messages utilisateurs
$message ='';

//appel du fichier contenant les fonctions de notre projet
include ("function.inc.php");

// déclaration d'une constante contenant la racine site (chemin absolu depuis la racine serveur).
define("URL", "http://localhost/php/lokisalle/");

define("URL_back", "http://localhost/php/lokisalle/back/");

// déclaration du chemin complet permettant de copier les photos formulaire ajouter au produit
define("RACINE_SERVEUR", $_SERVER['DOCUMENT_ROOT'] . '/php/lokisalle/');

?>
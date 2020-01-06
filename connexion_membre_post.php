<?php
session_start();
include "connexion.php";


// On récupère les infos du formulaire
$pseudo = $_POST['pseudo'];
$passwd = $_POST['password'];


//  Récupération de l'utilisateur et de son pass hashé
$reponse = $bdd->prepare('SELECT id, pass FROM membres WHERE pseudo = :pseudo');
$reponse -> execute(array(
    'pseudo' => $pseudo));
$resultat = $reponse->fetch();

// Comparaison du pass envoyé via le formulaire avec la base
$isPasswordCorrect = password_verify($passwd, $resultat['pass']);

if (!$resultat) {
    $_SESSION['errorMSG'] =  'Mauvais identifiant ou mot de passe !';
    header('Location: connexion_membre.php');
} else {
    if ($isPasswordCorrect) {  
        $_SESSION['id'] = $resultat['id'];
        $_SESSION['pseudo'] = $pseudo;
        header('Location: index.php');
        echo 'Vous êtes connecté !';
    } else {
        $_SESSION['errorMSG'] = 'Mauvais identifiant ou mot de passe !';
        header('Location: connexion_membre.php');
    }
}
<?php
session_start();
include "connexion.php";


// On récupère les infos du formulaire et rend inoffensives les balises HTML que le visiteur a pu entrer
$_SESSION['pseudo'] = $_POST['pseudo'];
$pseudo = $_POST['pseudo'];
echo $pseudo . ' : pseudo </br>';
$passwd = ($_POST['password']);
$passwd_verif = ($_POST['password_verif']);
$email = ($_POST['email']);
$_SESSION['email'] = $_POST['email'];

// Hachage du mot de passe
$pass_hache = password_hash($passwd, PASSWORD_DEFAULT);

$errorMSG = "";

try {
    // Vérification si pseudo dispo
    $reponse = $bdd->prepare("SELECT pseudo FROM membres WHERE pseudo = '$pseudo' ");
    $reponse->execute();
    $dispo_pseudo = $reponse->fetch();
    //$dispo_pseudo->closeCursor();

    // Vérification si email dispo
    $reponse = $bdd->prepare("SELECT email FROM membres WHERE email = '$email' ");
    $reponse->execute();
    $dispo_email = $reponse->fetch();

    // Vérification de l'adresse mail avec un Regex
    $mail = preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email);

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($pseudo) && isset($passwd) && isset($passwd_verif) && isset($email)) {
    if ($mail == 1){

    if (strtolower($dispo_pseudo['pseudo']) == strtolower($pseudo)) {
        $_SESSION['errorMSG_pseudo'] = 'Il y a déjà une personne qui utilise ' . $pseudo . ' comme pseudo !';
        header('Location: inscription.php');
        //sleep(12);
       // session_destroy() ;
    } elseif (strtolower($dispo_email['email']) == strtolower($email)) {
        $_SESSION['errorMSG_email'] =  'Il y a déjà une personne qui utilise ' . $email . ' comme adresse de contact !<br />';
        header('Location: inscription.php');
        
    } elseif ($passwd != $passwd_verif) {
        $_SESSION['errorMSG_passwd'] = 'Les mots de passe ne sont pas identiques, veuillez réessayer !';
        header('Location: inscription.php');
    } else {
        echo 'Le pseudo ' . $pseudo . ' et l\'adresse mail ' . $email . ' sont libres </br>';

        $req = $bdd->prepare("INSERT INTO membres(pseudo, pass, email, date_inscription) VALUES(:pseudo, :passwd, :email, NOW()) ");
        $req->execute(array(
            "pseudo" => $pseudo,
            "passwd" => $pass_hache,
            "email" => $email
        ));
        echo "Votre inscription a bien été prise en compte";
        $req->closeCursor(); // Termine le traitement de la requête  
        // Puis redirection vers page de connexion :
        header('Location: connexion_membre.php');
    }
} else {
    $errorMSG = 'L\'adresse email ' . $email . ' n\'est pas au bon format';
}
}



?>
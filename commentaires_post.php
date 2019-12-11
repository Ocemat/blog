<?php
include "connexion.php";

$pseudo = $_POST['pseudo'];
$contenu = $_POST['contenu'];
$id_billet = $_POST['id_billet'];


if (isset($pseudo) && isset($contenu)) {
    $req = $bdd -> prepare("INSERT INTO commentaires(id_billet, auteur, commentaire, date_commentaire) VALUES(:id_billet, :pseudo, :contenu, NOW()) ");
    $req -> execute(array(
        "id_billet" => $id_billet,
        "pseudo" => $pseudo,
        "contenu" => $contenu
   
    ));
    echo "votre commentaire a bien été posté";
} 
    $req->closeCursor(); // Termine le traitement de la requête   
    
// Puis redirection vers minichat.php comme ceci :
header('Location: index.php');
?>
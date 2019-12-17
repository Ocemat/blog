<?php
    include '../connexion.php';
    $id = $_GET['id'];
    $req = $bdd->prepare("DELETE FROM billets where id = $id ");
    $req->execute();
    $billet = $req->fetch();

    $req->closeCursor(); // Termine le traitement de la requête précédente 

     // Puis redirection :
    header('Location: liste_billets.php');
?>

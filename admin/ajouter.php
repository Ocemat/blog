<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter un Article</title>
</head>
<body>
<h1> Ajouter un article au blog</h1>
</br>

<form action="ajouter.php" method="POST">
<label for="titre">Titre : </label>
<input type = "text" name="titre" id="titre" size=62/> </br></br>
<textarea name="contenu" id="contenu" rows=10 cols=70></textarea> </br></br>
<input type="submit" value="Envoyer" />
</form>

<?php
include '../connexion.php';
$titre = isset($_POST['titre']);
$contenu = isset($_POST['contenu']);


if (!empty($titre) && !empty($contenu)) {
    
    $req = $bdd ->prepare("INSERT INTO billets(titre, contenu, date_creation) VALUES(:titre, :contenu, NOW()) ");
    $req -> execute(array(
        "titre" => $_POST['titre'],
        "contenu" => $_POST['contenu']
    ));
    echo "Le billet a bien été créé !";
    $req -> closeCursor(); // Termine le traitement de la requête  
}



?>
    
</body>
</html>
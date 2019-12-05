<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css" />
    <title>Mon blog</title>
</head>
<body>

<h1>Mon super Blog !</h1>
<p>Derniers billets du blog :</p>

<?php

//Connexion à la base de données
include 'connexion.php';

// Récupération de la liste des billets
$billets = $bdd -> prepare('SELECT * FROM billets LIMIT 0,5');
$billets -> execute();

while($donnees = $billets -> fetch()) {
    echo '<p>' . $donnees['titre'] . '</p>';
    echo '<p>' . $donnees['contenu'] . '</p>';
}

?>

    
</body>
</html>
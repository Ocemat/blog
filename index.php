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
$billets = $bdd -> prepare("SELECT id, titre, contenu, DATE_FORMAT(date_creation, '%d/%m/%Y') AS date_c, DATE_FORMAT(date_creation, '%Hh%imin%ss') AS heure_c FROM billets ORDER BY date_c DESC LIMIT 0,5");
$billets -> execute();

while($donnees = $billets -> fetch()) {
?>
<div class= "news">
    <h3>  <?= htmlspecialchars($donnees['titre'])?> Rédigé le <?= htmlspecialchars($donnees['date_c'])?> à <?= htmlspecialchars($donnees['heure_c'])?></h3>
    <p>  <?= htmlspecialchars($donnees['contenu']) ?> </br>
    <a href="commentaires.php?id=<?= $donnees['id'] ?>" >Commentaires</a>
    </p>
</div>
<?php
}
?>

    
</body>
</html>
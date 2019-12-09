<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css" />
    <title>Mon blog</title>
</head>
<body>
    
    <?php
    //Connexion à la base de données
    include 'connexion.php';
    $id = $_GET['id'];
    $billet = $bdd -> prepare("SELECT id, titre, contenu, DATE_FORMAT(date_creation, '%d/%m/%Y') AS date_c, DATE_FORMAT(date_creation, '%Hh%imin%ss') AS heure_c 
                                FROM billets
                                WHERE id = $id ");
    $billet -> execute();
    $bil = $billet -> fetch();
    ?>

    <h1>Mon super Blog !</h1>
    <a href="index.php"> Retour à la liste des billets</a> </br>

    <div class= "news">
        <h3>  <?= htmlspecialchars($bil['titre'])?> Rédigé le <?= htmlspecialchars($bil['date_c'])?> à <?= htmlspecialchars($bil['heure_c'])?></h3>
        <p>  <?= htmlspecialchars($bil['contenu']) ?> </br>   </p>
    </div>  </br>
    <h2> Commentaires :</h2>

    <?php
    $billet->closeCursor(); // Termine le traitement de la requête  

    $commentaires = $bdd -> prepare("SELECT commentaire, auteur, DATE_FORMAT(date_commentaire, '%d/%m/%Y') AS date_c, DATE_FORMAT(date_commentaire, '%Hh%imin%ss') AS heure_c 
                                    FROM billets b
                                    JOIN commentaires c ON b.id = c.id_billet
                                    WHERE b.id = $id
                                    ");
    $commentaires -> execute();

    while($com = $commentaires -> fetch()) {
    ?>
        <div>
            <p> <strong> <?= htmlspecialchars($com['auteur']) ?> </strong> le <?= htmlspecialchars($com['date_c'])?> à <?= htmlspecialchars($com['heure_c'])?> </br>   </p>
            <?= $com['commentaire']?> 
        </div> 

    <?php
    }
    ?>

      
</body>
</html>
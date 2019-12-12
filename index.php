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

    //Affichage de 5 messages par page
    $msg_par_page = 5;
    //Nous récupérons le contenu de la requête dans $retour_total
    $retour_total = $bdd->prepare('SELECT COUNT(*) AS total FROM billets');
    $retour_total->execute();
    //On range le retour sous la forme d'un tableau
    $donnees_total = $retour_total->fetch();
    //On récupère le total pour le placer dans la variable $total
    $total = $donnees_total['total'];
    //Nous allons maintenant compter le nombre de pages
    $nb_pages = ceil($total / $msg_par_page);

    if (isset($_GET['page'])) { // Si la variable $_GET['page'] existe...
        $page_actuelle = intval($_GET['page']);

        if ($page_actuelle > $nb_pages) { // Si la valeur de $page_actuelle (n°page) est plus grande que $nb_pages...

            $page_actuelle = $nb_pages;
        }
    } else {
        $page_actuelle = 1; // La page actuelle est la n°1    
    }

    // On calcul la première entrée à lire
    $premiere_entree = ($page_actuelle - 1) * $msg_par_page;


    // Récupération de la liste des billets
    $billets = $bdd->prepare("SELECT id, titre, contenu, DATE_FORMAT(date_creation, '%d/%m/%Y') AS date_c, DATE_FORMAT(date_creation, '%Hh%imin%ss') AS heure_c FROM billets ORDER BY date_creation DESC LIMIT :msg_par_page OFFSET :premiere_entree");
    $billets->bindValue('msg_par_page', $msg_par_page, PDO::PARAM_INT);   // Cette valeur est de type entier

    $billets->bindValue('premiere_entree', $premiere_entree, PDO::PARAM_INT);
    $billets->execute();

    while ($donnees = $billets->fetch()) {
        ?>
        <div class="news">
            <h3> <?= htmlspecialchars($donnees['titre']) ?> - Rédigé le <?= htmlspecialchars($donnees['date_c']) ?> à <?= htmlspecialchars($donnees['heure_c']) ?></h3>
            <p> <?= htmlspecialchars($donnees['contenu']) ?> </br>
                <a href="commentaires.php?id=<?= $donnees['id'] ?>">Commentaires</a>
            </p>
        </div>

    <?php
    }
    $billets->closeCursor(); // Termine le traitement de la requête 
    echo '<p align="center">Page : ';
    for ($i = 1; $i <= $nb_pages; $i++) {

        //On va faire notre condition
        if ($i == $page_actuelle) {
            echo ' [ ' . $i . ' ] ';
        } else {
            echo ' <a href="index.php?page=' . $i . '">' . $i . '</a> ';
        }
    }
    echo '</p>';

    ?>


</body>

</html>
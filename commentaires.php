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
    $billet = $bdd->prepare("SELECT id, titre, contenu, DATE_FORMAT(date_creation, '%d/%m/%Y à %Hh%imin%ss') AS date_c 
                                FROM billets
                                WHERE id = $id");
    $billet->execute();
    $bil = $billet->fetch();

    if (!empty($bil)) {
        ?>

        <h1>Mon super Blog !</h1>
        <a href="index.php"> Retour à la liste des billets</a> </br>

        <div class="news">
            <h3> <?= htmlspecialchars($bil['titre']) ?> Rédigé le <?= htmlspecialchars($bil['date_c']) ?></h3>
            <p> <?= htmlspecialchars($bil['contenu']) ?> </br> </p>
        </div> </br>

        <form action="commentaires_post.php" method="post">
            <input type="hidden" name="id_billet" id="id_billet" value=<?= $id ?> />
            <label for="pseudo"> Pseudo : </label> <input type="text" name="pseudo" id="pseudo" /> </br></br>
            <textarea name="contenu" id="contenu" rows=8 cols=55 placeholder="Votre commentaire"></textarea></br></br>
            <input type="submit" value="Envoyer" /></br>
        </form>

        <h2> Commentaires :</h2>

        <?php
            $billet->closeCursor(); // Termine le traitement de la requête  

            //Affichage de 5 commentaires par page
            $msg_par_page = 2;
            //Nous récupérons le contenu de la requête dans $retour_total
            $retour_total = $bdd->prepare("SELECT COUNT(*) AS total FROM commentaires WHERE id_billet = $id");
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


            // Récupération de la liste des commentaires
            $commentaires = $bdd->prepare("SELECT commentaire, auteur, DATE_FORMAT(date_commentaire, '%d/%m/%Y à %Hh%imin%ss') AS date_c
                                    FROM billets b
                                    JOIN commentaires c ON b.id = c.id_billet
                                    WHERE b.id = $id
                                    ORDER BY date_commentaire DESC
                                    LIMIT :msg_par_page OFFSET :premiere_entree
                                    ");
            $commentaires->bindValue('msg_par_page', $msg_par_page, PDO::PARAM_INT);   // Cette valeur est de type entier
            $commentaires->bindValue('premiere_entree', $premiere_entree, PDO::PARAM_INT);
            $commentaires->execute();

            while ($com = $commentaires->fetch()) {
                ?>
            <div>
                <p> <strong> <?= htmlspecialchars($com['auteur']) ?> </strong> le <?= htmlspecialchars($com['date_c']) ?> </br> </p>
                <?= $com['commentaire'] ?>
            </div>

        <?php
            }
            $commentaires->closeCursor(); // Termine le traitement de la requête 
            echo '<p align="center">Page : ';
            for ($i = 1; $i <= $nb_pages; $i++) {

                //On va faire notre condition
                if ($i == $page_actuelle) {
                    echo ' [ ' . $i . ' ] ';
                } else {
                    echo ' <a href="commentaires.php?id=' . $id . '&page=' . $i . '">' . $i . '</a> ';
                }
            }
            echo '</p>';
            ?>

    <?php
    } else {
        echo "Ce billet n'existe pas ! </br> </br>";
        echo '<a href="index.php"> Retour à la liste des billets</a> </br>';
    }
    ?>

</body>

</html>
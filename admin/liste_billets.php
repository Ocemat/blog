<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style.css" />
    <title>Administration</title>
</head>

<body>
    <h1> Administration des billets</h1></br> </br> 

<a href="ajouter.php"> <button>Ajouter un billet</button> </a></br> </br>
    <table>
        <thead>
                <th>Titre</th>
                <th>Contenu</th>
                <th>Date Création</th>
                <th>Modifier</th>
                <th>Supprimer</th>  
        </thead>

        <?php
        include '../connexion.php';
        $req = $bdd->prepare("SELECT id, titre, contenu, DATE_FORMAT(date_creation, '%d/%m/%Y à %Hh%imin%ss') AS date_c  FROM billets ORDER BY date_creation ");
        $req->execute();
        while ($donnees = $req->fetch()) {
        ?>
        <tbody>
            <tr>
                <td> <?= $donnees['titre'] ?> </td>
                <td> <?= $donnees['contenu'] ?> </td>
                <td> <?= $donnees['date_c'] ?> </td>
                <td> <a href="modifier.php?id=<?= $donnees['id'] ?>"> <button>Modifier</button> </a> </td>
                <td> <a href="supprimer.php?id=<?= $donnees['id'] ?>"> <button>Supprimer</button> </a> </td>
            </tr>
        </tbody>
        <?php
        }
        ?>
    </table>




</body>

</html>
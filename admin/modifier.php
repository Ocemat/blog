<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <h1> Modifier un article du blog</h1>
    </br>

    <?php
    include '../connexion.php';
    $id = $_GET['id'];
    $req = $bdd->prepare("SELECT id, titre, contenu, DATE_FORMAT(date_creation, '%d/%m/%Y à %Hh%imin%ss') AS date_c FROM billets WHERE id=$id ");
    $req->execute();
    $billet = $req->fetch();
    ?>

    <form action="modifier.php" method="POST">
        <input type="hidden" name="id" id="id" value=<?= $id ?>> </br></br>
        <label for="titre">Titre : </label>
        <input type="text" name="titre" id="titre" size=62 value='<?= $billet['titre'] ?>'> </br></br>
        <textarea name="contenu" id="contenu" rows=10 cols=70> <?= $billet['contenu'] ?> </textarea> </br></br>
        <input type="submit" value="Modifier mon billet" />
    </form>

    <?php
    $req->closeCursor(); // Termine le traitement de la requête précédente 
    $titre = isset($_POST['titre']);
    $contenu = isset($_POST['contenu']);
    
    

    if (!empty($titre) && !empty($contenu)) {
        $req = $bdd->prepare("UPDATE billets SET titre = :titre, contenu = :contenu WHERE id = :id  ") or die("Query failed: ");
        $req -> execute(array(
            "titre" => $_POST['titre'],
            "contenu" => $_POST['contenu'],
            "id" => $_POST['id']
        ));
        echo "Le billet a bien été modifié !";
        $req->closeCursor(); // Termine le traitement de la requête 
    
    // Puis redirection :
   header('Location: liste_billets.php');
    }
    ?>

</body>

</html>
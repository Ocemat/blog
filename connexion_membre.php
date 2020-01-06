<?php 
session_start();
?>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" />
    <title>Document</title>
</head>

<body>
    <h1>Page de connexion</h1>
    <form action="connexion_membre_post.php" method="POST">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="pseudo">Pseudo</label>
                <input type="text" class="form-control" name="pseudo" id="pseudo" value="<?php if (isset($_SESSION['pseudo'])) { echo $_SESSION['pseudo']; } ?>" required> </br>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" name="password" id="password" required></br>
                <?php if (isset($_SESSION['errorMSG'])) { ?>
                    <span style="font: italic 16px times; color:red;"><?php if (isset($_SESSION['errorMSG'])) {
                                                                            echo $_SESSION['errorMSG'];
                                                                        } ?></span>
                <?php } ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="connexion_au">Connexion automatique</label>
                <input type="checkbox" name="connexion_au" id="connexion_au" ></br>   
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Je me connecte</button>
        <?php
        session_destroy();
        ?>

    </form>

</body>

</html>
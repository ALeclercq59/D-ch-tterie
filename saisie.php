<?php
session_start();
include('./include/connectBdd.php'); 

if($_SESSION['statut'] != 'Informaticien')
{
    header('Location: acceuil.php');
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <?php require('./include/header.html'); ?>
        <link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/btn_custom.css" rel="stylesheet" type="text/css"/>
    </head>

    <body class='home home_acceuil'>

        <!-- Navigation start -->
        <header id="nav" class='header'>
            <nav id='navbar' class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
                <div class="container">

                    <div class="navbar-header">
                        <a class="navbar-brand title-nav" href="acceuil.php"><?= $_SESSION['statut']; ?></a>
                    </div>

                    <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarResponsive">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="acceuil.php">Acceuil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link saisie" href="saisie.php">Saisie</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="tonnage.php">Tonnage</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <!-- Navigation end -->

        <div class="container">
            <h1 class='title text-center'>SAISIE</h1>
            <br>

            <form action="saisie.php" method='post' autocomplete="off">
                <div class="form-group col-md-6 offset-md-3">
                    <label for="dechetterie">Déchètterie :</label>
                    <select class="form-control" id="dechetterie" name="dechetterie" id="search" required>
                        <option selected disabled value="">Choisissez une déchètterie</option>
                        <?php

                        $req = $bdd->query('SELECT adresse, code FROM dechetterie');

                        while ($donnees = $req->fetch())
                        {
                            echo "<option value='".$donnees['code']."'>".$donnees['adresse']."</option>";
                        }

                        ?>

                    </select>
                </div>
                <br>
                <div class="form-group col-md-6 offset-md-3">
                    <label for="dechet">Type de déchet :</label>
                    <select class="form-control" id="dechet" name="dechet" id="search" required>
                        <option selected disabled value="">Choisissez un type de déchet</option>
                        <?php

                        $req = $bdd->query('SELECT * FROM typedechetd');

                        while ($donnees = $req->fetch())
                        {
                            echo "<option value='".$donnees['code']."'>".$donnees['libelle']."</option>";
                        }

                        ?>

                    </select>
                </div>
                <br>
                <div class="form-group col-md-3 col-6 offset-md-3">
                    <label for="time">Date :</label>
                    <br>
                    <div class="input-group-append">
                        <input class="datetime-input" id='time' name='date' required/>
                    </div>
                </div>
                <br>
                <div class="form-group col-md-3 col-6 offset-md-3">
                    <label for="quantite">Quantité(s) :</label>
                    <br>
                    <div class="input-group-append">
                        <input type='number' class="form-control" id='quantite' name='quantite' placeholder='Entrez un nombre' min='1' required/>
                    </div>
                </div>
                <br>
                <div id='insertsuccess' class="alert alert-success col-md-4 offset-md-4 text-center" role="alert" hidden>
                    La saisie a bien été enregistré !
                </div>
                <br>
                <button type="submit" class="btn btn-primary col-md-2 offset-md-5">Envoyer</button>
            </form>
        </div>
        <div class='deco'>
            <a href="deconnexion.php" class='btn1 btn1-danger'>Déconnexion <i class="fas fa-sign-out-alt"></i></a>
        </div>
    </body>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/messages/messages.fr-fr.js" type="text/javascript"></script>

    <!-- Personnal Javascript -->
    <script type="text/javascript" src="js/js.js"></script>

</html>

<script>
    $('.datetime-input').datepicker({
        showOnFocus: true,
        showRightIcon: true,
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        locale: 'fr-fr',
        weekStartDay: 1,
    });
</script>

<?php

if (isset($_POST['dechetterie']) && isset($_POST['dechet']) && isset($_POST['date']) && isset($_POST['quantite']))
{
    $insertDechet = $bdd->prepare('INSERT INTO leveedechetterie (codedechetterie, codetypedechet, datelevee, quantiteenlevee) VALUES (?, ?, ?, ?)');
    $insertDechet->execute(array($_POST['dechetterie'], $_POST['dechet'], $_POST['date'], $_POST['quantite']));
?> <script>afficheSuccessInsert()</script> <?php
}

?>
<?php
session_start();
include('./include/connectBdd.php');
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
            <h1 class='title text-center'>TONNAGE</h1>
            <br>
            <form id='tonnageForm'>
                <div class="row">
                    <div class="col">
                        <div class="form-group col-md-9 offset-md-2">
                            <label for="dechetterie">Déchètterie :</label>
                            <select class="form-control" id="dechetterie" name="dechetterie" id="dechetterie" required>
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
                    </div>

                    <div class="col">
                        <div class="form-group col-md-9 col-6 offset-md-1">
                            <label for="time">Date :</label>
                            <br>
                            <div class="input-group-append">
                                <input class="datetime-input" id='time' name='date' required autocomplete="off"/>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <button type="submit" id='submit' class="btn btn-primary col-md-2 offset-md-5 tonnage">Envoyer</button>
            </form>
            <br>
            <div class="alert alert-danger alert-dechet col-md-4 offset-md-4 text-center" role="alert" hidden>
                Pas de déchets pour cette date !
            </div>
            <div class='tableau'>

            </div>
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
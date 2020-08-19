<?php
session_start();
include('./include/connectBdd.php'); 
?>
<!DOCTYPE HTML>
<html>
    <head>
        <?php require('./include/header.html'); ?>
        
        <!-- Material Design Bootstrap -->
        <link href="css/btn_custom.css" rel="stylesheet" type="text/css"/>
    </head>

    <body class='home home_accueil'>
        
        <!-- Navigation start -->
        <header id="nav" class='header'>
            <nav id='navbar' class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
                <div class="container">

                    <div class="navbar-header">
                        <a class="navbar-brand title-nav" href="accueil.php"><?= $_SESSION['statut']; ?></a>
                    </div>

                    <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarResponsive">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="accueil.php">Accueil</a>
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
            <h1 class='title text-center'>Levée de déchets</h1>
            <br>
            <table class="table">
                <thead class='thead-dark'>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Déchètterie</th>
                        <th scope="col">Déchets</th>
                        <th scope="col">Date</th>
                        <th scope="col">Quantité</th>
                    </tr>
                </thead>
                <tbody>



                    <?php

                    // On détermine sur quelle page on se trouve
                    if(isset($_GET['page']) && !empty($_GET['page'])){
                        $currentPage = (int) strip_tags($_GET['page']);
                    }else{
                        $currentPage = 1;
                    }

                    $count = $bdd->query('SELECT count(*) as ligne FROM leveedechetterie');
                    $count = $count->fetch();


                    $parPage = 10;
                    
                    $pages = ceil($count['ligne'] / $parPage);

                    $premier = ($currentPage * $parPage) - $parPage;


                    $req = $bdd->prepare('SELECT * FROM leveedechetterie LIMIT :premier, :parpage');
                    $req->bindValue(':premier', $premier, PDO::PARAM_INT);
                    $req->bindValue(':parpage', $parPage, PDO::PARAM_INT);

                    $req->execute();


                    while ($donnees = $req->fetch())
                    {
                        $req1 = $bdd->prepare('SELECT adresse FROM dechetterie d, leveedechetterie ld WHERE ld.codedechetterie = d.code AND d.code = ?');
                        $req1->execute(array($donnees['codedechetterie']));
                        $dechetterie = $req1->fetch();

                        $req2 = $bdd->prepare('SELECT libelle FROM typedechetd td, leveedechetterie ld WHERE ld.codetypedechet = td.code AND td.code = ?');
                        $req2->execute(array($donnees['codetypedechet']));
                        $dechet = $req2->fetch();

                        echo "<tr>";
                        echo "<td>" .$donnees['id']. "</td>";
                        echo "<td>" .$dechetterie['adresse']. "</td>";
                        echo "<td>" .$dechet['libelle']. "</td>";
                        echo "<td>" .$donnees['datelevee']. "</td>";
                        echo "<td>" .$donnees['quantiteenlevee']."</td>";
                        echo "</tr>";
                    }

                    ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination">
                    <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                    <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                        <a href="?page=<?= $currentPage - 1 ?>" class="page-link" style="color:white">Précédente</a>
                    </li>
                    <?php for($page = 1; $page <= $pages; $page++): ?>
                    <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                    <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                        <a href="?page=<?= $page ?>" class="page-link" style="color:white"><?= $page ?></a>
                    </li>
                    <?php endfor ?>
                    <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                    <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                        <a href="?page=<?= $currentPage + 1 ?>" class="page-link" style="color:white">Suivante</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class='deco'>
            <a href="deconnexion.php" class='btn1 btn1-danger'>Déconnexion <i class="fas fa-sign-out-alt"></i></a>
        </div>
    </body>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->

        <!-- Personnal Javascript -->
        <script type="text/javascript" src="js/js.js"></script>

</html>

<?php 

    // Si c'est un invité on enlève l'option Saisie
    if ($_SESSION['statut'] == 'Invité')
    {
        ?> <script>inviteConnect();</script> <?php
    }

?>

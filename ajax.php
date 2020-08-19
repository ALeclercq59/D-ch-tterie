<?php
session_start();
include('./include/connectBdd.php'); 

/* Ajax pour le tableau dans la page tonnage */

if(isset($_POST['dechetterie']) && isset($_POST['date']))
{
    $dechetterie = $_POST['dechetterie'];
    $date = $_POST['date'];

    $req = $bdd->prepare('SELECT td.libelle AS libelle, sum(quantiteenlevee) AS quantite FROM leveedechetterie ld, typedechetd td, dechetterie d WHERE ld.codetypedechet = td.code AND d.code = ld.codedechetterie AND d.code = ? AND ld.datelevee = ? GROUP BY td.code');
    $req->execute(array($dechetterie, $date));
    $count = $req->rowCount();

    if($count != 0 )
    {
?>
<table class="table">
    <thead class='thead-dark'>
        <tr>
            <th scope="col">Déchet</th>
            <th scope="col">Quantité</th>
        </tr>
    </thead>
    <tbody>

        <?php

        while ($donnees = $req->fetch())
        {
            echo "<tr>";
            echo "<td>" .$donnees['libelle']. "</td>";
            echo "<td>" .$donnees['quantite']. "</td>";
            echo "</tr>";
        }
        ?>

    </tbody>
</table>

<?php
    }

    else {
        echo $count;
    }
}



/* Ajax Pour la connexion */

if(isset($_POST['login']) && isset($_POST['password']))
{
    $req = $bdd->prepare('SELECT * FROM user WHERE login = ? AND password = ?');
    $req->execute(array($_POST['login'], $_POST['password']));
    $user = $req->fetch();
    $nbr = $req->rowCount();

    if($nbr == 0)
    {
        echo 'erreur';
    }
    else
    {
        if($user['statut'] == 0) // Informaticien
        {
            $_SESSION['statut'] = 'Informaticien';
        }
        else // Invité
        {
            $_SESSION['statut'] = 'Invité';
        }
    }
}



/* Pagination pour tableau dans acceuil */






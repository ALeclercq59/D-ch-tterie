<?php

$output = "";

$output .= "<table class='table'>
                <thead class='thead-dark'>
                    <tr>
                        <th scope='col'>Id</th>
                        <th scope='col'>Déchètterie</th>
                        <th scope='col'>Déchets</th>
                        <th scope='col'>Date</th>
                        <th scope='col'>Quantité</th>
                    </tr>
                </thead>
                <tbody>";


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


    $output .= "<tr>
                    <td>".$donnees['id']."</td>
                    <td>".$dechetterie['adresse']."</td>
                    <td>".$dechet['libelle']."</td>
                    <td>".$donnees['datelevee']."</td>
                    <td>".$donnees['quantiteenlevee']."</td>
                </tr>
                </tbody>
            </table>
            <nav>
                <ul class='pagination'>
                    <li class='page-item".($currentPage == 1) ? "disabled" : ""."'>
                        <a href='?page=".$currentPage - 1 ."' class='page-link' style='color:white'>Précédente</a>
                    </li>";
    for($page = 1; $page <= $pages; $page++):
    output .= "<li class='page-item".($currentPage == $page) ? "active" : """.'>
                        <a href='?page=".$page."' class='page-link' style='color:white'>".$page."</a>
                    </li>";
    endfor
    output .= "<li class='page-item".($currentPage == $pages) ? "disabled" : ""."'>
                        <a href='?page=". $currentPage + 1 ."' class='page-link' style='color:white'>Suivante</a>
                    </li>
                </ul>
            </nav>";
}

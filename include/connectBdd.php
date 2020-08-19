<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=dechetterie;charset=utf8', 'root', '');
}
catch (Exception $e) {
    echo 'Erreur lors du carhement du serveur';
}
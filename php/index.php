<?php
$host = "mysql"; // Remplacez par l'hôte de votre base de données
$port = "3306";
$dbname = "afci"; // Remplacez par le nom de votre base de données
$user = "admin"; // Remplacez par votre nom d'utilisateur
$pass = "admin"; // Remplacez par votre mot de passe

// Connexion à la base de données
try {
    $bdd = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    // Configure PDO to throw exceptions on error
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afci Base de Données</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="home">
        <ul class="navBar">
            <a href="?page=role"><li>Rôle</li></a>
            <a href="?page=centre"><li>Centres</li></a>
            <a href="?page=formation"><li>Formations</li></a>
            <a href="?page=pedagogie"><li>Équipe Pédagogique</li></a>
            <a href="?page=session"><li>Session</li></a>
            <a href="?page=apprenant"><li>Apprenants</li></a>
            <a href="?page=affecter"><li>Affecter</li></a>
        </ul></div>
    <div class="page1">
<?php
$host = "mysql"; // Remplacez par l'hôte de votre base de données
$port = "3306";
$dbname = "afci"; // Remplacez par le nom de votre base de données
$user = "admin"; // Remplacez par votre nom d'utilisateur
$pass = "admin"; // Remplacez par votre mot de passe


    // Création d'une nouvelle instance de la classe PDO
    $bdd = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);

    // Configuration des options PDO
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // echo "Connexion réussie !";

    require('role.php');
    require('centre.php');
    require('formation.php');
    require('pedagogie.php');
    require('session.php');
    require('apprenant.php');
    require('affecter.php');

?>
</div>

<script src="script.js"></script>
</body>
</html> 
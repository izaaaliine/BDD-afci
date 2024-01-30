<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
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

    // Lire des données dans la BDD
    $sql = "SELECT * FROM apprenants";
    $requete = $bdd->query($sql);
    $results = $requete->fetchAll(PDO::FETCH_ASSOC);
    

    // foreach( $results as $value ){
    //     foreach($value as $data){
    //         echo $data;
    //         echo "<br>";

    //     }
    //     echo "<br>";
    // }

    // foreach( $results as $value ){
    //     echo "<h2>" . $value["nom_apprenant"] . "</h2>";
    //     echo "<br>";
    // }


    // Insérer des données dans la BDD
// ROLES
        if (isset($_GET["page"])&& $_GET["page"]=="role"){
                $sqlRole = "SELECT * FROM role";
                $requeteRole = $bdd->query($sqlRole);
                $resultsRole = $requeteRole->fetchAll(PDO::FETCH_ASSOC);
            ?>

                <form method="POST">
                    <h2>Ajout Rôle</h2>
                    <input type="text" name="nomRole" placeholder="Nom du rôle">
                    <input type="submit" name="submitRole" value="enregister">
                </form>
                <table border ="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom du Rôle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($resultsRole as $value) {
                            echo '<tr>';
                            echo '<td>' . $value['id_role'] . '</td>';
                            echo '<td>' . $value['nom_role'] . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
           
            <?php
       
            if (isset($_POST['submitRole'])){
                $nomRole = $_POST['nomRole'];
                $sql = "INSERT INTO `role`(`nom_role`) VALUES ('$nomRole')";
                $bdd->query($sql);
            }


        }
// CENTRES
         if (isset($_GET["page"])&& $_GET["page"]=="centre"){
            $sqlCentre = "SELECT * FROM centres";
            $requeteCentre = $bdd->query($sqlCentre);
            $resultsCentre = $requeteCentre->fetchAll(PDO::FETCH_ASSOC);
            ?>

                <form method="POST">
                    <h2>Ajout Centre</h2>
                    <input type="text" name="villeCentre" placeholder="Ville">
                    <input type="text" name="adresseCentre" placeholder="Adresse">
                    <input type="text" name="codePostalCentre" placeholder="CP">
                    <input type="submit" name="submitCentre" value="enregister">
                </form>
                <table border ="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ville</th>
                            <th>Adresse</th>
                            <th>Code Postal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($resultsCentre as $value) {
                            echo '<tr>';
                            echo '<td>' . $value['id_centre'] . '</td>';
                            echo '<td>' . $value['ville_centre'] . '</td>';
                            echo '<td>' . $value['adresse_centre'] . '</td>';
                            echo '<td>' . $value['code_postal_centre'] . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            <?php
        if (isset($_POST['submitCentre'])){
        $villeCentre = $_POST['villeCentre'];
        $adresseCentre = $_POST['adresseCentre'];
        $codePostalCentre = $_POST['codePostalCentre'];

       $sql = "INSERT INTO `centres` (`ville_centre`, `adresse_centre`, `code_postal_centre`) VALUES (?, ?, ?)";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$villeCentre, $adresseCentre, $codePostalCentre]);
    }
        }
// FORMATIONS
        if (isset($_GET["page"])&& $_GET["page"]=="formation"){
            $sqlFormation = "SELECT * FROM formations";
            $requeteFormation = $bdd->query($sqlFormation);
            $resultsFormation = $requeteFormation->fetchAll(PDO::FETCH_ASSOC);
            ?>

                <form method="POST">
                    <h2>Ajout Formation</h2>
                    <input type="text" name="nomFormation" placeholder="Nom">
                    <input type="text" name="dureeFormation" placeholder="Durée">
                    <input type="text" name="niveauSortieFormation" placeholder="Niveau de sortie">
                    <input type="text" name="descriptionFormation" placeholder="Description">
                    <input type="submit" name="submitFormation" value="enregister">
                </form>
                <table border ="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom de la Formation</th>
                            <th>Durée</th>
                            <th>Niveau de Sortie</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($resultsFormation as $value) {
                            echo '<tr>';
                            echo '<td>' . $value['id_formation'] . '</td>';
                            echo '<td>' . $value['nom_formation'] . '</td>';
                            echo '<td>' . $value['duree_formation'] . '</td>';
                            echo '<td>' . $value['niveau_sortie_formation'] . '</td>';
                            echo '<td>' . $value['description'] . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            <?php
        if (isset($_POST['submitFormation'])){
            $nomFormation = $_POST['nomFormation'];
            $dureeFormation = $_POST['dureeFormation'];
            $niveauSortieFormation = $_POST['niveauSortieFormation'];
            $descriptionFormation = $_POST['descriptionFormation'];

            $sql = "INSERT INTO `formations`(`nom_formation`, `duree_formation`, `niveau_sortie_formation`, `description`) VALUES ('$nomFormation','$dureeFormation','$niveauSortieFormation','$descriptionFormation')";
            $bdd->query($sql);
    }
        }

// PEDAGOGIE
        if (isset($_GET["page"])&& $_GET["page"]=="pedagogie"){

            $sqlRole = "SELECT * FROM role";
            $requeteRole = $bdd->query($sqlRole);
            $resultsRole = $requeteRole->fetchAll(PDO::FETCH_ASSOC);

            $sqlPedagogie = "SELECT `id_pedagogie`, `nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`, `pedagogie`.`id_role`, `nom_role`
            FROM `pedagogie`
            JOIN `role` ON `pedagogie`.`id_role` = `role`.`id_role`;
            ";
            $requetePedagogie = $bdd->query($sqlPedagogie);
            $resultsPedagogie = $requetePedagogie->fetchAll(PDO::FETCH_ASSOC);

            ?>

                <form method="POST">
                    <h2>Ajout Pédagogie</h2>
                    <input type="text" name="nomPedagogie" placeholder="Nom">
                    <input type="text" name="prenomPedagogie" placeholder="Prénom">
                    <input type="text" name="mailPedagogie" placeholder="Mail">
                    <input type="text" name="numPedagogie" placeholder="Phone">
                    <select name="idPedagogie" id="">
               
                <?php 
                
                foreach( $resultsRole as $value ){             
                        echo '<option value="' . $value['id_role'] .  '">' . $value['id_role'] . ' - ' . $value['nom_role'] . '</option>';   
                }
                ?>
            </select>
            <input type="submit" name="submitPedagogie" value="enregister">
                </form>
                <table border ="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Mail</th>
                            <th>Phone</th>
                            <th>Id du Rôle</th>
                            <th>Role</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($resultsPedagogie as $value) {
                            echo '<tr>';
                            echo '<td>' . $value['id_pedagogie'] . '</td>';
                            echo '<td>' . $value['nom_pedagogie'] . '</td>';
                            echo '<td>' . $value['prenom_pedagogie'] . '</td>';
                            echo '<td>' . $value['mail_pedagogie'] . '</td>';
                            echo '<td>' . $value['num_pedagogie'] . '</td>';
                            echo '<td>' . $value['id_role'] . '</td>';
                            echo '<td>' . $value['nom_role'] . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            <?php
             if (isset($_POST['submitPedagogie'])){
            $nomPedagogie = $_POST['nomPedagogie'];
            $prenomPedagogie = $_POST['prenomPedagogie'];
            $mailPedagogie = $_POST['mailPedagogie'];
            $numPedagogie = $_POST['numPedagogie'];
            $idPedagogie = $_POST['idPedagogie'];
            $sql = "INSERT INTO `pedagogie`(`nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`, `id_role`) VALUES ('$nomPedagogie','$prenomPedagogie','$mailPedagogie','$numPedagogie','$idPedagogie')";
            $bdd->query($sql);

    }
        }
// SESSION
        if (isset($_GET["page"])&& $_GET["page"]=="session"){

            $sqlPedagogie = "SELECT * FROM pedagogie";
            $requetePedagogie = $bdd->query($sqlPedagogie);
            $resultsPedagogie = $requetePedagogie->fetchAll(PDO::FETCH_ASSOC);
             
            $sqlFormation = "SELECT * FROM formations";
            $requeteFormation = $bdd->query($sqlFormation);
            $resultsFormation = $requeteFormation->fetchAll(PDO::FETCH_ASSOC);

            $sqlCentre = "SELECT * FROM centres";
            $requeteCentre = $bdd->query($sqlCentre);
            $resultsCentre = $requeteCentre->fetchAll(PDO::FETCH_ASSOC);

            ?>
            <form method="POST">
    
                <h2>Ajout Session</h2>
                <input type="date" name="dateSession" placeholder="Date">
                <input type="text" name="nomSession" placeholder="Nom de Session">
                <select name="idSession1" id="">
                <?php 
                
                foreach ($resultsPedagogie as $value) {
                echo '<option value="' . $value['id_pedagogie'] . '">' . $value['id_pedagogie'] . ' - ' . $value['nom_pedagogie'] . ' ' . $value['prenom_pedagogie'] . '</option>';
                }
                ?>
            </select>
            <select name="idSession2" id="">
                
                <?php 
                
                foreach ($resultsFormation as $value) {             
                echo '<option value="' . $value['id_formation'] . '">' . $value['id_formation'] . ' - ' . $value['nom_formation'] . '</option>';   
                }
                ?>
            </select>
            <select name="idSession3" id="">
                <?php 
                
                foreach ($resultsCentre as $value) {
                echo '<option value="' . $value['id_centre'] . '">' . $value['id_centre'] . ' - ' . $value['ville_centre'] . '</option>';
                }
                ?>
            </select>
                <input type="submit" name="submitSession" value="enregister">
            </form>
            <?php
            if (isset($_POST['submitSession'])){
            $dateSession = $_POST['dateSession'];
            $idSession1 = $_POST['idSession1'];
            $idSession2 = $_POST['idSession2'];
            $nomSession = $_POST['nomSession'];
            $idSession3 = $_POST['idSession3'];

            $sql = "INSERT INTO `session`(`date_debut`, `nomSession` , `id_pedagogie`, `id_formation`,`id_centre`) VALUES ('$dateSession','$nomSession','$idSession1','$idSession2', ,'$idSession3')";
            $bdd->query($sql);
    }
        }

// APPRENANTS
         if (isset($_GET["page"])&& $_GET["page"]=="apprenant"){
            $sqlRole = "SELECT * FROM role";
            $requeteRole = $bdd->query($sqlRole);
            $resultsRole = $requeteRole->fetchAll(PDO::FETCH_ASSOC);

            $sqlSession = "SELECT `id_session`, `date_debut`, `session`.`id_formation`, `nom_formation`
                            FROM `session`
                            JOIN `formations` ON `session`.`id_formation` = `formations`.`id_formation`";
            $requeteSession = $bdd->query($sqlSession);
            $resultsSession = $requeteSession->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <form method="POST">
                <h2>Ajout Apprenant</h2>
                <input type="text" name="nomApprenant" placeholder="Nom">
                <input type="text" name="prenomApprenant" placeholder="Prénom">
                <input type="text" name="mailApprenant" placeholder="Mail">
                <input type="text" name="adresseApprenant" placeholder="Adresse">
                <input type="text" name="villeApprenant" placeholder="Ville">
                <input type="text" name="cpApprenant" placeholder="CP">
                <input type="text" name="telApprenant" placeholder="Phone">
                <input type="Date" name="dateNaissanceApprenant" placeholder="Date de naissance">
                <input type="text" name="niveauApprenant" placeholder="Niveau">
                <input type="text" name="numPEApprenant" placeholder="Numéro Pôle Emploi">
                <input type="text" name="numSSApprenant" placeholder="Numéro de SS">
                <input type="text" name="ribApprenant" placeholder="RIB">
                <select name="idApprenant1" id="">
                <?php 
                
                foreach ($resultsRole as $value) {
              if ($value['id_role'] == 4) {
            echo '<option value="' . $value['id_role'] .  '">' . $value['id_role'] . ' - ' . $value['nom_role'] . '</option>';
        }
                }
                ?>
            </select>
            <select name="idApprenant2" id="">
                <?php 
                
                foreach ($resultsSession as $value) {
                echo '<option value="' . $value['id_session'] . '">' . $value['id_session'] . ' - ' . $value['date_debut'] . ' - ' . $value ['nom_formation']. '</option>';
                }
                ?>
            </select>
                <input type="submit" name="submitApprenant" value="enregister">
            </form>
            <?php
            if (isset($_POST['submitApprenant'])){
            $nomApprenant = $_POST['nomApprenant'];
            $prenomApprenant = $_POST['prenomApprenant'];
            $mailApprenant = $_POST['mailApprenant'];
            $adresseApprenant = $_POST['adresseApprenant'];
            $villeApprenant = $_POST['villeApprenant'];
            $cpApprenant = $_POST['cpApprenant'];
            $telApprenant = $_POST['telApprenant'];
            $dateNaissanceApprenant = $_POST['dateNaissanceApprenant'];
            $niveauApprenant = $_POST['niveauApprenant'];
            $numPEApprenant = $_POST['numPEApprenant'];
            $numSSApprenant = $_POST['numSSApprenant'];
            $ribApprenant = $_POST['ribApprenant'];
            $idApprenant1 = $_POST['idApprenant1'];
            $idApprenant2 = $_POST['idApprenant2'];

            $sql = "INSERT INTO `apprenants`(`nom_apprenant`, `prenom_apprenant`, `mail_apprenant`, `adresse_apprenant`, `ville_apprenant`, `code_postal_apprenant`, `tel_apprenant`, `date_naissance_apprenant`, `niveau_apprenant`, `num_PE_apprenant`, `num_secu_apprenant`, `rib_apprenant`, `idApprenant1`, `idApprenant2`) VALUES ('$nomApprenant','$prenomApprenant','$mailApprenant','$adresseApprenant',' $villeApprenant','$cpApprenant','$telApprenant','$dateNaissanceApprenant','$niveauApprenant','$numPEApprenant','$numSSApprenant','$ribApprenant','$idApprenant1','$idApprenant2')";
            $bdd->query($sql);
        }
        }
?>


</div>


</body>
</html>
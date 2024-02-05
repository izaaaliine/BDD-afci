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
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultsRole as $value): ?>
                        <tr>
                                <td><?= $value['id_role']; ?></td>
                                <td><?= $value['nom_role']; ?></td>
                                <td><a href="?page=role&type=modifier&id=<?= $value['id_role']; ?>"><button>Modifier</button></a></td>
                                <td>
                                    <form method="POST" action="?page=role&type=supprimer">
                                        <input type="hidden" name="id_role" value="<?= $value['id_role']; ?>">
                                        <button type="submit">Supprimer</button>
                                    </form>
                                </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
               
            <?php
            // ajouter un role
            if (isset($_POST['submitRole'])){
                $nomRole = $_POST['nomRole'];
                $sql = "INSERT INTO `role`(`nom_role`) VALUES ('$nomRole')";
                $bdd->query($sql);
                echo "Données ajoutées dans la BDD";
            }
            // modifier données role
            if (isset($_GET['type']) && $_GET['type'] == "modifier"){

                $id = $_GET["id"];
                $sqlId = "SELECT * FROM role WHERE id_role = $id";
                $requeteId = $bdd->query($sqlId);
                $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
                ?>
                <form method="POST">
                    <input type="hidden" name="updateIdRole" value="<?php  echo $resultsId['id_role']; ?>">
                    <input type="text" name="updateNomRole" value="<?php  echo $resultsId['nom_role']; ?>">
                    <input type="submit" name="updateRole" value="Update Role">
                </form>
                <?php
                if (isset($_POST["updateRole"])){
                    $updateIdRole = $_POST["updateIdRole"];
                    $updateNomRole = $_POST["updateNomRole"];
                    $sqlUpdate = "UPDATE `role` SET `nom_role`='$updateNomRole' WHERE id_role = $updateIdRole";

                    $bdd->query($sqlUpdate);
                    echo "Données modifiées";
                }
            }
            // supprimer données role
                if (isset($_GET['type']) && $_GET['type'] == "supprimer") {
                    if (isset($_POST["id_role"])) {
                        $deleteIdRole = $_POST["id_role"];
                        $sqlDelete = "DELETE FROM `role` WHERE id_role = $deleteIdRole";

                        $bdd->query($sqlDelete);
                        echo "Données supprimées";
                    }
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
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php foreach ($resultsCentre as $value) : ?>
                                <tr>
                                    <td><?= $value['id_centre']; ?></td>
                                    <td><?= $value['ville_centre']; ?></td>
                                    <td><?= $value['adresse_centre']; ?></td>
                                    <td><?= $value['code_postal_centre']; ?></td>
                                    <td><a href="?page=centre&type=modifier&id=<?= $value['id_centre']; ?>"><button>Modifier</button></a></td>
                                    <td>
                                        <form method="POST" action="?page=centre&type=supprimer">
                                        <input type="hidden" name="id_centre" value="<?= $value['id_centre']; ?>">
                                        <button type="submit">Supprimer</button>
                                    </form>
                                    </td>
                                </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php
        // ajouter un centre
            if (isset($_POST['submitCentre'])){
                $villeCentre = $_POST['villeCentre'];
                $adresseCentre = $_POST['adresseCentre'];
                $codePostalCentre = $_POST['codePostalCentre'];

                $sql = "INSERT INTO `centres` (`ville_centre`, `adresse_centre`, `code_postal_centre`) VALUES (?, ?, ?)";
                $stmt = $bdd->prepare($sql);
                $stmt->execute([$villeCentre, $adresseCentre, $codePostalCentre]);
                echo "Données ajoutées dans la BDD";
            }
        // modifier données centre
            if (isset($_GET['type']) && $_GET['type'] == "modifier") {

                $id = $_GET["id"];
                $sqlIdCentre = "SELECT * FROM centres WHERE id_centre = $id";
                $requeteIdCentre = $bdd->query($sqlIdCentre);
                $resultsIdCentre = $requeteIdCentre->fetch(PDO::FETCH_ASSOC);
                ?>
                <form method="POST">
                    <input type="hidden" name="updateIdCentre" value="<?php echo $resultsIdCentre['id_centre']; ?>">
                    <input type="text" name="updateVilleCentre" value="<?php echo $resultsIdCentre['ville_centre']; ?>">
                    <input type="text" name="updateAdresseCentre" value="<?php echo $resultsIdCentre['adresse_centre']; ?>">
                    <input type="text" name="updateCodePostalCentre" value="<?php echo $resultsIdCentre['code_postal_centre']; ?>">
                    <input type="submit" name="updateCentre" value="Update Centre">
                </form>
                <?php
                    if (isset($_POST["updateCentre"])) {
                        $updateIdCentre = $_POST["updateIdCentre"];
                        $updateVilleCentre = $_POST["updateVilleCentre"];
                        $updateAdresseCentre = $_POST["updateAdresseCentre"];
                        $updateCodePostalCentre = $_POST["updateCodePostalCentre"];
                        $sqlUpdate = "UPDATE `centres` SET `ville_centre`=?, `adresse_centre`=?, `code_postal_centre`=? WHERE `id_centre`=?";
                        $stmt = $bdd->prepare($sqlUpdate);
                        $stmt->execute([$updateVilleCentre, $updateAdresseCentre, $updateCodePostalCentre, $updateIdCentre]);

                        echo "Données modifiées";
                    }
                }
        // supprimer données centre
                if (isset($_GET['type']) && $_GET['type'] == "supprimer") {
                    if (isset($_POST["id_centre"])) {
                        $deleteIdCentre = $_POST["id_centre"];
                        $sqlDeleteCentre = "DELETE FROM `centres` WHERE id_centre = $deleteIdCentre";

                        $bdd->query($sqlDeleteCentre);
                        echo "Données supprimées";
                    }
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
                            <th>Modfier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultsFormation as $value) : ?>
                            <tr>
                                <td><?= $value['id_formation']; ?></td>
                                <td><?= $value['nom_formation']; ?></td>
                                <td><?= $value['duree_formation']; ?></td>
                                <td><?= $value['niveau_sortie_formation']; ?></td>
                                <td><?= $value['description']; ?></td>
                                <td><a href="?page=formation&type=modifier&id=<?= $value['id_formation']; ?>"><button>Modifier</button></a></td>
                                <td>
                                    <form method="POST" action="?page=formation&type=supprimer">
                                        <input type="hidden" name="id_formation" value="<?= $value['id_formation']; ?>">
                                        <button type="submit">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php
            // ajouter données formation
                if (isset($_POST['submitFormation'])){
                    $nomFormation = $_POST['nomFormation'];
                    $dureeFormation = $_POST['dureeFormation'];
                    $niveauSortieFormation = $_POST['niveauSortieFormation'];
                    $descriptionFormation = $_POST['descriptionFormation'];

                    $sql = "INSERT INTO `formations`(`nom_formation`, `duree_formation`, `niveau_sortie_formation`, `description`) VALUES ('$nomFormation','$dureeFormation','$niveauSortieFormation','$descriptionFormation')";
                    $bdd->query($sql);
                    echo "Données ajoutées dans la BDD";
                }
            // modifier données formation
                
                if (isset($_GET['type']) && $_GET['type'] == "modifier") {
                    $id = $_GET["id"];
                    $sqlIdFormation = "SELECT * FROM formations WHERE id_formation = ?";
                    $stmtIdFormation = $bdd->prepare($sqlIdFormation);
                    $stmtIdFormation->execute([$id]);
                    $resultsIdFormation = $stmtIdFormation->fetch(PDO::FETCH_ASSOC);
                ?>
                    <form method="POST">
                        <input type="hidden" name="updateIdFormation" value="<?= $resultsIdFormation['id_formation']; ?>">
                        <input type="text" name="updateNomFormation" value="<?= $resultsIdFormation['nom_formation']; ?>">
                        <input type="text" name="updateDureeFormation" value="<?= $resultsIdFormation['duree_formation']; ?>">
                        <input type="text" name="updateNiveauFormation" value="<?= $resultsIdFormation['niveau_sortie_formation']; ?>">
                        <input type="text" name="updateDescriptionFormation" value="<?= $resultsIdFormation['description']; ?>">
                        <input type="submit" name="updateFormation" value="Update Formation">
                    </form>

                <?php
                    if (isset($_POST["updateFormation"])) {
                        $updateIdFormation = $_POST["updateIdFormation"];
                        $updateNomFormation = $_POST["updateNomFormation"];
                        $updateDureeFormation = $_POST["updateDureeFormation"];
                        $updateNiveauFormation = $_POST["updateNiveauFormation"];
                        $updateDescriptionFormation = $_POST["updateDescriptionFormation"];

                        $sqlUpdate = "UPDATE `formations` SET `nom_formation`=?, `duree_formation`=?, `niveau_sortie_formation`=?, `description`=? WHERE `id_formation`=?";
                        $stmtUpdate = $bdd->prepare($sqlUpdate);
                        $stmtUpdate->execute([$updateNomFormation, $updateDureeFormation, $updateNiveauFormation, $updateDescriptionFormation, $updateIdFormation]);

                        echo "Données modifiées";
                    }
                }
            // supprimer données formation
                if (isset($_GET['type']) && $_GET['type'] == "supprimer") {
                    if (isset($_POST["id_formation"])) {
                        $deleteIdFormation = $_POST["id_formation"];
                        $sqlDeleteFormation = "DELETE FROM `formations` WHERE id_formation = $deleteIdFormation";

                        $bdd->query($sqlDeleteFormation);
                        echo "Données supprimées";
                    }
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
                            <th>Role</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultsPedagogie as $value) : ?>
                            <tr>
                                <td><?= $value['id_pedagogie']; ?></td>
                                <td><?= $value['nom_pedagogie']; ?></td>
                                <td><?= $value['prenom_pedagogie']; ?></td>
                                <td><?= $value['mail_pedagogie']; ?></td>
                                <td><?= $value['num_pedagogie']; ?></td>
                                <td><?= $value['id_role'] . ' - ' . $value['nom_role']; ?></td>
                                <td><a href="?page=pedagogie&type=modifier&id=<?= $value['id_pedagogie']; ?>"><button>Modifier</button></a></td>
                                <td>
                                    <form method="POST" action="?page=pedagogie&type=supprimer">
                                        <input type="hidden" name="id_pedagogie" value="<?= $value['id_pedagogie']; ?>">
                                        <button type="submit">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php
            // ajouter données pedagogie
                if (isset($_POST['submitPedagogie'])){
                        $nomPedagogie = $_POST['nomPedagogie'];
                        $prenomPedagogie = $_POST['prenomPedagogie'];
                        $mailPedagogie = $_POST['mailPedagogie'];
                        $numPedagogie = $_POST['numPedagogie'];
                        $idPedagogie = $_POST['idPedagogie'];
                        $sql = "INSERT INTO `pedagogie`(`nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`, `id_role`) VALUES ('$nomPedagogie','$prenomPedagogie','$mailPedagogie','$numPedagogie','$idPedagogie')";
                        $bdd->query($sql);
                        echo "Données ajoutées dans la BDD";
                }
            // modifier les données pedagogie
                if (isset($_GET['type']) && $_GET['type'] == "modifier") {
                    $id = $_GET["id"];
                    $sqlIdPedagogie = "SELECT * FROM pedagogie WHERE id_pedagogie = ?";
                    $stmtIdPedagogie = $bdd->prepare($sqlIdPedagogie);
                    $stmtIdPedagogie->execute([$id]);
                    $resultsIdPedagogie = $stmtIdPedagogie->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <form method="POST">
                        <input type="hidden" name="updateIdPedagogie" value="<?= $resultsIdPedagogie['id_pedagogie']; ?>">
                        <input type="text" name="updateNomPedagogie" value="<?= $resultsIdPedagogie['nom_pedagogie']; ?>">
                        <input type="text" name="updatePrenomPedagogie" value="<?= $resultsIdPedagogie['prenom_pedagogie']; ?>">
                        <input type="text" name="updateMailPedagogie" value="<?= $resultsIdPedagogie['mail_pedagogie']; ?>">
                        <input type="text" name="updateNumPedagogie" value="<?= $resultsIdPedagogie['num_pedagogie']; ?>">
                        <select name="updateIdRole" id="">
                        <?php 
                                foreach( $resultsRole as $value ){             
                                        echo '<option value="' . $value['id_role'] .  '">' . $value['id_role'] . ' - ' . $value['nom_role'] . '</option>';   
                                }
                            ?>
                        </select>
                        <input type="submit" name="updatePedagogie" value="Update Pedagogie">
                    </form>

                    <?php
                    if (isset($_POST["updatePedagogie"])) {
                        $updateIdPedagogie = $_POST["updateIdPedagogie"];
                        $updateNomPedagogie = $_POST["updateNomPedagogie"];
                        $updatePrenomPedagogie = $_POST["updatePrenomPedagogie"];
                        $updateMailPedagogie = $_POST["updateMailPedagogie"];
                        $updateNumPedagogie = $_POST["updateNumPedagogie"];
                        $updateIdRole = $_POST["updateIdRole"];

                        $sqlUpdatePedagogie = "UPDATE `pedagogie` SET `nom_pedagogie`=?, `prenom_pedagogie`=?, `mail_pedagogie`=?, `num_pedagogie`=?, `id_role`=? WHERE `id_pedagogie`=?";
                        $stmtUpdatePedagogie = $bdd->prepare($sqlUpdatePedagogie);
                        $stmtUpdatePedagogie->execute([$updateNomPedagogie, $updatePrenomPedagogie, $updateMailPedagogie, $updateNumPedagogie, $updateIdRole, $updateIdPedagogie]);
                        echo "Données modifiées";
                    }
                }    

            // supprimer données pedagogie
                if (isset($_GET['type']) && $_GET['type'] == "supprimer") {
                    if (isset($_POST["id_pedagogie"])) {
                        $deleteIdPedagogie = $_POST["id_pedagogie"];
                        $sqlDeletePedagogie = "DELETE FROM `pedagogie` WHERE id_pedagogie = $deleteIdPedagogie";

                        $bdd->query($sqlDeletePedagogie);
                        echo "Données supprimées";
                    }
                }
            }
        
// SESSION
        if (isset($_GET["page"])&& $_GET["page"]=="session"){

            $sqlSession = "SELECT
                            `session`.`id_session`,
                            `session`.`nom_session`,
                            `session`.`date_debut`,
                            `session`.`id_pedagogie`,
                            `pedagogie`.`nom_pedagogie`,
                            `pedagogie`.`prenom_pedagogie`,
                            `session`.`id_formation`,
                            `formations`.`nom_formation`,
                            `session`.`id_centre`,
                            `centres`.`ville_centre`
                        FROM
                            `session`
                        LEFT JOIN
                            `formations` ON `session`.`id_formation` = `formations`.`id_formation`
                        LEFT JOIN
                            `pedagogie` ON `session`.`id_pedagogie` = `pedagogie`.`id_pedagogie`
                        LEFT JOIN
                            `centres` ON `session`.`id_centre` = `centres`.`id_centre`;

            ";
            $requeteSession = $bdd->query($sqlSession);
            $resultsSession = $requeteSession->fetchAll(PDO::FETCH_ASSOC);

            $sqlPedagogie = "SELECT * FROM pedagogie";
            $requetePedagogie = $bdd->query($sqlPedagogie);
            $resultsPedagogie = $requetePedagogie->fetchAll(PDO::FETCH_ASSOC);
             
            $sqlFormation = "SELECT * FROM formations";
            $requeteFormation = $bdd->query($sqlFormation);
            $resultsFormation = $requeteFormation->fetchAll(PDO::FETCH_ASSOC);

            $sqlCentre = "SELECT * FROM centres";
            $requeteCentre = $bdd->query($sqlCentre);
            $resultsCentre = $requeteCentre->fetchAll(PDO::FETCH_ASSOC);

            $sqlLocaliser = "SELECT `id_formation`, `id_centre` FROM `localiser` WHERE 1";
            $requeteLocaliser = $bdd->query($sqlLocaliser);
            $resultsLocaliser = $requeteLocaliser->fetchAll(PDO::FETCH_ASSOC);

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
            <table border ="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom de la Session</th>
                            <th>Date du début</th>
                            <th>Encadrant Pédagogique</th>
                            <th>Formation</th>
                            <th>Centre</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                         <?php foreach ($resultsSession as $data) : ?>
                            <tr>
                                <td><?= $data['id_session']; ?></td>
                                <td><?= $data['nom_session']; ?></td>
                                <td><?= $data['date_debut']; ?></td>
                                <td><?= $data['id_pedagogie'] . ' - ' . $data['nom_pedagogie'] . ' ' . $data['prenom_pedagogie']; ?></td>
                                <td><?= $data['id_formation'] . ' - ' . $data['nom_formation']; ?></td>
                                <td><?= $data['id_centre'] . ' - ' . $data['ville_centre']; ?></td>
                                <td><a href="?page=session&type=modifier&id=<?= $data['id_session']; ?>"><button>Modifier</button></a></td>
                                <td>
                                    <form method="POST" action="?page=session&type=supprimer">
                                        <input type="hidden" name="id_session" value="<?= $data['id_session']; ?>">
                                        <input type="hidden" name="deleteFormationLocaliser" value="<?= $data['id_formation']; ?>">
                                        <input type="hidden" name="deleteCentreLocaliser" value="<?= $data['id_centre']; ?>">
                                        <button type="submit">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php
            // ajouter données session
                if (isset($_POST['submitSession'])){
                    $dateSession = $_POST['dateSession']; 
                    $nomSession = $_POST['nomSession'];
                    $idSession1 = $_POST['idSession1'];
                    $idSession2 = $_POST['idSession2'];
                    $idSession3 = $_POST['idSession3'];

                    $sql = "INSERT INTO `session`(`date_debut`, `nom_session` , `id_pedagogie`, `id_formation`,`id_centre`) VALUES ('$dateSession','$nomSession','$idSession1','$idSession2' ,'$idSession3')";
                    $bdd->query($sql);
                    $sqlLocaliser = "INSERT INTO `localiser`(`id_formation`, `id_centre`) VALUES ('$idSession2','$idSession3')"; 
                    $bdd->query($sqlLocaliser);
                    echo "Données ajoutées dans la BDD";
                }
            // modifier données session
                if (isset($_GET['type']) && $_GET['type'] == "modifier") {
                    $id = $_GET["id"];
                    $sqlIdSession = "SELECT * FROM session WHERE id_session = ?";
                    $stmtIdSession = $bdd->prepare($sqlIdSession);
                    $stmtIdSession->execute([$id]);
                    $resultsIdSession = $stmtIdSession->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <form method="POST">
                        <input type="hidden" name="updateIdSession" value="<?= $resultsIdSession['id_session']; ?>">
                        <input type="text" name="updateNomSession" value="<?= $resultsIdSession['nom_session']; ?>">
                        <input type="text" name="updateDateDebut" value="<?= $resultsIdSession['date_debut']; ?>">
                        <select name="updateIdPedagogie" id="">
                            <?php 
                            foreach($resultsPedagogie as $value) {             
                                echo '<option value="' . $value['id_pedagogie'] .  '">' . $value['id_pedagogie'] . ' - ' . $value['nom_pedagogie'] . '</option>';   
                            }
                            ?>
                        </select>
                        <select name="updateIdFormation" id="">
                            <?php 
                            foreach($resultsFormation as $value) {             
                                echo '<option value="' . $value['id_formation'] .  '">' . $value['id_formation'] . ' - ' . $value['nom_formation'] . '</option>';   
                            }
                            ?>
                        </select>
                        <select name="updateIdCentre" id="">
                            <?php 
                            foreach($resultsCentre as $value) {             
                                echo '<option value="' . $value['id_centre'] .  '">' . $value['id_centre'] . ' - ' . $value['ville_centre'] . '</option>';   
                            }
                            ?>
                        </select>                       
                        <input type="submit" name="updateSession" value="Update Session">
                    </form>

                <?php
                    if (isset($_POST["updateSession"])) {
                        $updateIdSession = $_POST["updateIdSession"];
                        $updateNomSession = $_POST["updateNomSession"];
                        $updateDateDebut = $_POST["updateDateDebut"];
                        $updateIdPedagogie = $_POST["updateIdPedagogie"];
                        $updateIdFormation = $_POST["updateIdFormation"];
                        $updateIdCentre = $_POST["updateIdCentre"];

                        $sqlUpdateSession = "UPDATE `session` SET `nom_session`=?, `date_debut`=?, `id_pedagogie`=?, `id_formation`=?, `id_centre`=? WHERE `id_session`=?";
                        $stmtUpdateSession = $bdd->prepare($sqlUpdateSession);
                        $stmtUpdateSession->execute([$updateNomSession, $updateDateDebut, $updateIdPedagogie, $updateIdFormation, $updateIdCentre, $updateIdSession]);
                        $sqlUpdateLocaliser = "UPDATE `localiser` SET `id_formation`='$updateIdFormation',`id_centre`='$updateIdCentre' WHERE 1"; 
                        $bdd->query($sqlUpdateLocaliser);
                        echo "Données modifiées";
                    }
                }

            // supprimer données session
               if (isset($_GET['type']) && $_GET['type'] == "supprimer") {
                    if (isset($_POST["id_session"])) {
                        $deleteIdSession = $_POST["id_session"];
                        $sqlDeleteSession = "DELETE FROM `session` WHERE id_session = :id_session";
                        $stmtSession = $bdd->prepare($sqlDeleteSession);

                        $stmtSession->bindParam(':id_session', $deleteIdSession, PDO::PARAM_INT);

                        if ($stmtSession->execute()) {
                            echo "Données de session supprimées";
                        } else {
                            echo "Erreur lors de la suppression des données de session : " . $stmtSession->errorInfo()[2];
                        }
                        $stmtSession->closeCursor();
                    }

                    // Supprimer les données de localiser
                    if (isset($_POST["deleteFormationLocaliser"]) && isset($_POST["deleteCentreLocaliser"])) {
                        $deleteFormationLocaliser = $_POST["deleteFormationLocaliser"];
                        $deleteCentreLocaliser = $_POST["deleteCentreLocaliser"];

                        $sqlDeleteLocaliser = "DELETE FROM `localiser` WHERE `id_formation` = :id_formation AND `id_centre` = :id_centre";
                        $stmtLocaliser = $bdd->prepare($sqlDeleteLocaliser);

                        $stmtLocaliser->bindParam(':id_formation', $deleteFormationLocaliser, PDO::PARAM_INT);
                        $stmtLocaliser->bindParam(':id_centre', $deleteCentreLocaliser, PDO::PARAM_INT);

                        if ($stmtLocaliser->execute()) {
                            echo "Données de localiser supprimées";
                        } else {
                            echo "Erreur lors de la suppression des données de localiser : " . $stmtLocaliser->errorInfo()[2];
                        }
                        $stmtLocaliser->closeCursor();
                    }
                }

           
   } 
     

// APPRENANTS
         if (isset($_GET["page"])&& $_GET["page"]=="apprenant"){
            $sqlApprenants = "SELECT
                                    `apprenants`.`id_apprenant`,
                                    `apprenants`.`nom_apprenant`,
                                    `apprenants`.`prenom_apprenant`,
                                    `apprenants`.`mail_apprenant`,
                                    `apprenants`.`adresse_apprenant`,
                                    `apprenants`.`ville_apprenant`,
                                    `apprenants`.`code_postal_apprenant`,
                                    `apprenants`.`tel_apprenant`,
                                    `apprenants`.`date_naissance_apprenant`,
                                    `apprenants`.`niveau_apprenant`,
                                    `apprenants`.`num_PE_apprenant`,
                                    `apprenants`.`num_secu_apprenant`,
                                    `apprenants`.`rib_apprenant`,
                                    `apprenants`.`num_PE_apprenant`,
                                    `apprenants`.`id_role`,
                                    `apprenants`.`id_session`,
                                    `role`.`id_role`, 
                                    `role`.`nom_role`,
                                    `session`.`id_session`,
                                    `session`.`nom_session`
                                FROM
                                    `apprenants`
                                LEFT JOIN
                                    `role` ON `apprenants`.`id_role` = `role`.`id_role`
                                LEFT JOIN
                                    `session` ON `apprenants`.`id_session` = `session`.`id_session`;
                                ";
            $requeteApprenants = $bdd->query($sqlApprenants);
            $resultsApprenants = $requeteApprenants->fetchAll(PDO::FETCH_ASSOC);

            $sqlRole = "SELECT * FROM role";
            $requeteRole = $bdd->query($sqlRole);
            $resultsRole = $requeteRole->fetchAll(PDO::FETCH_ASSOC);

           $sqlSession = "SELECT `id_session`, `nom_session`, `date_debut`, `session`.`id_pedagogie`, `session`.`id_formation`, `session`.`id_centre`,
                `formations`.`nom_formation` 
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
                <table border ="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>Ville</th>
                            <th>Code Postal</th>
                            <th>Téléphone</th>
                            <th>Date de Naissance</th>
                            <th>Niveau</th>
                            <th>Numéro Pôle Emploi</th>
                            <th>Numéro Sécurité Sociale</th>
                            <th>RIB</th>
                            <th>Role</th>
                            <th>Session</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php foreach ($resultsApprenants as $apprenant) : ?>
                            <tr>
                                <td><?= $apprenant['id_apprenant']; ?></td>
                                <td><?= $apprenant['nom_apprenant']; ?></td>
                                <td><?= $apprenant['prenom_apprenant']; ?></td>
                                <td><?= $apprenant['mail_apprenant']; ?></td>
                                <td><?= $apprenant['adresse_apprenant']; ?></td>
                                <td><?= $apprenant['ville_apprenant']; ?></td>
                                <td><?= $apprenant['code_postal_apprenant']; ?></td>
                                <td><?= $apprenant['tel_apprenant']; ?></td>
                                <td><?= $apprenant['date_naissance_apprenant']; ?></td>
                                <td><?= $apprenant['niveau_apprenant']; ?></td>
                                <td><?= $apprenant['num_PE_apprenant']; ?></td>
                                <td><?= $apprenant['num_secu_apprenant']; ?></td>
                                <td><?= $apprenant['rib_apprenant']; ?></td>
                                <td><?= $apprenant['id_role'] . ' - ' . $apprenant['nom_role']; ?></td>                      
                                <td><?= $apprenant['id_session'] . ' - ' . $apprenant['nom_session']; ?></td>                     
                                <td><a href="?page=apprenant&type=modifier&id=<?= $apprenant['id_apprenant']; ?>"><button>Modifier</button></a></td>
                                <td>
                                    <form method="POST" action="?page=apprenant&type=supprimer">
                                        <input type="hidden" name="id_apprenant" value="<?= $apprenant['id_apprenant']; ?>">
                                        <button type="submit">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                            </tbody>
                    </table>     
            <?php
        // ajouter données apprenants
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

                $sql = "INSERT INTO `apprenants`(`nom_apprenant`, `prenom_apprenant`, `mail_apprenant`, `adresse_apprenant`, `ville_apprenant`, `code_postal_apprenant`, `tel_apprenant`, `date_naissance_apprenant`, `niveau_apprenant`, `num_PE_apprenant`, `num_secu_apprenant`, `rib_apprenant`, `id_role`, `id_session`) VALUES ('$nomApprenant','$prenomApprenant','$mailApprenant','$adresseApprenant',' $villeApprenant','$cpApprenant','$telApprenant','$dateNaissanceApprenant','$niveauApprenant','$numPEApprenant','$numSSApprenant','$ribApprenant','$idApprenant1','$idApprenant2')";
                $bdd->query($sql);
                echo "Données ajoutées dans la BDD";
            }
        // modifier données apprenants 

            if (isset($_GET['type']) && $_GET['type'] == "modifier") {
                $id = $_GET["id"];
                $sqlIdApprenant = "SELECT * FROM apprenants WHERE id_apprenant = ?";
                $stmtIdApprenant = $bdd->prepare($sqlIdApprenant);
                $stmtIdApprenant->execute([$id]);
                $resultsIdApprenant = $stmtIdApprenant->fetch(PDO::FETCH_ASSOC);
                ?>
                <form method="POST">
                    <input type="hidden" name="updateIdApprenant" value="<?= $resultsIdApprenant['id_apprenant']; ?>">
                    <input type="text" name="updateNomApprenant" value="<?= $resultsIdApprenant['nom_apprenant']; ?>">
                    <input type="text" name="updatePrenomApprenant" value="<?= $resultsIdApprenant['prenom_apprenant']; ?>">
                    <input type="text" name="updateMailApprenant" value="<?= $resultsIdApprenant['mail_apprenant']; ?>">
                    <input type="text" name="updateAdresseApprenant" value="<?= $resultsIdApprenant['adresse_apprenant']; ?>">
                    <input type="text" name="updateVilleApprenant" value="<?= $resultsIdApprenant['ville_apprenant']; ?>">
                    <input type="text" name="updateCodePostalApprenant" value="<?= $resultsIdApprenant['code_postal_apprenant']; ?>">
                    <input type="text" name="updateTelApprenant" value="<?= $resultsIdApprenant['tel_apprenant']; ?>">
                    <input type="date" name="updateDateNaissanceApprenant" value="<?= $resultsIdApprenant['date_naissance_apprenant']; ?>">
                    <input type="text" name="updateNiveauApprenant" value="<?= $resultsIdApprenant['niveau_apprenant']; ?>">
                    <input type="text" name="updateNumPeApprenant" value="<?= $resultsIdApprenant['num_PE_apprenant']; ?>">
                    <input type="text" name="updateNumSecuApprenant" value="<?= $resultsIdApprenant['num_secu_apprenant']; ?>">
                    <input type="text" name="updateRibApprenant" value="<?= $resultsIdApprenant['rib_apprenant']; ?>">
                    <select name="updateIdRole" id="">
                        <?php 
                        foreach($resultsRole as $value) {             
                            echo '<option value="' . $value['id_role'] .  '">' . $value['id_role'] . ' - ' . $value['nom_role'] . '</option>';   
                        }
                        ?>
                    </select>
                    <select name="updateIdSession" id="">
                        <?php 
                        foreach($resultsSession as $value) {             
                            echo '<option value="' . $value['id_session'] .  '">' . $value['id_session'] . ' - ' . $value['nom_session'] . '</option>';   
                        }
                        ?>
                    </select>
                    <input type="submit" name="updateApprenant" value="Update Apprenant">
                </form>

                <?php
                    if (isset($_POST["updateApprenant"])) {
                        $updateIdApprenant = $_POST["updateIdApprenant"];
                        $updateNomApprenant = $_POST["updateNomApprenant"];
                        $updatePrenomApprenant = $_POST["updatePrenomApprenant"];
                        $updateMailApprenant = $_POST["updateMailApprenant"];
                        $updateAdresseApprenant = $_POST["updateAdresseApprenant"];
                        $updateVilleApprenant = $_POST["updateVilleApprenant"];
                        $updateCodePostalApprenant = $_POST["updateCodePostalApprenant"];
                        $updateTelApprenant = $_POST["updateTelApprenant"];
                        $updateDateNaissanceApprenant = $_POST["updateDateNaissanceApprenant"];
                        $updateNiveauApprenant = $_POST["updateNiveauApprenant"];
                        $updateNumPeApprenant = $_POST["updateNumPeApprenant"];
                        $updateNumSecuApprenant = $_POST["updateNumSecuApprenant"];
                        $updateRibApprenant = $_POST["updateRibApprenant"];
                        $updateIdRole = $_POST["updateIdRole"];
                        $updateIdSession = $_POST["updateIdSession"];
                        

                        $sqlUpdateApprenant = "UPDATE `apprenants` SET `nom_apprenant`=?, `prenom_apprenant`=?, `mail_apprenant`=?, `adresse_apprenant`=?, `ville_apprenant`=?, `code_postal_apprenant`=?, `tel_apprenant`=?, `date_naissance_apprenant`=?, `niveau_apprenant`=?, `num_PE_apprenant`=?, `num_secu_apprenant`=?, `rib_apprenant`=?, `id_role`=?, `id_session`=? WHERE `id_apprenant`=?";
                        $stmtUpdateApprenant = $bdd->prepare($sqlUpdateApprenant);
                        $stmtUpdateApprenant->execute([$updateNomApprenant, $updatePrenomApprenant, $updateMailApprenant, $updateAdresseApprenant, $updateVilleApprenant, $updateCodePostalApprenant, $updateTelApprenant, $updateDateNaissanceApprenant, $updateNiveauApprenant, $updateNumPeApprenant, $updateNumSecuApprenant, $updateRibApprenant, $updateIdRole, $updateIdSession, $updateIdApprenant]);

                        echo "Données modifiées";
                    }
            }
        // supprimer données apprenants
                if (isset($_GET['type']) && $_GET['type'] == "supprimer") {
                    if (isset($_POST["id_apprenant"])) {
                        $deleteIdApprenant= $_POST["id_apprenant"];
                        $sqlDeleteApprenant= "DELETE FROM `apprenants` WHERE id_apprenant = $deleteIdApprenant";

                        $bdd->query($sqlDeleteApprenant);
                        echo "Données supprimées";
                    }
                }    
        }

// AFFECTER
        if (isset($_GET["page"])&& $_GET["page"]=="affecter"){
                $sqlPedagogie = "SELECT * FROM pedagogie";
                $requetePedagogie = $bdd->query($sqlPedagogie);
                $resultsPedagogie = $requetePedagogie->fetchAll(PDO::FETCH_ASSOC);

                $sqlCentres = "SELECT * FROM centres";
                $requeteCentres = $bdd->query($sqlCentres);
                $resultsCentres = $requeteCentres->fetchAll(PDO::FETCH_ASSOC);

                $sqlAffecter = "SELECT `affecter`.`id_pedagogie`, `affecter`.`id_centre`, `pedagogie`.`id_pedagogie`, `pedagogie`.`nom_pedagogie`, `centres`.`id_centre`, `centres`.`ville_centre` FROM `affecter` LEFT JOIN `pedagogie` ON `affecter`.`id_pedagogie` = `pedagogie`.`id_pedagogie` LEFT JOIN `centres` ON `affecter`.`id_centre` = `centres`.`id_centre`;";
                $requeteAffecter = $bdd->query($sqlAffecter);
                $resultsAffecter = $requeteAffecter->fetchAll(PDO::FETCH_ASSOC);

            ?>

                <form method="POST">
                    <h2>Affectation</h2>
                        <select name="affecterPedagogie" id="">
                            <?php 
                            foreach($resultsPedagogie as $value) {             
                                echo '<option value="' . $value['id_pedagogie'] .  '">' . $value['id_pedagogie'] . ' - ' . $value['nom_pedagogie'] . '</option>';   
                            }
                            ?>
                        </select>
                        <select name="affecterCentres" id="">
                            <?php 
                            foreach($resultsCentres as $value) {             
                                echo '<option value="' . $value['id_centre'] .  '">' . $value['id_centre'] . ' - ' . $value['ville_centre'] . '</option>';   
                            }
                            ?>
                        </select>
                    <input type="submit" name="submitAffecter" value="enregister">
                </form>
                <table border ="1">
                    <thead>
                        <tr>
                            <th>Équipe Pédagogique</th>
                            <th>Centre</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultsAffecter as $value): ?>
                        <tr>
                                <td><?= $value['id_pedagogie'] . ' - ' . $value['nom_pedagogie']; ?></td>

                                <td><?= $value['id_centre'] . ' - ' . $value['ville_centre']; ?></td>
                                <td>
                                    <form method="POST" action="?page=affecter&type=supprimer">
                                        <input type="hidden" name="deletePedagogieAffecter" value="<?= $value['id_pedagogie']; ?>">
                                        <input type="hidden" name="deleteCentreAffecter" value="<?= $value['id_centre']; ?>">
                                        <button type="submit">Supprimer</button>
                                    </form>
                                </td> 
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
               
            <?php
            // affecter
            if (isset($_POST['submitAffecter'])){
                $affecterPedagogie = $_POST['affecterPedagogie'];
                $affecterCentres = $_POST['affecterCentres'];
                $sql = "INSERT INTO `affecter`(`id_pedagogie`, `id_centre`) VALUES ('$affecterPedagogie','$affecterCentres')";
                $bdd->query($sql);
                echo "Données ajoutées dans la BDD";
            }
            // supprimer données affecter
            if (isset($_GET['type']) && $_GET['type'] == "supprimer") {
                    if (isset($_POST["deletePedagogieAffecter"]) && isset($_POST["deleteCentreAffecter"])) {
                        $deletePedagogieAffecter = $_POST["deletePedagogieAffecter"];
                        $deleteCentreAffecter = $_POST["deleteCentreAffecter"];

                        
                        $sqlDeleteAffecter = "DELETE FROM `affecter` WHERE `id_pedagogie` = :id_pedagogie AND `id_centre` = :id_centre";
                        $stmt = $bdd->prepare($sqlDeleteAffecter);

                        $stmt->bindParam(':id_pedagogie', $deletePedagogieAffecter, PDO::PARAM_INT);
                        $stmt->bindParam(':id_centre', $deleteCentreAffecter, PDO::PARAM_INT);

                        if ($stmt->execute()) {
                            echo "Données supprimées";
                        } else {
                            echo "Erreur lors de la suppression des données : " . $stmt->errorInfo()[2];
                        }

                    
                    }
            } 
        }        
?>


</div>

 <script src="script.js"></script>
</body>
</html>
<!-- // SESSION -->
<?php
    
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
                        if ($value['id_role'] == 3) {
                            echo '<option value="' . $value['id_pedagogie'] . '">' . $value['id_pedagogie'] . ' - ' . $value['nom_pedagogie'] . ' ' . $value['prenom_pedagogie'] . '</option>';
                        }
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
                    $dateSession = htmlspecialchars($_POST['dateSession']);
                    $nomSession = htmlspecialchars($_POST['nomSession']);
                    $idSession1 = $_POST['idSession1'];
                    $idSession2 = $_POST['idSession2'];
                    $idSession3 = $_POST['idSession3'];

                    $sql = "INSERT INTO `session`(`date_debut`, `nom_session`, `id_pedagogie`, `id_formation`, `id_centre`) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $bdd->prepare($sql);
                    $stmt->execute([$dateSession, $nomSession, $idSession1, $idSession2, $idSession3]);

                    $sqlLocaliser = "INSERT INTO `localiser`(`id_formation`, `id_centre`) VALUES (?, ?)";
                    $stmtLocaliser = $bdd->prepare($sqlLocaliser);
                    $stmtLocaliser->execute([$idSession2, $idSession3]);
                    
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
                        <input type="text" name="updateNomSession" value="<?= htmlspecialchars($resultsIdSession['nom_session']); ?>">
                        <input type="text" name="updateDateDebut" value="<?= htmlspecialchars($resultsIdSession['date_debut']); ?>">
                        <select name="updateIdPedagogie" id="">
                            <?php 
                            foreach ($resultsPedagogie as $value) {
                                if ($value['id_role'] == 3) {
                                    echo '<option value="' . $value['id_pedagogie'] . '">' . $value['id_pedagogie'] . ' - ' . $value['nom_pedagogie'] . ' ' . $value['prenom_pedagogie'] . '</option>';
                                }
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
                        $updateNomSession = htmlspecialchars($_POST["updateNomSession"]); // Protection contre les attaques XSS
                        $updateDateDebut = htmlspecialchars($_POST["updateDateDebut"]);
                        $updateIdPedagogie = $_POST["updateIdPedagogie"];
                        $updateIdFormation = $_POST["updateIdFormation"];
                        $updateIdCentre = $_POST["updateIdCentre"];

                        // Mise à jour de la table 'session'
                        $sqlUpdateSession = "UPDATE `session` SET `nom_session`=?, `date_debut`=?, `id_pedagogie`=?, `id_formation`=?, `id_centre`=? WHERE `id_session`=?";
                        $stmtUpdateSession = $bdd->prepare($sqlUpdateSession);
                        $stmtUpdateSession->execute([$updateNomSession, $updateDateDebut, $updateIdPedagogie, $updateIdFormation, $updateIdCentre, $updateIdSession]);

                        // Mise à jour de la table 'localiser'
                        $sqlUpdateLocaliser = "UPDATE `localiser` SET `id_formation`=?, `id_centre`=? WHERE `id_formation`=? AND `id_centre`=?";
                        $stmtUpdateLocaliser = $bdd->prepare($sqlUpdateLocaliser);
                        $stmtUpdateLocaliser->execute([$updateIdFormation, $updateIdCentre, $resultsIdSession['id_formation'], $resultsIdSession['id_centre']]);

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
?>
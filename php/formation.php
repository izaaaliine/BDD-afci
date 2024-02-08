<!-- // FORMATIONS -->
<?php

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
                    $nomFormation = htmlspecialchars($_POST['nomFormation']);
                    $dureeFormation = htmlspecialchars($_POST['dureeFormation']); 
                    $niveauSortieFormation = htmlspecialchars($_POST['niveauSortieFormation']); 
                    $descriptionFormation = htmlspecialchars($_POST['descriptionFormation']); 

                     $sql = "INSERT INTO `formations`(`nom_formation`, `duree_formation`, `niveau_sortie_formation`, `description`) VALUES (:nomFormation, :dureeFormation, :niveauSortieFormation, :descriptionFormation)";
                    $stmt = $bdd->prepare($sql);
                    $stmt->bindParam(':nomFormation', $nomFormation, PDO::PARAM_STR);
                    $stmt->bindParam(':dureeFormation', $dureeFormation, PDO::PARAM_STR);
                    $stmt->bindParam(':niveauSortieFormation', $niveauSortieFormation, PDO::PARAM_STR);
                    $stmt->bindParam(':descriptionFormation', $descriptionFormation, PDO::PARAM_STR);
                    $stmt->execute();
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
                       <input type="text" name="updateNomFormation" value="<?= htmlspecialchars($resultsIdFormation['nom_formation']); ?>">
                        <input type="text" name="updateDureeFormation" value="<?= htmlspecialchars($resultsIdFormation['duree_formation']); ?>">
                        <input type="text" name="updateNiveauFormation" value="<?= htmlspecialchars($resultsIdFormation['niveau_sortie_formation']); ?>">
                        <input type="text" name="updateDescriptionFormation" value="<?= htmlspecialchars($resultsIdFormation['description']); ?>">

                        <input type="submit" name="updateFormation" value="Update Formation">
                    </form>

                <?php
                    if (isset($_POST["updateFormation"])) {
                        $updateIdFormation = $_POST["updateIdFormation"];
                        $updateNomFormation = htmlspecialchars($_POST["updateNomFormation"]); 
                        $updateDureeFormation = htmlspecialchars($_POST["updateDureeFormation"]); 
                        $updateNiveauFormation = htmlspecialchars($_POST["updateNiveauFormation"]); 
                        $updateDescriptionFormation = htmlspecialchars($_POST["updateDescriptionFormation"]);


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
                        $sqlDeleteFormation = "DELETE FROM `formations` WHERE id_formation = :deleteIdFormation";
                        $stmtDeleteFormation = $bdd->prepare($sqlDeleteFormation);
                        $stmtDeleteFormation->bindParam(':deleteIdFormation', $deleteIdFormation, PDO::PARAM_INT);
                        $stmtDeleteFormation->execute();
                        echo "Données supprimées";
                    }
                }
        }

?>
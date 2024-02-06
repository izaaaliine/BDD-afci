<!-- // AFFECTER -->
<?php
        if (isset($_GET["page"])&& $_GET["page"]=="affecter"){
                $sqlPedagogie = "SELECT * FROM pedagogie";
                $requetePedagogie = $bdd->query($sqlPedagogie);
                $resultsPedagogie = $requetePedagogie->fetchAll(PDO::FETCH_ASSOC);

                $sqlCentres = "SELECT * FROM centres";
                $requeteCentres = $bdd->query($sqlCentres);
                $resultsCentres = $requeteCentres->fetchAll(PDO::FETCH_ASSOC);

                $sqlAffecter = "SELECT `affecter`.`id_pedagogie`, `affecter`.`id_centre`, `pedagogie`.`id_pedagogie`, `pedagogie`.`nom_pedagogie`, `centres`.`id_centre`, `centres`.`ville_centre` 
                FROM `affecter` 
                LEFT JOIN `pedagogie` ON `affecter`.`id_pedagogie` = `pedagogie`.`id_pedagogie` 
                LEFT JOIN `centres` ON `affecter`.`id_centre` = `centres`.`id_centre`;";
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
                $sql = "INSERT INTO `affecter`(`id_pedagogie`, `id_centre`) VALUES (?, ?)";
                $stmt = $bdd->prepare($sql);
                $stmt->execute([$affecterPedagogie, $affecterCentres]);
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
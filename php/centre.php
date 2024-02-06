<!-- CENTRES -->
<?php
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
        ?>
<!-- // PEDAGOGIE -->
<?php
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
                        $sql = "INSERT INTO `pedagogie`(`nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`, `id_role`) VALUES (:nomPedagogie, :prenomPedagogie, :mailPedagogie, :numPedagogie, :idPedagogie)";
                        $stmt = $bdd->prepare($sql);
                        $stmt->bindParam(':nomPedagogie', $nomPedagogie, PDO::PARAM_STR);
                        $stmt->bindParam(':prenomPedagogie', $prenomPedagogie, PDO::PARAM_STR);
                        $stmt->bindParam(':mailPedagogie', $mailPedagogie, PDO::PARAM_STR);
                        $stmt->bindParam(':numPedagogie', $numPedagogie, PDO::PARAM_STR);
                        $stmt->bindParam(':idPedagogie', $idPedagogie, PDO::PARAM_INT);
                        $stmt->execute();
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
                        $sqlDeletePedagogie = "DELETE FROM `pedagogie` WHERE id_pedagogie = ?";
                        $stmtDeletePedagogie = $bdd->prepare($sqlDeletePedagogie);
                        $stmtDeletePedagogie->execute([$deleteIdPedagogie]);
                        
                        echo "Données supprimées";
                    }
                }
            }
?>
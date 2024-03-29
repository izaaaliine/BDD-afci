<!-- ROLES -->
<?php
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
                $nomRole = htmlspecialchars($_POST['nomRole']);
                $sql = "INSERT INTO `role`(`nom_role`) VALUES (:nomRole)";
                $stmt = $bdd->prepare($sql);
                $stmt->bindParam(':nomRole', $nomRole, PDO::PARAM_STR);
                $stmt->execute();
                echo "Données ajoutées dans la BDD";
            }
            // modifier données role
            if (isset($_GET['type']) && $_GET['type'] == "modifier"){

                $id = $_GET["id"];
                $sqlId = "SELECT * FROM role WHERE id_role = :id";
                $stmtId = $bdd->prepare($sqlId);
                $stmtId->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtId->execute();
                $resultsId = $stmtId->fetch(PDO::FETCH_ASSOC);
                ?>
                <form method="POST">
                    <input type="hidden" name="updateIdRole" value="<?php  echo $resultsId['id_role']; ?>">
                    <input type="text" name="updateNomRole" value="<?php  echo htmlspecialchars($resultsId['nom_role']); ?>">
                    <input type="submit" name="updateRole" value="Update Role">
                </form>
                <?php
                if (isset($_POST["updateRole"])){
                    $updateIdRole = $_POST["updateIdRole"];
                    $updateNomRole = htmlspecialchars($_POST["updateNomRole"]); 
                    $sqlUpdate = "UPDATE `role` SET `nom_role` = :updateNomRole WHERE id_role = :updateIdRole";
                    $stmtUpdate = $bdd->prepare($sqlUpdate);
                    $stmtUpdate->bindParam(':updateIdRole', $updateIdRole, PDO::PARAM_INT);
                    $stmtUpdate->bindParam(':updateNomRole', $updateNomRole, PDO::PARAM_STR);
                    $stmtUpdate->execute();
                    echo "Données modifiées";
                }
            }
            // supprimer données role
                if (isset($_GET['type']) && $_GET['type'] == "supprimer") {
                    if (isset($_POST["id_role"])) {
                        $deleteIdRole = $_POST["id_role"];
                        $sqlDelete = "DELETE FROM `role` WHERE id_role = :deleteIdRole";
                        $stmtDelete = $bdd->prepare($sqlDelete);
                        $stmtDelete->bindParam(':deleteIdRole', $deleteIdRole, PDO::PARAM_INT);
                        $stmtDelete->execute();
                        echo "Données supprimées";
                    }
                }
        }
        ?> 
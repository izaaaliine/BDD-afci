<!-- // APPRENANTS -->
<?php

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

                $sql = "INSERT INTO `apprenants`(`nom_apprenant`, `prenom_apprenant`, `mail_apprenant`, `adresse_apprenant`, `ville_apprenant`, `code_postal_apprenant`, `tel_apprenant`, `date_naissance_apprenant`, `niveau_apprenant`, `num_PE_apprenant`, `num_secu_apprenant`, `rib_apprenant`, `id_role`, `id_session`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $bdd->prepare($sql);
                $stmt->execute([$nomApprenant, $prenomApprenant, $mailApprenant, $adresseApprenant, $villeApprenant, $cpApprenant, $telApprenant, $dateNaissanceApprenant, $niveauApprenant, $numPEApprenant, $numSSApprenant, $ribApprenant, $idApprenant1, $idApprenant2]);

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
                        foreach ($resultsRole as $value) {
                            if ($value['id_role'] == 4) {
                            echo '<option value="' . $value['id_role'] .  '">' . $value['id_role'] . ' - ' . $value['nom_role'] . '</option>';
                            }
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
                    $sqlDeleteApprenant = "DELETE FROM `apprenants` WHERE id_apprenant = ?";
                    $stmtDeleteApprenant = $bdd->prepare($sqlDeleteApprenant);
                    $stmtDeleteApprenant->execute([$deleteIdApprenant]);
                    
                    echo "Données supprimées";
                    }
                }    
        }
?>
<!-- CONNEXION -->
<?php
    if (isset($_GET["page"]) && $_GET["page"] == "connexion") {
        $sqlUser = "SELECT * FROM users";
        $requeteUser = $bdd->query($sqlUser);
        $resultsUser = $requeteUser->fetchAll(PDO::FETCH_ASSOC);
?>
        <!-- INSCRIPTION -->
        <form method="POST">
            <h2>S'inscrire</h2>
            <input type="text" name="identifiant" placeholder="identifiant">
            <input type="text" name="password" placeholder="password">
            <input type="submit" name="submitInscription" value="enregistrer">
        </form>
        <!-- CONNEXION -->
        <form method="POST">
            <h2>Connexion</h2>
            <input type="text" name="identifiantConnexion" placeholder="identifiant">
            <input type="text" name="passwordConnexion" placeholder="password">
            <input type="submit" name="submitConnexion" value="enregistrer">
        </form>

<?php
        // ajouter un user
            if (isset($_POST['submitInscription'])){
                $identifiant = htmlspecialchars($_POST['identifiant']);
                $password = htmlspecialchars($_POST['password']);
                $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users`(`identifiant`, `password`) VALUES (:identifiant, :password)";
                $stmt = $bdd->prepare($sql);
                $stmt->bindParam(':identifiant', $identifiant, PDO::PARAM_STR);
                $stmt->bindParam(':password', $passwordHashed, PDO::PARAM_STR);
                $stmt->execute();
                echo "Données ajoutées dans la BDD";
            }
    }
        // connexion 
    
            if (isset($_POST['submitConnexion'])){
                $identifiantConnexion = htmlspecialchars($_POST['identifiantConnexion']);
                $passwordConnexion = htmlspecialchars($_POST['passwordConnexion']);
                $stmt = $bdd->prepare("SELECT * FROM users WHERE identifiant = :identifiantConnexion");
                $stmt->bindParam(':identifiantConnexion', $identifiantConnexion, PDO::PARAM_STR);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($data) { 
                    if (password_verify($passwordConnexion,$data['password'])) {
                        echo "Connexion réussie !"; 
                    } else {
                        echo "Mot de passe incorrect !";
                    }
                } else {
                    echo "Identifiant incorrect !"; 
                }
}


?>

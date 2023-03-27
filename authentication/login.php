<?php
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=projet_web2023', 'root', 'root');

    // Vérification si le formulaire est soumis
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupération des données saisies par l'utilisateur
        $username = $_POST['nom'];
        $password = $_POST['motdepasse'];

        // Vérification des informations d'identification dans la table des utilisateurs
        $stmt = $pdo->prepare('SELECT * FROM utilisateur WHERE nom = ? AND motdepasse = ?');
        $stmt->execute([$username, $password]);
        $user = $stmt->fetch();

        // Si l'utilisateur est trouvé, démarrer la session et rediriger vers la page d'accueil
        if($user) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header('Location: ../home.php');
            exit;
        } else {
            // Sinon, afficher un message d'erreur
            echo "Nom d'utilisateur ou mot de passe incorrect";
        }
    }
?>



<!DOCTYPE html>
<html>
<head>
	<title>Page de connexion</title>
</head>
<body>
	<h2>Connexion</h2>
	<form action="" method="post">
		<label>Nom d'utilisateur:</label><br>
		<input type="text" name="nom"><br>
		<label>Mot de passe:</label><br>
		<input type="password" name="motdepasse"><br><br>
		<input type="submit" value="Se connecter">
	</form>
</body>
</html>

<?php
    session_start();

    // Vérification si l'utilisateur est connecté
    if(!isset($_SESSION['user_id'])) {
        header('Location: /authentication/login.php');
        exit;
    }

    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=projet_web2023', 'root', 'root');

    // Récupération des informations de l'utilisateur connecté
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare('SELECT * FROM utilisateur WHERE id = ?');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    // Affichage du rôle de l'utilisateur
    echo '<h2>Bienvenue, ' . $user['role'] . '</h2>';

    // Affichage des liens en fonction du rôle de l'utilisateur
    if($user['role'] == 'responsable') {
        echo '<a href="edition_listes.php">Éditer les listes</a>';
    } else {
        echo '<p><a href="./calendrier/calendrier.php">Calendrier</a> de la semaine en cours</p>';
    }
?>

<?php
session_start();

// Vérifier si l'utilisateur est connecté (id_user en session)
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

// Si connecté, afficher le contenu de index.php (exemple simple)
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Accueil - Remindoc</title>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <h1>Bienvenue <?= htmlspecialchars($_SESSION['username']) ?> sur Remindoc !</h1>
    <p>Ceci est la page principale après connexion.</p>
    <p><a href="logout.php">Se déconnecter</a></p>
</body>
</html>

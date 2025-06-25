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

    <div class="main-content" style="padding: 30px;">
        <h1>Bienvenue <?= htmlspecialchars($_SESSION['username']) ?> sur Remindoc !</h1>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert success">Mail envoyé avec succès.</div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert error"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>

        <form method="post" action="send-mail.php">
            <button type="submit" class="btn-mail">Envoyer un mail de rappel</button>
        </form>
    </div>
</body>
</html>

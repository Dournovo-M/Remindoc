<?php
session_start();
require_once 'link-db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Veuillez remplir tous les champs.";
    } else {
        // Préparer la requête
        $stmt = $pdo->prepare("SELECT id_user, password FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Identifiants corrects
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $username;
            header('Location: dashboard.php'); // Page après connexion
            exit;
        } else {
            $error = "Identifiants incorrects.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post" action="login.php">
        <label for="username">Nom d'utilisateur :</label><br />
        <input type="text" id="username" name="username" required /><br /><br />

        <label for="password">Mot de passe :</label><br />
        <input type="password" id="password" name="password" required /><br /><br />

        <button type="submit">Se connecter</button>
    </form>
</body>
</html>

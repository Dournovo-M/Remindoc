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
        $stmt = $pdo->prepare("SELECT id_user, psword FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $password === $user['psword']) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $username;
            header('Location: index.php');
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
    <title>Connexion - Remindoc</title>
    <style>
        /* Reset léger */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f8fa;
            color: #333;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 320px;
            text-align: center;
        }

        h2 {
            margin-bottom: 24px;
            color: #00796b; /* vert doux santé */
            font-weight: 600;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 6px;
            font-weight: 600;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 18px;
            border: 1.8px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #00796b;
            box-shadow: 0 0 5px #00796b66;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #00796b;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #004d40;
        }

        p.error {
            color: #d32f2f;
            background: #ffebee;
            border: 1px solid #d32f2f;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: 600;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Connexion remindoc</h2>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="post" action="login.php" novalidate>
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required autocomplete="username" />

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required autocomplete="current-password" />

            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>

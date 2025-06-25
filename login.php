<?php
/**
 * Fichier de gestion de la connexion utilisateur (login.php)
 *
 * Ce fichier affiche un formulaire de connexion, gère la soumission du formulaire,
 * vérifie les identifiants de l'utilisateur par rapport à la base de données,
 * et établit une session utilisateur en cas de connexion réussie.
 *
 * @package LoginSystem
 * @subpackage Authentication
 */

// Démarre la session PHP. Ceci doit être la première chose appelée sur la page
// si vous comptez utiliser des sessions (par exemple, $_SESSION).
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclut le fichier de connexion à la base de données.
// Cela rend l'objet $pdo disponible pour les requêtes à la base de données.
require_once 'link-db.php';

// Initialisation des variables pour les messages d'erreur et de succès.
$error_message = '';
$success_message = '';

// Vérifie si le formulaire a été soumis (méthode POST).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les valeurs du formulaire en toute sécurité.
    // trim() supprime les espaces blancs inutiles.
    // htmlspecialchars() convertit les caractères spéciaux en entités HTML pour prévenir les attaques XSS.
    $username = trim(htmlspecialchars($_POST['username'] ?? ''));
    $password = trim(htmlspecialchars($_POST['password'] ?? ''));

    // Validation des champs du formulaire.
    if (empty($username) || empty($password)) {
        $error_message = 'Veuillez remplir tous les champs.';
    } else {
        try {
            // Prépare la requête SQL pour récupérer l'utilisateur.
            // Nous récupérons le mot de passe haché et l'ID de l'utilisateur.
            // Utiliser une requête préparée avec des marqueurs de paramètres (?)
            // est crucial pour prévenir les injections SQL.
            $stmt = $pdo->prepare("SELECT id_user, password FROM users WHERE username = ?");
            // Exécute la requête avec le nom d'utilisateur fourni par l'utilisateur.
            $stmt->execute([$username]);
            // Récupère la première ligne de résultat.
            $user = $stmt->fetch();

            // Vérifie si un utilisateur avec ce nom d'utilisateur existe et
            // si le mot de passe fourni correspond au mot de passe haché stocké.
            // password_verify() est la fonction recommandée pour vérifier les mots de passe hachés.
            if ($user && password_verify($password, $user['password'])) {
                // Connexion réussie !
                $success_message = 'Connexion réussie ! Redirection...';

                // Stocke les informations de l'utilisateur dans la session.
                // Cela permet de garder l'utilisateur connecté sur d'autres pages.
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['username'] = $username;

                // Redirection vers une page sécurisée après la connexion.
                // Par exemple, 'dashboard.php' ou 'accueil.php'.
                // header('Location: dashboard.php');
                // exit; // Il est important d'appeler exit() après une redirection.

                // Pour cet exemple, nous allons juste afficher un message de succès.
                // En production, vous redirigeriez immédiatement.
                echo "<script>
                        setTimeout(function() {
                            // Remplacez 'dashboard.php' par l'URL de votre page après connexion.
                            window.location.href = 'dashboard.php';
                        }, 2000); // Redirige après 2 secondes
                      </script>";

            } else {
                // Identifiants invalides (nom d'utilisateur ou mot de passe incorrect).
                $error_message = 'Nom d\'utilisateur ou mot de passe incorrect.';
            }
        } catch (PDOException $e) {
            // Gère les erreurs de base de données.
            $error_message = 'Une erreur est survenue lors de la connexion. Veuillez réessayer. (Erreur DB: ' . $e->getMessage() . ')';
            // En production, vous devriez enregistrer cette erreur dans un fichier log
            // au lieu de l'afficher à l'utilisateur.
            error_log('Erreur de connexion SQL: ' . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px; /* Coins arrondis */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .login-container h2 {
            margin-bottom: 25px;
            color: #333;
            font-size: 2em; /* Taille du titre */
            letter-spacing: 0.5px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: calc(100% - 20px); /* Ajuste la largeur pour le padding */
            padding: 12px 10px;
            border: 1px solid #ccc;
            border-radius: 8px; /* Coins arrondis pour les inputs */
            font-size: 1em;
            box-sizing: border-box; /* Inclut padding et border dans la largeur */
        }
        .form-group input[type="text"]:focus,
        .form-group input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
        }
        button {
            width: 100%;
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px; /* Coins arrondis pour le bouton */
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
        }
        button:hover {
            background-color: #0056b3;
            transform: translateY(-2px); /* Léger effet au survol */
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 8px;
            font-weight: bold;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>

        <?php
        // Affiche les messages d'erreur ou de succès s'ils existent.
        if (!empty($error_message)) {
            echo '<div class="message error">' . $error_message . '</div>';
        }
        if (!empty($success_message)) {
            echo '<div class="message success">' . $success_message . '</div>';
        }
        ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" required autocomplete="username">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>

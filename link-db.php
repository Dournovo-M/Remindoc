<?php
/**
 * Fichier de connexion à la base de données (link-db.php)
 *
 * Ce fichier établit une connexion à la base de données MySQL
 * en utilisant PDO pour des raisons de sécurité et de flexibilité.
 *
 * @package LoginSystem
 * @subpackage Database
 */

// Définition des constantes pour les informations de connexion à la base de données
// REMPLACEZ CES VALEURS PAR VOS PROPRES IDENTIFIANTS !
define('DB_HOST', 'mistyrose-anteater-380389.hostingersite.com'); // L'hôte de votre base de données (souvent 'localhost')
define('DB_NAME', 'u858625601_remindoc'); // Le nom de votre base de données
define('DB_USER', 'u858625601_remindoc'); // Votre nom d'utilisateur pour la base de données
define('DB_PASS', '20DeC2007@#'); // Votre mot de passe pour la base de données

/**
 * Variable globale pour la connexion à la base de données.
 * @var PDO|null $pdo L'objet PDO pour la connexion, ou null si la connexion échoue.
 */
$pdo = null;

try {
    // Création d'une nouvelle instance PDO pour la connexion à la base de données.
    // L'option charset=utf8mb4 est importante pour le support des caractères spéciaux et emojis.
    // L'attribut PDO::ATTR_ERRMODE est réglé sur EXCEPTION pour que PDO lève des exceptions
    // en cas d'erreurs, ce qui facilite le débogage.
    // L'attribut PDO::ATTR_DEFAULT_FETCH_MODE est réglé sur ASSOC pour récupérer les résultats
    // sous forme de tableaux associatifs.
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false, // Désactive l'émulation des requêtes préparées pour une meilleure sécurité
        ]
    );
    // echo "Connexion à la base de données établie avec succès !"; // Pour débogage, à commenter en production

} catch (PDOException $e) {
    // En cas d'échec de la connexion, affiche un message d'erreur et arrête le script.
    // En production, il est préférable de ne pas afficher l'erreur détaillée à l'utilisateur
    // pour des raisons de sécurité. Consignez-la dans un fichier log.
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
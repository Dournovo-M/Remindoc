<?php
// Paramètres de connexion à la base de données
$host = 'mistyrose-anteater-380389.hostingersite.com';       // ou IP serveur MySQL
$dbname = 'u858625601_remindoc'; // Remplace par le nom de ta base
$user = 'u858625601_remindoc';            // utilisateur MySQL
$password = '20DeC2007@#';            // mot de passe MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    // Mode erreur en exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>

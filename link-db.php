<?php
$host = '127.0.0.1:3306';
$dbname = 'u858625601_remindoc';
$user = 'u858625601_root';
$password = '20DeC2007@#';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5, // timeout 5 sec
    ]);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit;
}
?>

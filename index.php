<?php
session_start();

// Vérifier si l'utilisateur est connecté (id_user en session)
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

require_once 'link-db.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

// Récupérer les infos de l'utilisateur connecté
$id_user = $_SESSION['id_user'];
$username = $_SESSION['username'] ?? '';

// Récupérer le temps préféré pour les rappels
$stmt = $pdo->prepare("SELECT prefered_time FROM users WHERE id_user = :id");
$stmt->execute(['id' => $id_user]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
$preferedTime = $userData['prefered_time'] ?? 30; // Par défaut 30 jours

// ---------- LOGIQUE DE RAPPEL AUTOMATIQUE ----------
// Exemple : envoie d'un email si dernière visite > préférée + simulateur
// À adapter avec votre table patients / visites réelles

// Ici on imagine une table "patients" avec : id, email, last_visit (DATE), id_user (médecin)
$stmt = $pdo->prepare("SELECT email, last_visit FROM patients WHERE id_user = :id");
$stmt->execute(['id' => $id_user]);
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($patients as $patient) {
    $email = $patient['email'];
    $lastVisit = new DateTime($patient['last_visit']);
    $today = new DateTime();
    $interval = $lastVisit->diff($today)->days;

    if ($interval >= $preferedTime) {
        // Envoi du rappel
        $subject = "Rappel : pensez à reprendre rendez-vous avec votre médecin";
        $message = "Bonjour,\n\nCela fait maintenant $interval jours depuis votre dernière visite.\nNous vous invitons à prendre rendez-vous avec votre médecin via Remindoc.";
        $headers = "From: no-reply@remindoc.com";

        // Simuler l'envoi pour éviter les spam en développement
        // mail($email, $subject, $message, $headers);
        echo "<p style='color:green;'>Rappel envoyé à $email (dernière visite il y a $interval jours)</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Remindoc - Tableau de bord</title>
</head>
<body>
    <h1>Bienvenue <?= htmlspecialchars($username) ?> sur Remindoc</h1>
    <p>Remindoc est un logiciel professionnel qui automatise les rappels pour vos patients afin de les inciter à prendre rendez-vous régulièrement avec vous.</p>
    <p>Temps de rappel défini : <strong><?= $preferedTime ?> jours</strong></p>

    <p><a href="logout.php">Se déconnecter</a></p>
</body>
</html>


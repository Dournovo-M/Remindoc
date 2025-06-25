<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

$mail = new PHPMailer(true);

try {
    // Configuration serveur SMTP Gmail
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'dournovo.m06@gmail.com';        // 🔒 à modifier
    $mail->Password   = 'nitz uhef dcoo vooo';            // 🔒 mot de passe d'application
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Expéditeur / destinataire
    $mail->setFrom('dournovo.m06@gmail.com', 'Remindoc');
    $mail->addAddress('dournovom@gmail.com');     // 📨 à modifier

    // Contenu
    $mail->isHTML(true);
    $mail->Subject = 'Rappel de rendez-vous - Remindoc';
    $mail->Body    = 'Bonjour, ceci est un rappel pour planifier votre prochain rendez-vous médical.';
    $mail->AltBody = 'Bonjour, ceci est un rappel pour votre prochain rendez-vous.';

    $mail->send();
    header("Location: index.php?success=1");
    exit;

} catch (Exception $e) {
    header("Location: index.php?error=" . urlencode("Erreur lors de l'envoi du mail : {$mail->ErrorInfo}"));
    exit;
}

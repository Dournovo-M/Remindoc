<?php
// navbar.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<style>
    .navbar {
        background-color: #00796b;
        color: white;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-family: 'Segoe UI', sans-serif;
    }

    .navbar .logo {
        font-size: 24px;
        font-weight: bold;
        letter-spacing: 1px;
    }

    .navbar .user-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .navbar .user-info span {
        font-weight: 500;
    }

    .navbar .logout-btn {
        background-color: #004d40;
        border: none;
        color: white;
        padding: 8px 16px;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .navbar .logout-btn:hover {
        background-color: #00251a;
    }
</style>

<div class="navbar">
    <div class="logo">Remindoc</div>
    <div class="user-info">
        <span>Connecté en tant que <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
        <a class="logout-btn" href="logout.php">Se déconnecter</a>
    </div>
</div>

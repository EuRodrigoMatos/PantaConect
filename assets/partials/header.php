<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>PantaConect</title>
<link rel="stylesheet" href="/PantaConect/assets/css/style.css">
</head>
<body>

<div class="topbar">
    <strong>🚀 PantaConect</strong>

    <div>
        👤 <?= $_SESSION['usuario'] ?? 'Visitante'; ?>
        <?php if (isset($_SESSION['perfil'])): ?>
            (<?= $_SESSION['perfil']; ?>)
        <?php endif; ?>
        | <a href="/PantaConect/logout.php" style="color:#f87171;">Sair</a>
    </div>
</div>
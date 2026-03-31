<?php
session_start();

// 🔒 proteção
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>PantaConect</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #020617, #0f172a);
    color: #e2e8f0;
    margin: 0;
}

/* 🔝 TOPO */
.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 30px;
    background: rgba(2, 6, 23, 0.8);
    backdrop-filter: blur(8px);
    border-bottom: 1px solid #1e293b;
}

.topbar h1 {
    font-size: 20px;
    margin: 0;
}

.user-info {
    font-size: 14px;
    color: #94a3b8;
}

.logout {
    margin-left: 15px;
    color: #f87171;
    text-decoration: none;
}

/* 📦 CONTAINER */
.container {
    padding: 50px 40px;
    text-align: center;
}

.subtitle {
    color: #94a3b8;
    margin-bottom: 40px;
}

/* 🎛️ MENU GRID */
.menu {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 25px;
    max-width: 900px;
    margin: 0 auto;
}

/* 🧊 CARD PREMIUM */
.card {
    background: linear-gradient(145deg, #1e293b, #0f172a);
    padding: 25px;
    border-radius: 16px;
    transition: all 0.25s ease;
    border: 1px solid #334155;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

.card::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 16px;
    padding: 1px;
    background: linear-gradient(120deg, transparent, #2563eb, transparent);
    -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
    -webkit-mask-composite: xor;
    opacity: 0;
    transition: 0.3s;
}

.card:hover::before {
    opacity: 1;
}

.card:hover {
    transform: translateY(-6px) scale(1.02);
}

/* 🎯 ÍCONE */
.icon {
    font-size: 40px;
    margin-bottom: 10px;
}

/* 🧠 TÍTULO */
.title {
    font-weight: 600;
    font-size: 16px;
}

/* LINK */
a {
    text-decoration: none;
    color: inherit;
}

/* FOOTER */
footer {
    text-align: center;
    margin-top: 60px;
    color: #64748b;
    font-size: 12px;
}
</style>

</head>
<body>

<!-- 🔝 TOPO -->
<div class="topbar">
    <h1>🚀 PantaConect</h1>

    <div class="user-info">
        👤 <?php echo $_SESSION['usuario']; ?> (<?php echo $_SESSION['perfil']; ?>)
        <a href="logout.php" class="logout">Sair</a>
    </div>
</div>

<!-- 📦 CONTEÚDO -->
<div class="container">

    <h2>Dashboard</h2>
    <p class="subtitle">Gestão de acessos, onboarding e offboarding</p>

    <div class="menu">

        <?php if ($_SESSION['perfil'] == 'admin' || $_SESSION['perfil'] == 'tecnico'): ?>
        <a href="modules/acessos/acessos.php">
            <div class="card">
                <div class="icon">🔐</div>
                <div class="title">Gerenciar Acessos</div>
            </div>
        </a>
        <?php endif; ?>

        <a href="modules/solicitacoes/nova.php">
            <div class="card">
                <div class="icon">📋</div>
                <div class="title">Nova Solicitação</div>
            </div>
        </a>

        <?php if ($_SESSION['perfil'] == 'tecnico' || $_SESSION['perfil'] == 'admin'): ?>
        <a href="modules/solicitacoes/lista.php">
            <div class="card">
                <div class="icon">🛠️</div>
                <div class="title">Painel TI</div>
            </div>
        </a>
        <?php endif; ?>

    </div>

</div>

<footer>
    © <?php echo date("Y"); ?> PantaConect • Sistema Interno
</footer>

</body>
</html>
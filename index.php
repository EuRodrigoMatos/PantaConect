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
            background-color: #0f172a;
            color: #fff;
            margin: 0;
        }

        /* 🔝 TOPO */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background: #020617;
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
            padding: 40px;
            text-align: center;
        }

        .subtitle {
            color: #94a3b8;
            margin-bottom: 40px;
        }

        /* 🎛️ MENU */
        .menu {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
        }

        .card {
            background: #1e293b;
            padding: 25px;
            border-radius: 12px;
            width: 230px;
            transition: 0.3s;
        }

        .card:hover {
            background: #2563eb;
            transform: translateY(-5px);
        }

        .icon {
            font-size: 38px;
            margin-bottom: 10px;
        }

        .title {
            font-weight: bold;
        }

        a {
            text-decoration: none;
            color: white;
        }

        footer {
            text-align: center;
            margin-top: 60px;
            color: #64748b;
            font-size: 12px;
        }
    </style>
</head>
<body>

<!-- 🔝 TOPO PADRÃO -->
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

        <!-- 🔐 ADMIN -->
       <?php if ($_SESSION['perfil'] == 'admin' || $_SESSION['perfil'] == 'tecnico'): ?>
        <div class="card">
            <a href="modules/acessos/acessos.php">
                <div class="icon">🔐</div>
                <div class="title">Gerenciar Acessos</div>
            </a>
        </div>
        <?php endif; ?>

        <!-- 📋 TODOS -->
        <div class="card">
            <a href="modules/solicitacoes/nova.php">
                <div class="icon">📋</div>
                <div class="title">Nova Solicitação</div>
            </a>
        </div>

        <!-- 🛠️ TI -->
        <?php if ($_SESSION['perfil'] == 'tecnico' || $_SESSION['perfil'] == 'admin'): ?>
        <div class="card">
            <a href="modules/solicitacoes/lista.php">
                <div class="icon">🛠️</div>
                <div class="title">Painel TI</div>
            </a>
        </div>
        <?php endif; ?>

    </div>

</div>

<footer>
    © <?php echo date("Y"); ?> PantaConect • Sistema Interno
</footer>

</body>
</html>
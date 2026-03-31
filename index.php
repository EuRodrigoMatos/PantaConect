<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>PantaConect</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0f172a;
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: 80px;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #94a3b8;
            margin-bottom: 50px;
        }

        .menu {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .card {
            background: #1e293b;
            padding: 25px;
            border-radius: 12px;
            width: 240px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .card:hover {
            background: #2563eb;
            transform: scale(1.05);
        }

        .icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        a {
            text-decoration: none;
            color: white;
            display: block;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
        }

        footer {
            margin-top: 80px;
            color: #64748b;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>🚀 PantaConect</h1>
    <p class="subtitle">Gestão de acessos, onboarding e offboarding</p>

    <div class="menu">

        <!-- 🔐 ACESSOS -->
        <div class="card">
            <a href="modules/acessos/acessos.php">
                <div class="icon">🔐</div>
                <div class="title">Gerenciar Acessos</div>
            </a>
        </div>

        <!-- 📋 RH -->
        <div class="card">
            <a href="modules/solicitacoes/nova.php">
                <div class="icon">📋</div>
                <div class="title">Nova Solicitação (RH)</div>
            </a>
        </div>

        <!-- 🛠️ TI -->
        <div class="card">
            <a href="modules/solicitacoes/lista.php">
                <div class="icon">🛠️</div>
                <div class="title">Painel TI</div>
            </a>
        </div>

    </div>

</div>

<footer>
    © <?php echo date("Y"); ?> PantaConect • Sistema Interno
</footer>

</body>
</html>
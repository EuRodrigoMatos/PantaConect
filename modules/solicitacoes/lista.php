<?php include '../../config/conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>PantaConect - Painel TI</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #020617, #0f172a);
    color: #e2e8f0;
    margin: 0;
}

/* 🔝 TOPO */
.topo {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(2, 6, 23, 0.8);
    backdrop-filter: blur(8px);
    padding: 18px 30px;
    border-bottom: 1px solid #1e293b;
    font-size: 18px;
    font-weight: 600;
}

/* BOTÃO VOLTAR */
.btn-topo {
    padding: 8px 14px;
    border-radius: 8px;
    background: #334155;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    transition: 0.2s;
}

.btn-topo:hover {
    background: #475569;
}

/* 📦 CONTAINER */
.container {
    padding: 40px;
}

/* 🔲 GRID */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
}

/* 🧊 CARD PREMIUM */
.card {
    background: linear-gradient(145deg, #1e293b, #0f172a);
    border: 1px solid #334155;
    border-radius: 16px;
    padding: 22px;
    transition: all 0.25s ease;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    position: relative;
    overflow: hidden;
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

    /* 🔥 CORREÇÃO DO CLIQUE */
    pointer-events: none;
}

.card:hover::before {
    opacity: 1;
}

.card:hover {
    transform: translateY(-6px) scale(1.01);
}

/* 🧠 TITULO */
.card h3 {
    margin: 0 0 10px;
    font-size: 20px;
}

/* 📄 TIPO */
.tipo {
    color: #94a3b8;
    font-size: 14px;
    margin-bottom: 10px;
}

/* 🏷️ BADGE */
.badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.pendente {
    background: rgba(245, 158, 11, 0.15);
    color: #f59e0b;
}

.concluido {
    background: rgba(34, 197, 94, 0.15);
    color: #22c55e;
}

/* 🔘 BOTÃO */
.btn {
    display: block;
    margin-top: 18px;
    text-align: center;
    padding: 12px;
    border-radius: 10px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    transition: 0.25s;

    /* 🔥 GARANTE CLIQUE */
    position: relative;
    z-index: 2;
}

.btn:hover {
    transform: scale(1.03);
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
}
</style>

</head>
<body>

<div class="topo">
    <span>🛠️ Painel TI - Solicitações</span>
    <a href="/PantaConect/index.php" class="btn-topo">⬅ Voltar</a>
</div>

<div class="container">

<?php
$stmt = $conn->query("SELECT * FROM solicitacoes ORDER BY id DESC");

echo "<div class='grid'>";

while ($sol = $stmt->fetch(PDO::FETCH_ASSOC)) {

    echo "<div class='card'>";
    
    echo "<h3>👤 {$sol['nome_usuario']}</h3>";
    echo "<div class='tipo'>Tipo: {$sol['tipo']}</div>";

    if ($sol['status'] == 'Pendente') {
        echo "<span class='badge pendente'>Pendente</span>";
    } else {
        echo "<span class='badge concluido'>Concluído</span>";
    }

    echo "<a href='detalhe.php?id={$sol['id']}' class='btn'>Abrir Checklist</a>";

    echo "</div>";
}

echo "</div>";
?>

</div>

</body>
</html>
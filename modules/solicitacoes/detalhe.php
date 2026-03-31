<?php
session_start();

// 🔒 proteção
if (!isset($_SESSION['usuario'])) {
    header("Location: /PantaConect/login.php");
    exit;
}

require '../../config/database.php';

// 🔍 pega ID
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID não informado");
}

// 🔥 BUSCA DADOS DA SOLICITAÇÃO
$sqlInfo = "SELECT * FROM pantaconect.solicitacoes WHERE id = :id";
$stmtInfo = $conn->prepare($sqlInfo);
$stmtInfo->execute([':id' => $id]);
$solicitacao = $stmtInfo->fetch(PDO::FETCH_ASSOC);

if (!$solicitacao) {
    die("Solicitação não encontrada");
}

// 🔥 BUSCA ACESSOS
$sql = "
SELECT sa.id as sid, a.nome, sa.status
FROM pantaconect.solicitacao_acessos sa
JOIN pantaconect.acessos a ON a.id = sa.acesso_id
WHERE sa.solicitacao_id = :id
";

$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id]);

$total = 0;
$concluidos = 0;
$dados = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $total++;

    if ($row['status']) {
        $concluidos++;
    }

    $dados[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Checklist - PantaConect</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #020617, #0f172a);
    color: #e2e8f0;
    margin: 0;
    font-size: 16px; /* 🔥 AUMENTO GERAL */
}

/* TOPO */
.topo {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 30px;
    background: rgba(2,6,23,0.8);
    border-bottom: 1px solid #1e293b;
    font-size: 18px;
}

.btn-voltar {
    background: #334155;
    padding: 8px 14px;
    border-radius: 8px;
    color: #fff;
    text-decoration: none;
}

/* CONTAINER */
.container {
    padding: 40px;
    max-width: 800px;
    margin: auto;
}

/* CARD */
.card {
    background: linear-gradient(145deg, #1e293b, #0f172a);
    border: 1px solid #334155;
    border-radius: 16px;
    padding: 25px;
    margin-bottom: 20px;
    font-size: 16px;
}

/* NOME USUÁRIO */
.nome-usuario {
    font-size: 20px;
    font-weight: 600;
}

/* GRID INFO */
.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    font-size: 15px;
    margin-top: 15px;
}

/* LABEL */
.info-grid b {
    color: #38bdf8;
}

/* ITEM CHECKLIST */
.item {
    display: flex;
    justify-content: space-between;
    padding: 14px;
    border-bottom: 1px solid #334155;
    font-size: 16px;
}

.item:last-child {
    border-bottom: none;
}

.item:hover {
    background: #334155;
    border-radius: 8px;
}

/* CHECKBOX */
input[type="checkbox"] {
    transform: scale(1.3);
    cursor: pointer;
}

/* STATUS */
.status-ok {
    color: #22c55e;
    font-weight: bold;
    font-size: 16px;
}

.status-warn {
    color: #f59e0b;
    font-weight: bold;
    font-size: 16px;
}
</style>

</head>
<body>

<div class="topo">
    <strong>🔐 Checklist de Acessos</strong>
    <a href="lista.php" class="btn-voltar">⬅ Voltar</a>
</div>

<div class="container">

<!-- 🔥 DADOS PRINCIPAIS -->
<div class="card">
    <strong class="nome-usuario">👤 <?= $solicitacao['nome_usuario'] ?></strong><br>
    Tipo: <?= $solicitacao['tipo'] ?>
</div>

<!-- 🔥 DADOS ONBOARDING -->
<?php if ($solicitacao['tipo'] == 'onboarding'): ?>
<div class="card">
    <strong style="font-size:17px;">📄 Dados do Colaborador</strong>

    <div class="info-grid">
        <div><b>Cargo:</b> <?= $solicitacao['cargo'] ?? '-' ?></div>
        <div><b>Loja:</b> <?= $solicitacao['loja'] ?? '-' ?></div>
        <div><b>Matrícula:</b> <?= $solicitacao['matricula'] ?? '-' ?></div>
        <div><b>Telefone:</b> <?= $solicitacao['telefone'] ?? '-' ?></div>
        <div><b>CPF:</b> <?= $solicitacao['cpf'] ?? '-' ?></div>
        <div><b>RG:</b> <?= $solicitacao['rg'] ?? '-' ?></div>
        <div><b>CEP:</b> <?= $solicitacao['cep'] ?? '-' ?></div>
        <div><b>Cidade:</b> <?= $solicitacao['cidade'] ?? '-' ?></div>
        <div><b>Bairro:</b> <?= $solicitacao['bairro'] ?? '-' ?></div>
        <div><b>Endereço:</b> <?= $solicitacao['endereco'] ?? '-' ?></div>
        <div><b>Admissão:</b> <?= $solicitacao['admissao'] ?? '-' ?></div>
    </div>
</div>
<?php endif; ?>

<!-- 🔥 STATUS -->
<div class="card">
    <?php if ($total == $concluidos && $total > 0): ?>
        <div class="status-ok">✔ Tudo concluído</div>
    <?php else: ?>
        <div class="status-warn">
            ⚠️ Faltam <?= $total - $concluidos ?> itens
        </div>
    <?php endif; ?>
</div>

<!-- 🔥 CHECKLIST -->
<div class="card">

<?php if (empty($dados)): ?>
    <p>Nenhum acesso encontrado.</p>
<?php endif; ?>

<?php foreach ($dados as $row): ?>

<form method="POST" action="atualizar.php" class="item">
    
    <input type="hidden" name="id" value="<?= $row['sid'] ?>">
    <input type="hidden" name="solicitacao_id" value="<?= $id ?>">

    <div><?= $row['nome'] ?></div>

    <input type="checkbox"
        name="status"
        onchange="this.form.submit()"
        <?= $row['status'] ? 'checked' : '' ?>>

</form>

<?php endforeach; ?>

</div>

</div>

</body>
</html>
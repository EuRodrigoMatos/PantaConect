<?php
session_start();

// 🔒 proteção de acesso
if (!isset($_SESSION['usuario'])) {
    header("Location: /PantaConect/login.php");
    exit;
}

require '../../config/database.php';

// pega ID da solicitação
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID não informado");
}

// busca acessos vinculados
$sql = "
SELECT sa.id as sid, a.nome, sa.status
FROM solicitacao_acessos sa
JOIN acessos a ON a.id = sa.acesso_id
WHERE sa.solicitacao_id = :id
";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

// processa dados
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
    <title>Checklist</title>
</head>
<body>

<h2>🔐 Checklist de Acessos</h2>

<hr>

<?php if (empty($dados)): ?>
    <p>Nenhum acesso encontrado.</p>
<?php endif; ?>

<?php foreach ($dados as $row): ?>

<form method="POST" action="atualizar.php">
    <input type="hidden" name="id" value="<?= $row['sid'] ?>">

    <label>
        <input type="checkbox" name="status"
        onchange="this.form.submit()"
        <?= $row['status'] ? 'checked' : '' ?>>

        <?= $row['nome'] ?>
    </label>
</form>

<?php endforeach; ?>

<hr>

<!-- 🔥 VALIDAÇÃO -->
<?php if ($total == $concluidos && $total > 0): ?>

    <h3 style="color:green;">✔ Tudo concluído</h3>

<?php else: ?>

    <h3 style="color:red;">
        ⚠️ Faltam <?= $total - $concluidos ?> itens para concluir
    </h3>

<?php endif; ?>

<br>

<a href="lista.php">⬅ Voltar</a>

</body>
</html>
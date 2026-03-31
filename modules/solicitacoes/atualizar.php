<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: /PantaConect/login.php");
    exit;
}

require '../../config/database.php';

// 🔹 dados recebidos
$id = $_POST['id'] ?? null;
$solicitacao_id = $_POST['solicitacao_id'] ?? null;

// 🔹 checkbox (corrigido)
// se vier marcado → true
// se NÃO vier → false
$status = isset($_POST['status']) ? true : false;

if (!$id || !$solicitacao_id) {
    die("Dados inválidos");
}

// 🔥 ATUALIZA STATUS DO ACESSO
$sql = "UPDATE pantaconect.solicitacao_acessos
        SET status = :status
        WHERE id = :id";

$stmt = $conn->prepare($sql);
$stmt->execute([
    ':status' => $status,
    ':id' => $id
]);

// 🔥 VERIFICA SE TODOS FORAM CONCLUÍDOS
$sql = "SELECT COUNT(*) as total,
               SUM(CASE WHEN status = true THEN 1 ELSE 0 END) as concluidos
        FROM pantaconect.solicitacao_acessos
        WHERE solicitacao_id = :id";

$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $solicitacao_id]);

$result = $stmt->fetch(PDO::FETCH_ASSOC);

$total = $result['total'];
$concluidos = $result['concluidos'] ?? 0;

// 🔥 ATUALIZA STATUS DA SOLICITAÇÃO
if ($total > 0 && $total == $concluidos) {

    // tudo concluído
    $sql = "UPDATE pantaconect.solicitacoes
            SET status = 'Concluído',
                concluido_em = NOW()
            WHERE id = :id";

} else {

    // ainda pendente
    $sql = "UPDATE pantaconect.solicitacoes
            SET status = 'Pendente',
                concluido_em = NULL
            WHERE id = :id";
}

$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $solicitacao_id]);

// 🔁 volta pra tela
header("Location: detalhe.php?id=" . $solicitacao_id);
exit;
<?php
require '../../config/database.php';

// recebe ID do checklist
$id = $_POST['id'];
$status = isset($_POST['status']) ? true : false;

// atualiza item individual
$sql = "UPDATE solicitacao_acessos 
        SET status = :status 
        WHERE id = :id";

$stmt = $conn->prepare($sql);
$stmt->execute([
    ':status' => $status,
    ':id' => $id
]);

// 🔥 PEGA ID DA SOLICITAÇÃO
$sql = "SELECT solicitacao_id 
        FROM solicitacao_acessos 
        WHERE id = :id";

$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id]);

$solicitacao = $stmt->fetch(PDO::FETCH_ASSOC);
$solicitacao_id = $solicitacao['solicitacao_id'];


// 🔥 VERIFICA SE TUDO FOI CONCLUÍDO
$sql = "
SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = true THEN 1 ELSE 0 END) as concluidos
FROM solicitacao_acessos
WHERE solicitacao_id = :sid
";

$stmt = $conn->prepare($sql);
$stmt->execute([':sid' => $solicitacao_id]);

$result = $stmt->fetch(PDO::FETCH_ASSOC);


// 🔥 DEFINE STATUS FINAL
$status_final = ($result['total'] == $result['concluidos']) 
    ? 'Concluido' 
    : 'Pendente';


// 🔥 ATUALIZA A SOLICITAÇÃO
$sql = "UPDATE solicitacoes 
        SET status = :status 
        WHERE id = :id";

$stmt = $conn->prepare($sql);
$stmt->execute([
    ':status' => $status_final,
    ':id' => $solicitacao_id
]);


// volta pra tela
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
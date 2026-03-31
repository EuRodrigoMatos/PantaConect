<?php
include '../../config/conexao.php';

$nome = $_POST['nome_usuario'];
$tipo = $_POST['tipo'];
$acessos = $_POST['acessos'] ?? [];

// salva solicitação
$sql = "INSERT INTO solicitacoes (nome_usuario, tipo) VALUES (:nome, :tipo) RETURNING id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':tipo', $tipo);
$stmt->execute();

$solicitacao_id = $stmt->fetchColumn();

// salva acessos vinculados
foreach ($acessos as $acesso_id) {
    $sql = "INSERT INTO solicitacao_acessos (solicitacao_id, acesso_id) VALUES (:sid, :aid)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':sid', $solicitacao_id);
    $stmt->bindParam(':aid', $acesso_id);
    $stmt->execute();
}

// log
$log = "INSERT INTO logs (acao, usuario, detalhes) VALUES ('Nova solicitação', 'RH', :detalhes)";
$stmt = $conn->prepare($log);
$stmt->bindParam(':detalhes', $nome);
$stmt->execute();

header("Location: nova.php");
?>
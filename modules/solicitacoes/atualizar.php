<?php
include '../../config/conexao.php';

$id = $_POST['id'];
$status = isset($_POST['status']) ? true : false;

$sql = "UPDATE solicitacao_acessos SET status = :status WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':status', $status);
$stmt->bindParam(':id', $id);
$stmt->execute();

// log
$log = "INSERT INTO logs (acao, usuario, detalhes) VALUES ('Atualizou checklist', 'TI', :detalhes)";
$stmt = $conn->prepare($log);
$stmt->bindParam(':detalhes', $id);
$stmt->execute();

header("Location: " . $_SERVER['HTTP_REFERER']);
?>
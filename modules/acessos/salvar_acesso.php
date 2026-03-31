<?php
include '../../config/conexao.php';

$nome = $_POST['nome'];
$tipo = $_POST['tipo'];

$sql = "INSERT INTO acessos (nome, tipo) VALUES (:nome, :tipo)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':tipo', $tipo);
$stmt->execute();

// 🔥 Log automático (já profissional)
$log = "INSERT INTO logs (acao, usuario, detalhes) 
        VALUES ('Cadastro de acesso', 'Sistema', :detalhes)";
$stmtLog = $conn->prepare($log);
$stmtLog->bindParam(':detalhes', $nome);
$stmtLog->execute();

header("Location: acessos.php");
?>
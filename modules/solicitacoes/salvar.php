<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: /PantaConect/login.php");
    exit;
}

require '../../config/database.php';

// dados do form
$nome_usuario = $_POST['nome_usuario'];
$tipo = $_POST['tipo'];
$acessos = $_POST['acessos'] ?? [];

// 🔥 1. salva solicitação
$sql = "INSERT INTO solicitacoes (nome_usuario, tipo, status)
        VALUES (:nome, :tipo, 'Pendente')";

$stmt = $conn->prepare($sql);
$stmt->execute([
    ':nome' => $nome_usuario,
    ':tipo' => $tipo
]);

// 🔥 2. pega ID da solicitação
$solicitacao_id = $conn->lastInsertId();


// 🔥 3. vincula acessos (ESSENCIAL)
foreach ($acessos as $acesso_id) {

    $sql = "INSERT INTO solicitacao_acessos (solicitacao_id, acesso_id, status)
            VALUES (:sid, :aid, false)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':sid' => $solicitacao_id,
        ':aid' => $acesso_id
    ]);
}


// 🔁 redireciona
header("Location: lista.php");
exit;
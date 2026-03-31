<?php
session_start();

require 'config/database_auth.php';

// 🔒 só aceita POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

// 🔹 pega dados com segurança
$login = isset($_POST['login']) ? trim($_POST['login']) : null;
$senha = isset($_POST['senha']) ? $_POST['senha'] : null;

// 🔹 validação básica
if (!$login || !$senha) {
    die("Preencha usuário e senha.");
}

// 🔍 busca usuário ativo
$sql = "SELECT * FROM usuarios 
        WHERE login = :login 
        AND ativo = true 
        LIMIT 1";

$stmt = $connAuth->prepare($sql);
$stmt->bindParam(':login', $login);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// 🔐 valida senha
if ($user && password_verify($senha, $user['senha_hash'])) {

    // 🔥 segurança de sessão
    session_regenerate_id(true);

    $_SESSION['usuario'] = $user['nome'];
    $_SESSION['login']   = $user['login'];
    $_SESSION['perfil']  = $user['perfil'];

    header("Location: /PantaConect/index.php");
    exit;

} else {

    // ❌ login inválido
    echo "<script>
            alert('Login inválido');
            window.location.href = 'login.php';
          </script>";
    exit;
}
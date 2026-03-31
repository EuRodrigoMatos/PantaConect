<?php
session_start();

require 'config/database_auth.php';

$login = $_POST['login'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios WHERE login = :login AND ativo = true";

$stmt = $connAuth->prepare($sql);
$stmt->bindParam(':login', $login);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($senha, $user['senha_hash'])) {

    session_regenerate_id(true);

    $_SESSION['usuario'] = $user['nome'];
    $_SESSION['login']   = $user['login'];
    $_SESSION['perfil']  = $user['perfil'];

    header("Location: index.php");

} else {
    echo "Login inválido";
}
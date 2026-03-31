<?php

function carregarEnv($caminho) {
    if (!file_exists($caminho)) return;

    $linhas = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($linhas as $linha) {
        if (strpos(trim($linha), '#') === 0) continue;

        list($nome, $valor) = explode('=', $linha, 2);
        $_ENV[$nome] = $valor;
    }
}

// carrega o .env
carregarEnv(__DIR__ . '/../.env');

// pega variáveis
$host = $_ENV['DB_HOST'];
$port = $_ENV['DB_PORT'];
$db   = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->exec("SET search_path TO pantaconect");

} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
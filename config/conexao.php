<?php
$host = "172.18.0.242";
$port = "5432";
$db   = "pantaconect";
$user = "webservpg";
$pass = "Pantanal04480";

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Define o schema
    $conn->exec("SET search_path TO pantaconect");

} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
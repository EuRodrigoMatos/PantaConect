<?php
require_once 'env.php';

try {
    $connAuth = new PDO(
        "pgsql:host={$_ENV['AUTH_DB_HOST']};port={$_ENV['AUTH_DB_PORT']};dbname={$_ENV['AUTH_DB_NAME']}",
        $_ENV['AUTH_DB_USER'],
        $_ENV['AUTH_DB_PASS']
    );

    $connAuth->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erro DB AUTH: " . $e->getMessage());
}
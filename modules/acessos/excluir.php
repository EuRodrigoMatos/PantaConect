<?php
session_start();

// 🔒 proteção
if (!isset($_SESSION['usuario'])) {
    header("Location: /PantaConect/login.php");
    exit;
}

// 🔐 acesso
if ($_SESSION['perfil'] != 'admin' && $_SESSION['perfil'] != 'tecnico') {
    die("Acesso negado");
}

require '../../config/database.php';

$id = $_GET['id'];

// buscar acesso
$sql = "SELECT * FROM acessos WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id]);
$acesso = $stmt->fetch(PDO::FETCH_ASSOC);

// salvar edição
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];

    $sql = "UPDATE acessos 
            SET nome = :nome, tipo = :tipo 
            WHERE id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':tipo' => $tipo,
        ':id' => $id
    ]);

    header("Location: acessos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>PantaConect - Editar Acesso</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #0f172a;
    color: #fff;
    margin: 0;
}

.topbar {
    display: flex;
    justify-content: space-between;
    padding: 15px 30px;
    background: #020617;
    border-bottom: 1px solid #1e293b;
}

.container {
    padding: 30px;
}

.card {
    background: #1e293b;
    padding: 20px;
    border-radius: 10px;
    max-width: 500px;
}

input, select {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    border-radius: 6px;
    border: none;
}

button {
    background: #2563eb;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 6px;
    cursor: pointer;
}

button:hover {
    background: #1d4ed8;
}

.voltar {
    display: inline-block;
    margin-top: 15px;
    color: #38bdf8;
    text-decoration: none;
}
</style>

</head>
<body>

<!-- 🔝 TOPO -->
<div class="topbar">
    <strong>✏️ Editar Acesso</strong>

    <div>
        👤 <?= $_SESSION['usuario']; ?> (<?= $_SESSION['perfil']; ?>)
        | <a href="../../logout.php" style="color:#f87171;">Sair</a>
    </div>
</div>

<div class="container">

    <div class="card">
        <h3>Editar Acesso</h3>

        <form method="POST">
            <label>Nome</label>
            <input type="text" name="nome" value="<?= $acesso['nome'] ?>" required>

            <label>Tipo</label>
            <select name="tipo">
                <option value="Sistema" <?= $acesso['tipo']=='Sistema'?'selected':'' ?>>Sistema</option>
                <option value="Rede" <?= $acesso['tipo']=='Rede'?'selected':'' ?>>Rede</option>
                <option value="Outro" <?= $acesso['tipo']=='Outro'?'selected':'' ?>>Outro</option>
            </select>

            <button type="submit">Salvar</button>
        </form>

        <a href="acessos.php" class="voltar">⬅ Voltar</a>
    </div>

</div>

</body>
</html>
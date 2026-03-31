<?php
session_start();

// 🔒 proteção
if (!isset($_SESSION['usuario'])) {
    header("Location: /PantaConect/login.php");
    exit;
}

// 🔐 acesso permitido
if ($_SESSION['perfil'] != 'admin' && $_SESSION['perfil'] != 'tecnico') {
    die("Acesso negado");
}

require '../../config/database.php';

// 🔥 salvar novo acesso
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];

    $sql = "INSERT INTO acessos (nome, tipo)
            VALUES (:nome, :tipo)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':tipo' => $tipo
    ]);

    header("Location: acessos.php");
    exit;
}

// 🔍 buscar acessos
$sql = "SELECT * FROM acessos ORDER BY id DESC";
$stmt = $conn->query($sql);
$acessos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>PantaConect - Acessos</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #020617, #0f172a);
    color: #fff;
    margin: 0;
}

.topbar {
    display: flex;
    justify-content: space-between;
    padding: 15px 30px;
    background: rgba(2,6,23,0.9);
    border-bottom: 1px solid #1e293b;
}

.container {
    padding: 30px;
}

/* CARD */
.card {
    background: #1e293b;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    border: 1px solid #334155;
}

/* INPUTS */
input, select {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: 1px solid #334155;
    background: #020617;
    color: #fff;
}

/* BOTÕES */
.actions {
    display: flex;
    gap: 10px;
}

button {
    flex: 1;
    background: #2563eb;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 8px;
    cursor: pointer;
}

button:hover {
    background: #1d4ed8;
}

.btn-voltar {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #334155;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    transition: 0.2s;
}

.btn-voltar:hover {
    background: #475569;
}

/* LISTA */
.lista {
    list-style: none;
    padding: 0;
}

.lista li {
    padding: 12px;
    border-bottom: 1px solid #334155;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.lista li:hover {
    background: #334155;
}

.acoes {
    display: flex;
    gap: 10px;
}

.editar {
    color: #38bdf8;
    text-decoration: none;
}

.excluir {
    color: #f87171;
    text-decoration: none;
}
</style>

</head>
<body>

<!-- 🔝 TOPO -->
<div class="topbar">
    <strong>🔐 Gerenciar Acessos</strong>

    <div>
        👤 <?= $_SESSION['usuario']; ?> (<?= $_SESSION['perfil']; ?>)
        | <a href="../../logout.php" style="color:#f87171;">Sair</a>
    </div>
</div>

<div class="container">

    <!-- 📝 FORM -->
    <div class="card">
        <h3>Novo Acesso</h3>

        <form method="POST">

            <label>Nome</label>
            <input type="text" name="nome" required>

            <label>Tipo</label>
            <select name="tipo">
                <option value="Sistema">Sistema</option>
                <option value="Rede">Rede</option>
                <option value="Outro">Outro</option>
            </select>

            <div class="actions">
                <button type="submit">Salvar</button>
                <a href="/PantaConect/index.php" class="btn-voltar">Voltar</a>
            </div>

        </form>
    </div>

    <!-- 📋 LISTA -->
    <div class="card">
        <h3>Acessos cadastrados</h3>

        <?php if (empty($acessos)): ?>
            <p>Nenhum acesso cadastrado.</p>
        <?php else: ?>

            <ul class="lista">
                <?php foreach ($acessos as $acesso): ?>
                    <li>

                        <div>
                            <strong><?= $acesso['nome'] ?></strong>
                            - <?= $acesso['tipo'] ?>
                        </div>

                        <div class="acoes">
                            <a href="editar.php?id=<?= $acesso['id'] ?>" class="editar">Editar</a>

                            <a href="excluir.php?id=<?= $acesso['id'] ?>"
                               class="excluir"
                               onclick="return confirm('Deseja excluir este acesso?')">
                               Excluir
                            </a>
                        </div>

                    </li>
                <?php endforeach; ?>
            </ul>

        <?php endif; ?>

    </div>

</div>

</body>
</html>
<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: /PantaConect/login.php");
    exit;
}

require '../../config/database.php';

// busca acessos cadastrados
$sql = "SELECT * FROM acessos ORDER BY nome";
$stmt = $conn->query($sql);
$acessos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>📋 Nova Solicitação</h2>

<form method="POST" action="salvar.php">

    <label>Nome do Usuário:</label><br>
    <input type="text" name="nome_usuario" required><br><br>

    <label>Tipo:</label><br>
    <select name="tipo">
        <option value="onboarding">Onboarding</option>
        <option value="offboarding">Offboarding</option>
    </select><br><br>

    <label>Acessos:</label><br>

    <?php foreach ($acessos as $acesso): ?>
        <label>
            <input type="checkbox" name="acessos[]" value="<?= $acesso['id'] ?>">
            <?= $acesso['nome'] ?>
        </label><br>
    <?php endforeach; ?>

    <br>

    <button type="submit">Salvar</button>

</form>

<br>
<a href="lista.php">⬅ Voltar</a>
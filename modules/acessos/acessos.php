<?php include '../../config/conexao.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>PantaConect - Acessos</title>
</head>
<body>

<h2>🔐 Cadastro de Acessos</h2>

<form method="POST" action="salvar_acesso.php">
    <label>Nome do acesso:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>Tipo:</label><br>
    <select name="tipo">
        <option value="Sistema">Sistema</option>
        <option value="Infra">Infra</option>
        <option value="Equipamento">Equipamento</option>
    </select><br><br>

    <button type="submit">Salvar</button>
</form>

<hr>

<h3>📋 Acessos cadastrados</h3>

<?php
$stmt = $conn->query("SELECT * FROM acessos WHERE ativo = true ORDER BY id DESC");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<p><b>{$row['nome']}</b> ({$row['tipo']})</p>";
}
?>

</body>
</html>
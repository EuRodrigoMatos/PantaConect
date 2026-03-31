<?php include '../../config/conexao.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>PantaConect - Nova Solicitação</title>
</head>
<body>

<h2>📋 Nova Solicitação</h2>

<form method="POST" action="salvar.php">

    <label>Nome do colaborador:</label><br>
    <input type="text" name="nome_usuario" required><br><br>

    <label>Tipo:</label><br>
    <select name="tipo">
        <option value="onboarding">Onboarding</option>
        <option value="offboarding">Offboarding</option>
    </select><br><br>

    <h3>🔐 Acessos</h3>

    <?php
    $stmt = $conn->query("SELECT * FROM acessos WHERE ativo = true");

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<input type='checkbox' name='acessos[]' value='{$row['id']}'> {$row['nome']}<br>";
    }
    ?>

    <br>
    <button type="submit">Salvar Solicitação</button>

</form>

</body>
</html>
<?php include '../../config/conexao.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>PantaConect - Painel TI</title>
</head>
<body>

<h2>🛠️ Painel TI - Solicitações</h2>

<?php
$stmt = $conn->query("SELECT * FROM solicitacoes ORDER BY id DESC");

while ($sol = $stmt->fetch(PDO::FETCH_ASSOC)) {

    echo "<div style='border:1px solid #ccc; padding:10px; margin:10px'>";
    
    echo "<b>Usuário:</b> {$sol['nome_usuario']}<br>";
    echo "<b>Tipo:</b> {$sol['tipo']}<br>";
    echo "<b>Status:</b> {$sol['status']}<br>";

    echo "<a href='detalhe.php?id={$sol['id']}'>➡️ Abrir Checklist</a>";

    echo "</div>";
}
?>

</body>
</html>
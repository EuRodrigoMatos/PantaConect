<?php
include '../../config/conexao.php';

$id = $_GET['id'];

// busca acessos da solicitação
$sql = "
SELECT sa.id as sid, a.nome, sa.status
FROM solicitacao_acessos sa
JOIN acessos a ON a.id = sa.acesso_id
WHERE sa.solicitacao_id = :id
";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
?>

<h2>🔐 Checklist de Acessos</h2>

<?php
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $checked = $row['status'] ? "checked" : "";

    echo "
    <form method='POST' action='atualizar.php'>
        <input type='hidden' name='id' value='{$row['sid']}'>
        <label>
            <input type='checkbox' name='status' onchange='this.form.submit()' $checked>
            {$row['nome']}
        </label>
    </form>
    ";
}
?>
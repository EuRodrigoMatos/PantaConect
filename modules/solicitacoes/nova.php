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

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Nova Solicitação - PantaConect</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #020617, #0f172a);
    color: #e2e8f0;
    margin: 0;
}

.topo {
    padding: 18px 30px;
    background: rgba(2, 6, 23, 0.8);
    border-bottom: 1px solid #1e293b;
    font-size: 18px;
}

.container {
    display: flex;
    justify-content: center;
    padding: 40px;
}

.card {
    background: linear-gradient(145deg, #1e293b, #0f172a);
    border: 1px solid #334155;
    border-radius: 16px;
    padding: 30px;
    width: 600px;
}

/* INPUT */
.input {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #334155;
    background: #020617;
    color: #fff;
    margin-bottom: 10px;
}

/* GRID CHECKBOX */
.checkbox-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
}

/* CAMPOS ONBOARDING */
.onboarding-box {
    margin-top: 20px;
    padding: 15px;
    border: 1px dashed #334155;
    border-radius: 10px;
    display: none;
}

/* BOTÕES */
.actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.btn {
    flex: 1;
    padding: 12px;
    border-radius: 10px;
    border: none;
    background: #2563eb;
    color: #fff;
    cursor: pointer;
}

.btn-secondary {
    flex: 1;
    text-align: center;
    padding: 12px;
    background: #334155;
    color: #fff;
    text-decoration: none;
    border-radius: 10px;
}
</style>

</head>
<body>

<div class="topo">
    📋 Nova Solicitação
</div>

<div class="container">

<div class="card">

<form method="POST" action="salvar.php">

    <label>Nome do Usuário</label>
    <input type="text" name="nome_usuario" class="input" required>

    <label>Tipo</label>
    <select name="tipo" class="input" id="tipoSelect" onchange="toggleOnboarding()">
        <option value="onboarding">Onboarding</option>
        <option value="offboarding">Offboarding</option>
    </select>

    <!-- 🚀 CAMPOS DINÂMICOS -->
    <div class="onboarding-box" id="onboardingFields">

        <h4>Dados do Colaborador</h4>

        <input type="text" name="cargo" class="input" placeholder="Cargo">
        <input type="text" name="loja" class="input" placeholder="Loja">
        <input type="text" name="matricula" class="input" placeholder="Matrícula">
        <input type="text" name="endereco" class="input" placeholder="Endereço">
        <input type="text" name="bairro" class="input" placeholder="Bairro">
        <input type="text" name="cidade" class="input" placeholder="Cidade">
        <input type="text" name="cep" class="input" placeholder="CEP">
        <input type="text" name="telefone" class="input" placeholder="Telefone">
        <input type="text" name="cpf" class="input" placeholder="CPF">
        <input type="text" name="rg" class="input" placeholder="RG">
        <input type="date" name="admissao" class="input">

    </div>

    <label>Acessos</label>

    <div class="checkbox-grid">
        <?php foreach ($acessos as $acesso): ?>
            <label>
                <input type="checkbox" name="acessos[]" value="<?= $acesso['id'] ?>">
                <?= $acesso['nome'] ?>
            </label>
        <?php endforeach; ?>
    </div>

    <div class="actions">
        <button type="submit" class="btn">Salvar</button>
        <a href="/PantaConect/index.php" class="btn-secondary">Voltar</a>
    </div>

</form>

</div>

</div>

<script>
function toggleOnboarding() {
    const tipo = document.getElementById('tipoSelect').value;
    const box = document.getElementById('onboardingFields');

    if (tipo === 'onboarding') {
        box.style.display = 'block';
    } else {
        box.style.display = 'none';
    }
}

// inicia já visível se onboarding
toggleOnboarding();
</script>

</body>
</html>
<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: /PantaConect/login.php");
    exit;
}

require '../../config/database.php';

// 🔹 dados principais
$nome = $_POST['nome_usuario'] ?? null;
$tipo = $_POST['tipo'] ?? null;

if (!$nome || !$tipo) {
    die("Dados obrigatórios não informados");
}

// 🔹 dados onboarding (tratando vazio = NULL)
$cargo = !empty($_POST['cargo']) ? $_POST['cargo'] : null;
$loja = !empty($_POST['loja']) ? $_POST['loja'] : null;
$matricula = !empty($_POST['matricula']) ? $_POST['matricula'] : null;
$endereco = !empty($_POST['endereco']) ? $_POST['endereco'] : null;
$bairro = !empty($_POST['bairro']) ? $_POST['bairro'] : null;
$cidade = !empty($_POST['cidade']) ? $_POST['cidade'] : null;
$cep = !empty($_POST['cep']) ? $_POST['cep'] : null;
$telefone = !empty($_POST['telefone']) ? $_POST['telefone'] : null;
$cpf = !empty($_POST['cpf']) ? $_POST['cpf'] : null;
$rg = !empty($_POST['rg']) ? $_POST['rg'] : null;
$admissao = !empty($_POST['admissao']) ? $_POST['admissao'] : null;

// 🔥 INSERT COMPLETO (POSTGRES)
$sql = "INSERT INTO pantaconect.solicitacoes (
    nome_usuario, tipo, status,
    cargo, loja, matricula, endereco, bairro, cidade,
    cep, telefone, cpf, rg, admissao
) VALUES (
    :nome, :tipo, 'Pendente',
    :cargo, :loja, :matricula, :endereco, :bairro, :cidade,
    :cep, :telefone, :cpf, :rg, :admissao
) RETURNING id";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ':nome' => $nome,
    ':tipo' => $tipo,
    ':cargo' => $cargo,
    ':loja' => $loja,
    ':matricula' => $matricula,
    ':endereco' => $endereco,
    ':bairro' => $bairro,
    ':cidade' => $cidade,
    ':cep' => $cep,
    ':telefone' => $telefone,
    ':cpf' => $cpf,
    ':rg' => $rg,
    ':admissao' => $admissao
]);

// 🔥 pega ID corretamente
$solicitacao_id = $stmt->fetchColumn();

// 🔗 salva acessos vinculados
if (isset($_POST['acessos']) && is_array($_POST['acessos'])) {

    foreach ($_POST['acessos'] as $acesso_id) {

        $sql = "INSERT INTO pantaconect.solicitacao_acessos 
                (solicitacao_id, acesso_id, status)
                VALUES (:sid, :aid, false)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':sid' => $solicitacao_id,
            ':aid' => $acesso_id
        ]);
    }
}

// 🔁 redireciona
header("Location: lista.php");
exit;
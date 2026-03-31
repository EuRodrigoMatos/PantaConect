<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Login - PantaConect</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #020617, #0f172a);
    color: #e2e8f0;
    margin: 0;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* 🧊 CARD LOGIN */
.login-box {
    background: rgba(30, 41, 59, 0.6);
    backdrop-filter: blur(12px);
    border: 1px solid #334155;
    border-radius: 16px;
    padding: 40px;
    width: 320px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.4);
    text-align: center;
    position: relative;
    z-index: 1;
}

/* 🔥 CORREÇÃO AQUI */
.login-box::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 16px;
    padding: 1px;
    background: linear-gradient(120deg, transparent, #2563eb, transparent);
    -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
    -webkit-mask-composite: xor;
    opacity: 0.3;

    pointer-events: none; /* ✅ ESSENCIAL */
}

/* título */
.login-box h2 {
    margin-bottom: 25px;
}

/* inputs */
.input {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #334155;
    background: #020617;
    color: #fff;
    margin-bottom: 15px;
    outline: none;
    position: relative;
    z-index: 2;
}

.input:focus {
    border-color: #2563eb;
    box-shadow: 0 0 10px rgba(37, 99, 235, 0.3);
}

/* botão */
.btn {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: none;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: #fff;
    font-weight: 500;
    cursor: pointer;
    transition: 0.25s;
    position: relative;
    z-index: 2;
}

.btn:hover {
    transform: scale(1.03);
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
}

/* rodapé */
.footer {
    margin-top: 15px;
    font-size: 12px;
    color: #64748b;
}
</style>

</head>
<body>

<form method="POST" action="/PantaConect/auth.php" class="login-box">

    <h2>🔐 Login PantaConect</h2>

    <input 
        type="text" 
        name="login" 
        placeholder="Usuário" 
        class="input" 
        autocomplete="username"
        required
    >

    <input 
        type="password" 
        name="senha" 
        placeholder="Senha" 
        class="input" 
        autocomplete="current-password"
        required
    >

    <button type="submit" name="entrar" class="btn">
        Entrar
    </button>

    <div class="footer">
        Sistema interno • PantaConect
    </div>

</form>

</body>
</html>
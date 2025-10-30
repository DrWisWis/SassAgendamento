<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre-se</title>
    <link rel="stylesheet" href="../../src/style/cadastro.css">
</head>
<body>
    <div class="header">
        <div class="arrow">
            <a href="../../index.php">
                <img src="../../src/assets/arrow-left.png" alt="">
            </a>
        </div>
    </div>
        <h1>Register</h1>

    <p class="personal-information">Informações Pessoais</p>
    <form method="POST" action="processaRegister.php">
        <input type="text" name="nome" placeholder="Nome completo" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="senha" required>
        <button type="submit" name="register" class="register">Register</button>
    </form>
    <p class="login">Ja tem uma conta? <a href="login.php">Login</a></p>
</body>
</html>
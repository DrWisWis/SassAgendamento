<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login in</title>
</head>
<body>
    <img src="../../src/assets/logo.png" alt="">
    <h2>Welcome back.</h2>
    <form action="processaLogin.php" method="POST">
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        <label>Senha:</label>
        <input type="password" name="senha" required><br><br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>
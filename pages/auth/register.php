<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../src/style/register.css">
</head>
<body>
    <div class="header">
        <p><--</p>
        <h2>Register</h2>
    </div>
    <form method="POST" action="processaRegister.php">
        <input type="text" name="nome" placeholder="Nome completo" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="senha" required>
        <button type="submit" name="register" class="register">Register</button>
    </form>
    <p>Ja tem uma conta? <a href="login.php">Login</a></p>
</body>
</html>
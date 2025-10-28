<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login in</title>
    <link rel="stylesheet" href="../../src/style/login.css">
</head>
<body>
    <img src="../../src/assets/logo.png" alt="" class="logo">
    <h1>Welcome back.</h1>
    <form action="processaLogin.php" method="POST">
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Enter your password" required>
        <p>Forgot password?</p>
        <button type="submit">Login</button>
    </form>
    <a href="../../pages/auth/register.php">
        <p class="account">Don't have an account? <span>Register Now</span></p>
    </a>
</body>
</html>
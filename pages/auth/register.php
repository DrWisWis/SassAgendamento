<?php
    session_start();
    include __DIR__ . '/../../conexao.php';


    if(isset($_POST['register'])){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);


        $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES ('$nome', '$email', '$senha', 'CLIENTE')";
        if($conn->query($sql)){
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro ao cadastrar.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Create Account</h2>
    <form method="POST">
        <label>Nome:</label>
        <input type="text" name="nome" required><br><br>


        <label>Email:</label>
        <input type="email" name="email" required><br><br>


        <label>Senha:</label>
        <input type="password" name="senha" required><br><br>


        <button type="submit" name="register">cadastrar</button>
    </form>
    <p>Ja tem uma conta? <a href="login.php">Login</a></p>
</body>
</html>
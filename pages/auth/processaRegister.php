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
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'conectar.php';

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    $permissao = $_POST['permissao'];

    $senha = password_hash($senha, PASSWORD_DEFAULT);

    $inserindo = "INSERT INTO usuarios( nome,email,cpf,senha,permissao)VALUES('$nome','$email','$cpf','$senha','$permissao');";
    mysqli_query($conn, $inserindo);
    
    mysqli_close($conn);
    Header('Location: ../usuario.php');
}

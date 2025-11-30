<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'conectar.php';

    $id_usuario = $_POST['edit-id'];
    $nome = $_POST['edit-nome'];
    $email = $_POST['edit-email'];
    $senha = $_POST['edit-senha'];
    $cpf = $_POST['edit-cpf'];
    $permissao = $_POST['edit-permissao'];

    $coletando = "SELECT * FROM usuarios WHERE id = $id_usuario";
    $executa = mysqli_query($conn, $coletando);
    $transformando = mysqli_fetch_array($executa);

    if ($nome == "") {
        $nome = $transformando['nome'];
    }
    if ($email == "") {
        $email = $transformando['email'];
    }
    if ($senha == "") {
        $senha = $transformando['senha'];
    } else {
        $senha = password_hash($senha, PASSWORD_DEFAULT);
    }
    if ($cpf == "") {
        $cpf = $transformando['cpf'];
    }
    if ($permissao == "") {
        $permissao = $transformando['permissao'];
    }


    $sql = "UPDATE usuarios SET nome=?, email=?, cpf=?, senha=?, permissao=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nome, $email, $cpf, $senha, $permissao, $id_usuario);
    $stmt->execute();

    header("Location: ../usuario.php");
}

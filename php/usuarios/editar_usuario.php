<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require '../conectar.php';
    # conecto no banco de dados
    $id_usuario = $_POST['edit-id'];
    $nome = $_POST['edit-nome'];
    $email = $_POST['edit-email'];
    $senha = $_POST['edit-senha'];
    $cpf = $_POST['edit-cpf'];
    $permissao = $_POST['edit-permissao'];
    # armazeno os dados que foram enviador via post


    $coletando = "SELECT * FROM usuarios WHERE id = $id_usuario";
    $executa = mysqli_query($conn, $coletando);
    $transformando = mysqli_fetch_array($executa);
    # faço um select para coletar os dados atuais do usuario com o id coletado

    # se algum campo estiver vazio mantenho o valor que já estava presente no banco
    if ($nome == "" || $nome == " ") {
        $nome = $transformando['nome'];
    }
    if ($email == "" || $email == " ") {
        $email = $transformando['email'];
    }
    if ($senha == "" || $senha == " ") {
        $senha = $transformando['senha'];
    } else {
        $senha = password_hash($senha, PASSWORD_DEFAULT);
    }
    if ($cpf == "" || $cpf == " ") {
        $cpf = $transformando['cpf'];
    }
    if ($permissao == "" || $permissao == " ") {
        $permissao = $transformando['permissao'];
    }

    $sql = "UPDATE usuarios SET nome='$nome', email='$email', cpf='$cpf', senha='$senha', permissao='$permissao' WHERE id= $id_usuario";
    mysqli_query($conn, $sql);
    # atualizo os dados do usuario com id coletado
    mysqli_close($conn);
    header("Location: ../../usuario.php");
    # fecho conexao e volto para usuario.php
}

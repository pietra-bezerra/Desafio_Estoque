<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require '../conectar.php';
    # conecto no banco
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    $permissao = $_POST['permissao'];
    #coleto os valores enviados via post e armazeno em variaveis

    $senha = password_hash($senha, PASSWORD_DEFAULT);
    # a senha inserida fica ilegivel, foi transformada em hash
    # podemos fazer comparacoes depois com password_verify()
    # O hash é irreversível e contém um salt aleatório embutido automaticamente
    # salt é uma sequencia aleatoria q é adicionada ao hash
    # password_default garente que o algoritmo mais seguro seja usado
    

    $inserindo = "INSERT INTO usuarios( 
    nome,email,cpf,senha,permissao)VALUES(
        '$nome',
        '$email',
        '$cpf',
        '$senha',
        '$permissao'
    );";
    mysqli_query($conn, $inserindo);
    # adiciono os dados na tabela usuarios 

    mysqli_close($conn);
    Header('Location: ../../usuario.php');
    #fecho conexao e volto para usuario.php
}

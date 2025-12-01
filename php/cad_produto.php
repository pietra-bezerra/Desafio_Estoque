<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require "conectar.php";
    # conecto no banco

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $unidade = $_POST['unidade'];
    $quantidade = $_POST['quantidade'];
    $minimo = $_POST['minimo'];
    # coleto os valores enviados via post e armazeno em variaveis

    $inserindo = "INSERT INTO gestao(
            nome,
            descricao,
            unidade,
            quantidade,
            minimo
        )VALUES(
            '$nome',
            '$descricao',
            '$unidade',
            '$quantidade',
            '$minimo'
        );";
    
    # adiciono a tabela gestao que seria a de produtos

    mysqli_query($conn, $inserindo);
    #executo
    mysqli_close($conn);
    header("Location: ../produto.php");
    #fecho conexao e volto para produto.php
}

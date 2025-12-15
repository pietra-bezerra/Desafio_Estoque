<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require '../conectar.php';
    # conecto no banco

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $unidade = $_POST['unidade'];
    $quantidade = $_POST['quantidade'];
    $minimo = $_POST['minimo'];
    # coleto os valores enviados via post e armazeno em variaveis

    $sql = "SELECT nome FROM gestao WHERE nome = '$nome'";
    $exec = mysqli_query($conn, $sql);

    if (mysqli_num_rows($exec) > 0) {
        session_start();
        $_SESSION['erro'] = "Produto já existente no estoque!";
        header("Location: ../../produto.php");
        exit();
    } else {
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

        session_start();
        $_SESSION['sucesso'] = "Produto cadastrado com sucesso!";
        #executo
        mysqli_close($conn);
        header("Location: ../../produto.php");
        #fecho conexao e volto para produto.php
    }
}

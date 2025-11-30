<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require "conectar.php";

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $unidade = $_POST['unidade'];
    $quantidade = $_POST['quantidade'];
    $minimo = $_POST['minimo'];

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

    mysqli_query($conn, $inserindo);

    mysqli_close($conn);
    header("Location: ../produto.php");
}

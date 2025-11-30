<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    require "conectar.php";

    $id_produto = $_GET['id_produto'];

    $nome = "SELECT nome FROM gestao WHERE idgestao = $id_produto";;
    $executando = mysqli_query($conn, $nome);
    $transformando = mysqli_fetch_array($executando);
    $nome_coletado = $transformando[0];

    $altera_status = "UPDATE movimentacao SET status_produto = 'DELETADO' WHERE nome = '$nome_coletado'";
    $executando = mysqli_query($conn, $altera_status);

    $exclusao = "DELETE FROM gestao WHERE idgestao = $id_produto";
    mysqli_query($conn, $exclusao);

    Header("Location: ../estoque.php");
}

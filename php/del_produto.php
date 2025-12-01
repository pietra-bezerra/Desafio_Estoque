<?php
# se a requisicao for get execute:
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    require "conectar.php";
    #conecto no banco

    $id_produto = $_GET['id_produto'];
    # armarzeno o id do produto

    $nome = "SELECT nome FROM gestao WHERE idgestao = $id_produto";
    $executando = mysqli_query($conn, $nome);
    $transformando = mysqli_fetch_array($executando);
    $nome_coletado = $transformando[0];
    # coleto o nome do produto com o id coletado anteriormente

    $altera_status = "UPDATE movimentacao SET status_produto = 'DELETADO' WHERE nome = '$nome_coletado'";
    $executando = mysqli_query($conn, $altera_status);
    # mudo o status do produto com nome coletado na tabela de movimentacao para informar que o produto foi deletado e nao esta mais em atividade

    $exclusao = "DELETE FROM gestao WHERE idgestao = $id_produto";
    mysqli_query($conn, $exclusao);
    # aqui exclui o produto que tinha o id coletado anteriormente

    mysqli_close($conn);
    Header("Location: ../estoque.php");
    # fecho conexao e volto para estoque.php
}

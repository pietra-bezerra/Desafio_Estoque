<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'conectar.php';

    $id_produto = $_POST['produto'];
    $tipo = $_POST['tipo'];
    $quantidade = $_POST['quantidade'];

    $nome = "SELECT nome FROM gestao WHERE idgestao = $id_produto";;
    $executando = mysqli_query($conn,$nome);
    $transformando = mysqli_fetch_array($executando);
    $nome_coletado = $transformando['nome'];

    $inserindo = "INSERT INTO movimentacao( nome, tipo, quantidade, status_produto)VALUES('$nome_coletado','$tipo','$quantidade', 'ATIVO')";
    mysqli_query($conn, $inserindo);

    if ($tipo == "Entrada") {
        $atualizando = "UPDATE gestao SET quantidade = quantidade + $quantidade WHERE idgestao = $id_produto";
    } else{
        $atualizando = "UPDATE gestao SET quantidade = quantidade - $quantidade WHERE idgestao = $id_produto";
        
        $conferindo = "SELECT quantidade FROM gestao WHERE idgestao = $id_produto";
        $executando = mysqli_query($conn,$conferindo);
        $transformando = mysqli_fetch_array($executando);
        if($transformando['quantidade'] <= 0){
            $atualizando = "UPDATE gestao SET quantidade = 0 WHERE idgestao = $id_produto";
        }
    }

    mysqli_query($conn, $atualizando);

    mysqli_close($conn);
    header("Location: ../estoque.php");
}

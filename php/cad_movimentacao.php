<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'conectar.php';
    # Conexao com o banco

    $id_produto = $_POST['produto'];
    $tipo = $_POST['tipo'];
    $quantidade = $_POST['quantidade'];
    # Coleto os dados enviados via post e armazeno em variaveis

    $nome = "SELECT nome FROM gestao WHERE idgestao = $id_produto";;
    $executando = mysqli_query($conn,$nome);
    $transformando = mysqli_fetch_array($executando);
    $nome_coletado = $transformando['nome'];
    # Aq eu dou um select e armazeno o nome do registro com o id armazenado anteriormente

    $inserindo = "INSERT INTO movimentacao( nome, tipo, quantidade, status_produto)VALUES('$nome_coletado','$tipo','$quantidade', 'ATIVO')";
    mysqli_query($conn, $inserindo);
    # Adiciono a movimentacao na tabela movimentacao

    # Se o tipo de movimentacao for "Entrada" vou atualizar adicionar, caso contrario subtrair da quantidade do produto com id coletado anteriormente
    if ($tipo == "Entrada") {
        $atualizando = "UPDATE gestao SET quantidade = quantidade + $quantidade WHERE idgestao = $id_produto";
    } else{
        $atualizando = "UPDATE gestao SET quantidade = quantidade - $quantidade WHERE idgestao = $id_produto";
        
        $conferindo = "SELECT quantidade FROM gestao WHERE idgestao = $id_produto";
        $executando = mysqli_query($conn,$conferindo);
        $transformando = mysqli_fetch_array($executando);
        if(($transformando['quantidade']-$quantidade) <= 0){
            $atualizando = "UPDATE gestao SET quantidade = 0 WHERE idgestao = $id_produto";
        }
        # Caso o a quantidade anterior - a quantidade da movimentacao saida for menor ou igual a 0, a quantidade vai ser registrada como 0
    }

    mysqli_query($conn, $atualizando);
    # Executo

    mysqli_close($conn);
    header("Location: ../estoque.php");
    # Fecho conexao e volto para estoque.php
}

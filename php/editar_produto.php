<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'conectar.php';
    # Puxo o conectar.php que armazena a conexao com o banco

    $id_produto = $_POST['edit-id'];
    $produto = $_POST['edit-produto'];
    $descricao = $_POST['edit-descricao'];
    $unidade = $_POST['edit-unidade'];
    $minimo = $_POST['edit-minimo'];
    # Coleto os dados enviados via post e armazeno em variaveis 

    $coletando = "SELECT * FROM gestao WHERE idgestao = $id_produto";
    $executa = mysqli_query($conn, $coletando);
    $transformando = mysqli_fetch_array($executa);
    # Aqui do um select no registro com o id coletado e armazeno

    # Se tiver algum campo vazio eu pego o valor que já existia no registro anteriormente
    if ($produto == "" || $produto == " ") {
        $produto = $transformando['nome'];
    }
    if ($descricao == "" || $descricao == " ") {
        $descricao = $transformando['descricao'];
    }
    if ($unidade == "" || $unidade == " ") {
        $unidade = $transformando['unidade'];
    }
    if ($minimo == "" || $minimo == " ") {
        $minimo = $transformando['minimo'];
    }

    $atualizando = "UPDATE gestao SET nome= '$produto', descricao='$descricao', unidade='$unidade', minimo='$minimo' WHERE idgestao=$id_produto";
    mysqli_query($conn, $atualizando);
    # Aqui realizo um update para atualizar o registro com o id coletado

    mysqli_close($conn);
    header("Location: ../estoque.php");
    # Fecho a conexao com o banco e mando de volta pro estoque
}

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'conectar.php';

    $id_produto = $_POST['edit-id'];
    $produto = $_POST['edit-produto'];
    $descricao = $_POST['edit-descricao'];
    $unidade = $_POST['edit-unidade'];
    $minimo = $_POST['edit-minimo'];

    $coletando = "SELECT * FROM gestao WHERE idgestao = $id_produto";
    $executa = mysqli_query($conn, $coletando);
    $transformando = mysqli_fetch_array($executa);

    if ($produto == "") {
        $produto = $transformando['nome'];
    }
    if ($descricao == "") {
        $descricao = $transformando['descricao'];
    }
    if ($unidade == "") {
        $unidade = $transformando['unidade'];
    }
    if ($minimo == "") {
        $minimo = $transformando['minimo'];
    }


    $sql = "UPDATE gestao SET nome=?, descricao=?, unidade=?, minimo=? WHERE idgestao=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $produto, $descricao, $unidade, $minimo, $id_produto);
    $stmt->execute();
    
    mysqli_close($conn);
    header("Location: ../estoque.php");
}

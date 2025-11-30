<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        require "conectar.php";

        $id_produto = $_GET['id_produto'];

        $exclusao = "DELETE FROM gestao WHERE idgestao = $id_produto";
        mysqli_query($conn,$exclusao) or die('ERRO');

        Header("Location: ../estoque.php");
    }
?>
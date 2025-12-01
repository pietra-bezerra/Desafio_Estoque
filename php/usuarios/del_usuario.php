<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    require '../conectar.php';
    # conecto no banco de dados

    $id_usuario = $_GET['id'];
    # coleto o id e armazeno

    $exclusao = "DELETE FROM usuarios WHERE id = $id_usuario";
    mysqli_query($conn, $exclusao);
    # faço a exclusao do usuario quando o id for igual ao que coletei anteriormente
    mysqli_close($conn);
    Header("Location: ../../usuario.php");
    # fecho conexao e volto para usuario.php
}

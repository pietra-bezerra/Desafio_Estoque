<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    require "conectar.php";

    $id_usuario = $_GET['id'];

    $exclusao = "DELETE FROM usuarios WHERE id = $id_usuario";
    mysqli_query($conn, $exclusao);

    mysqli_close($conn);
    Header("Location: ../usuario.php");
}

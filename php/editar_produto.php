<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require 'conectar.php';

        $atualizando = "UPDATE ";
        mysqli_query($conn,$atualizando);
    }
?>
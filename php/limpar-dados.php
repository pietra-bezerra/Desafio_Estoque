<?php 
session_start();
unset($_SESSION['erro']);
unset($_SESSION['sucesso']);
header("Location: ../estoque.php");

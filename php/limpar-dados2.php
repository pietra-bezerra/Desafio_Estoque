<?php 
session_start();
unset($_SESSION['erro_cpf']);
unset($_SESSION['erro_nome']);
unset($_SESSION['erro_email']);
unset($_SESSION['sucesso']);
unset($_SESSION['erro_cpf2']);
unset($_SESSION['erro_nome2']);
unset($_SESSION['erro_email2']);
unset($_SESSION['sucesso2']);
header("Location: ../usuario.php");

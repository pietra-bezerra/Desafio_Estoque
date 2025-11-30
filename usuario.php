<?php
// 1. Inicia a sessão (necessário para checar a autenticação)
session_start();

// 2. Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    // Se não estiver logado, redireciona para a tela de login
    header("Location: index.php");
    exit;
}

if ($_SESSION['user_permissao'] != "ADMIN") {
    header("Location: principal.php");
    exit;
}

// Obtém o nome do usuário da sessão para exibição
$user_name = $_SESSION['user_nome'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP - Gestão de Estoque</title>

    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/produto.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        /* Define a fonte Geologica como a principal */
        @import url('https://fonts.googleapis.com/css2?family=Geologica:wght@100..900&display=swap');

        /* Configurações globais para o tema dark */
        body {
            font-family: 'Geologica', sans-serif;
            min-height: 100vh;
            display: flex;
            /* Para layout de sidebar + conteúdo */
            background-color: #111827;
            /* bg-gray-900 (Fundo principal dark) */
            color: #E5E7EB;
            /* text-gray-200 */
        }

        /* Classes customizadas para a barra lateral */
        .sidebar {
            width: 16rem;
            /* w-64 */
            flex-shrink: 0;
            background-color: #1F2937;
            /* bg-gray-800 */
        }

        /* Estilo para a imagem de perfil/logo na config */
        .sec-config img {
            transition: transform 0.3s ease;
        }

        .sec-config img:hover {
            transform: scale(1.05);
        }

        /* Estilo para a Tabela e Modal de Movimentação (Para imitar o CSS original onde não há classes Tailwind prontas) */

        .caixa-sec-movimentacao {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: none;
            /* Inicia oculto */
            justify-content: center;
            align-items: center;
            z-index: 100;
        }

        .caixa-form-movimentacao,
        .caixa-form-edit {
            background-color: #1F2937;
            /* bg-gray-800 */
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5), 0 4px 6px -4px rgba(0, 0, 0, 0.5);
            width: 90%;
            max-width: 500px;
            position: relative;
        }
    </style>

    <link rel="shortcut icon" href="assets/imgs/logo.png" type="image/x-icon">
</head>

<body>
    <?php include 'php/componentes/nav.php'; ?>

    <script src="scipts.js" defer></script>
</body>

</html>
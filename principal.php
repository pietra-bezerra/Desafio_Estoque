<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP</title>

    <!-- Estilização -->
    <link rel="stylesheet" href="css/principal.css">
    <link rel="stylesheet" href="css/nav.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Fonte Usada (Diretamente do Google Fonts)  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@100..900&display=swap" rel="stylesheet">

    <!-- Icone da Página -->
    <link rel="shortcut icon" href="assets/imgs/logo.png" type="image/x-icon">
</head>

<body>
    <?php 
        include "php/componentes/nav.php";
    ?>
    <main class="main-conteudo">
        <section class="sec-config">
            <p>Nome Funcionário</p>
            <img src="assets/imgs/logo.png" alt="Logo" width="100px">
        </section>
        <header>
            <h2>Gerenciamento Estoque</h2>
        </header>
        <section class="sec-caixas">
            <div class="caixas">
                <div class="caixa-titulo">
                    <h4>Saída</h4>
                </div>
                <div class="caixa-numero">
                    <h2>2</h2>
                </div>
            </div>
            <div class="caixas">
                <div class="caixa-titulo">
                    <h4>Mínimo</h4>
                </div>
                <div class="caixa-numero">
                    <h2>1</h2>
                </div>
            </div>
            <div class="caixas">
                <div class="caixa-titulo">
                    <h4>Estoque</h4>
                </div>
                <div class="caixa-numero">
                    <h2>4</h2>
                </div>
            </div>

        </section>
    </main>
</body>

</html>
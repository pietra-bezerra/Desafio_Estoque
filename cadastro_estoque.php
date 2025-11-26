<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP</title>

    <!-- Estilização -->
    <link rel="stylesheet" href="css/cadastro_estoque.css">
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
            <!-- <label for="pesquisa"><i class="bi bi-search"></i></label>
            <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar Produto"> -->
            <img src="assets/imgs/logo.png" alt="Logo" width="100px">
        </section>
        <header>
            <h2>Cadastro de Produtos</h2>
        </header>

        <section class="sec-form-prod">
            <form action="" class="caixa-form-prod" method="post">
                <div class="ladoUm">
                    <div class="caixa-input-prod">
                        <input type="text" id="nome" name="nome" placeholder="Nome do Produto">
                    </div>
                    <div class="caixa-input-prod">
                        <input type="text" id="descricao" name="descricao" placeholder="Descrição">
                    </div>
                    <div class="caixa-input-prod">
                        <input type="text" id="unidade" name="unidade" placeholder="Unidade De Medida">
                    </div>
                    <div class="caixa-input-prod">
                        <input type="number" id="quantidade" name="quantidade" placeholder="Quantidade">
                    </div>
                </div>
                <div class="ladoDois">
                    <header>
                        <h1>Adicionar</h1>
                    </header>
                    <div class="caixa-input-prod">
                        <input type="number" id="minimo" name="minimo" placeholder="Mínimo">
                    </div>
                    <button>Cadastrar</button>
                </div>
            </form>

        </section>


    </main>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sv = "localhost";
        $user = "root";
        $pass = "";
        $db = "desafio_estoque";
        $port = 3312;

        $con = mysqli_connect($sv, $user, $pass, $db, $port);

        $criandoTab =  "CREATE TABLE IF NOT EXISTS gestao(
                idgestao INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(100) NOT NULL,
                descricao VARCHAR(500) NOT NULL,
                unidade VARCHAR(100) NOT NULL,
                quantidade INT(100),
                minimo INT(100)
            )";

        mysqli_query($con, $criandoTab);

        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $unidade = $_POST['unidade'];
        $quantidade = $_POST['quantidade'];
        $minimo = $_POST['minimo'];

        $inserindo = "INSERT INTO gestao(
                nome,
                descricao,
                unidade,
                quantidade,
                minimo
            )VALUES(
                '$nome',
                '$descricao',
                '$unidade',
                '$quantidade',
                '$minimo'
            )";

        mysqli_query($con, $inserindo);
    }

    ?>


</body>

</html>
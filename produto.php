<?php
session_start();
#inicio sessao

# verifico se o usuario está logado se não estiver mando para o login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

# salvo o valor da variavel de sessao com o nome do usuario em uma variavel comum
$user_name = $_SESSION['user_nome'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP - Cadastro de Produtos</title>

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/produto.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="assets/imgs/logo.png" type="image/x-icon">

</head>

<body>
    <?php include 'php/componentes/nav.php';
    # incluo na página a navbar 
    ?>

    <main class="main-container">
        <?php
        if (isset($_SESSION['sucesso'])) {
            echo "<div class='modalzinha-fundo' style='display:flex;'><div class='modal'>";
            echo "<p>".$_SESSION['sucesso']. "</p>";
            echo "<button onclick=\"document.querySelector('.modalzinha-fundo').style.display='none'\">OK</button>";
            echo "</div></div>";
            unset($_SESSION['sucesso']);
        }

        ?>
        <section class="sec-config">
            <h1 class="titulo-pagina">Cadastro de Produtos 📦</h1>
            <img src="assets/imgs/logo.png" class="logo-pagina">
        </section>

        <header class="header-desc">
            <h2 class="subtitulo">Insira os dados do novo item.</h2>
            <p class="legenda">Todos os campos são obrigatórios.</p>
        </header>

        <section class="form-section">

            <form method="POST" action="php/produtos/cad_produto.php" class="form-produto" onsubmit="return validarCadastroProduto()">

                <div class="coluna-esquerda">

                    <h3 class="box-titulo">Detalhes do Produto</h3>

                    <div class="caixa-input-prod">
                        <label>Nome do Produto</label>
                        <input type="text" name="nome" placeholder="Ex: Parafuso Sextavado M10" required>
                        <?php
                        if (isset($_SESSION['erro'])) {
                            echo "<p style='color:red'>" . $_SESSION['erro'] . "</p>";
                            unset($_SESSION['erro']);
                        }
                        ?>
                    </div>

                    <div class="caixa-input-prod">
                        <label>Descrição Detalhada</label>
                        <input type="text" name="descricao" placeholder="Ex: Aço inox, 50mm" required>
                    </div>

                    <div class="linha-dupla">

                        <div class="caixa-input-prod">
                            <label>Unidade de Medida</label>
                            <!-- <input type="text" name="unidade" placeholder="UN, KG, METRO" required> -->
                            <select name="unidade" id="unidade">
                                <option value="sem Valor" disabled selected>Selecione uma Opção</option>
                                <option value="UNIDADE">UN</option>
                                <option value="QUILOGRAMA">KG</option>
                                <option value="METRO">M</option>
                                <option value="MILILITRO">ML</option>
                                <option value="CENTIMETRO">CM</option>
                                <option value="CAIXA">CAIXA</option>
                                <option value="PACOTE">PACOTE</option>
                            </select>
                            <p id="erro-msg-unidade" style="color: red;"></p>
                        </div>

                        <div class="caixa-input-prod">
                            <label>Quantidade Inicial</label>
                            <input type="number" name="quantidade" min="0" placeholder="0" required>
                        </div>

                    </div>
                </div>

                <div class="coluna-direita">

                    <header>
                        <h1 class="parametro-titulo">Parâmetros</h1>
                        <p class="legenda">Ponto de reabastecimento.</p>
                    </header>

                    <div class="caixa-input-prod">
                        <label>Estoque Mínimo</label>
                        <input type="number" name="minimo" min="0" placeholder="50" required>
                    </div>

                    <button type="submit" class="btn-cadastro">
                        <i class="bi bi-plus-circle-fill"></i> Cadastrar Produto
                    </button>

                </div>
            </form>
        </section>
    </main>

    <script src="scripts/script.js" defer></script>
</body>

</html>
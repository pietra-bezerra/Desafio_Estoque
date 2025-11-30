<?php
// 1. Inicia a sessão (necessário para checar a autenticação)
session_start();

// 2. Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    // Se não estiver logado, redireciona para a tela de login
    header("Location: index.php");
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
    <title>ERP</title>

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/estoque.css">
    <link rel="stylesheet" href="css/nav.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@100..900&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="assets/imgs/logo.png" type="image/x-icon">
</head>

<body>

    <?php include 'php/componentes/nav.php'; ?>

    <main class="conteudo-principal">

        <section class="sec-config">
            <div class="caixa-pesquisa">
                <label for="pesquisa" class="icone-pesquisa"><i class="bi bi-search"></i></label>
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar Produto...">
            </div>
            <img src="assets/imgs/logo.png" class="logo-sec">
        </section>

        <header class="cabecalho">
            <h2 class="titulo-principal">Gestão de Estoque</h2>
            <button id="add_movimentacao" onclick="showMovimentacao()" class="botao-add">
                <i class="bi bi-plus-circle"></i>
                <span>Adicionar Movimentação</span>
            </button>
        </header>

        <div class="caixa-tabela">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Unidade</th>
                        <th>Quantidade</th>
                        <th>Mínimo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require "php/conectar.php";

                    $coletando = "SELECT * FROM gestao";
                    $executando = mysqli_query($conn, $coletando);

                    if (mysqli_num_rows($executando) > 0) {
                        while ($linha = mysqli_fetch_array($executando)) {
                            echo "<tr>";
                            echo "<td>" . $linha['idgestao'] . "</td>";
                            echo "<td>" . $linha['nome'] . "</td>";
                            echo "<td>" . $linha['descricao'] . "</td>";
                            echo "<td>" . $linha['unidade'] . "</td>";
                            if ($linha['quantidade'] == 0) {
                                echo "<td class='alerta-baixo' title='⚠ Sem Estoque' style='color: red;'> SEM ESTOQUE </td>";
                            } else if ($linha['quantidade'] <= $linha['minimo']) {
                                echo "<td class='alerta-baixo' title='⚠ Alerta Estoque Baixo'>" . $linha['quantidade'] . "</td>";
                            } else {
                                echo "<td>" . $linha['quantidade'] . "</td>";
                            }
                            echo "<td>" . $linha['minimo'] . "</td>";
                            include "php/componentes/btn-acoes.php";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Nenhum Produto Registrado.</td></tr>";
                    }

                    mysqli_close($conn);

                    ?>

                    <!-- Exemplo de linha — mesma ideia para os outros -->
                    <!-- <tr>
                        <td>1</td>
                        <td>Cimento</td>
                        <td>Clíquer, gesso</td>
                        <td>50 Kg</td>
                        <td class="alerta-baixo">10</td>
                        <td>15</td>
                        <td>
                            <div class="caixa-acoes">
                                <button onclick="showEdit()" class="botao-editar"><i class="bi bi-pencil-square"></i><span>Editar</span></button>
                                <button class="botao-remover"><i class="bi bi-trash3-fill"></i><span>Remover</span></button>
                            </div>
                        </td>
                    </tr> -->

                </tbody>
            </table>
        </div>

    </main>

    <!-- MODAL DE MOVIMENTAÇÃO -->
    <section class="modal-fundo" id="modalMovimentacao">
        <form class="modal-form" action="php/cad_movimentacao.php" method="POST">
            <button type="button" onclick="closeMovimentacao()" class="modal-close"><i class="bi bi-x"></i></button>

            <h3 class="modal-titulo">Registrar Movimentação</h3>

            <div class="modal-linha">
                <div class="modal-item">
                    <label>Produto</label>
                    <!-- <input type="number"> -->
                    <select name="produto" id="produto">
                        <!-- <option disabled selected>Selecione uma Opção</option> -->
                        <?php
                        require "php/conectar.php";

                        $coletando = "SELECT idgestao, nome FROM gestao";
                        $executando = mysqli_query($conn, $coletando);
                        if (mysqli_num_rows($executando) > 0) {
                            echo "<option disabled selected>Selecione uma Opção</option>";
                            while ($linha = mysqli_fetch_array($executando)) {
                                // echo "<option value='".$linha['idgestao']."'>".$linha['nome']."</option>";
                                echo "<option value='" . $linha['idgestao'] . "'>" . $linha['nome'] . "</option>";
                            }
                        } else {
                            echo "<option disbled select>Nenhum Produto Registrado</option>";
                        }

                        mysqli_close($conn);
                        ?>
                    </select>
                </div>
                <div class="modal-item">
                    <label>Tipo de Movimentação</label>
                    <select name='tipo' id="tipo">
                        <option disabled selected>Selecione uma Opção</option>
                        <option value='Entrada'>Entrada</option>
                        <option value='Saída'>Saída</option>
                    </select>
                </div>
            </div>

            <div class="modal-linha">
                <div class="modal-item">
                    <label>Quantidade</label>
                    <input type="number" id='quantidade' name="quantidade" min=1>
                </div>
                <div class="modal-item" style="display: none;">
                    <label>Data</label>
                    <input type="date">
                </div>
            </div>

            <button class="botao-confirmar"><i class="bi bi-box-arrow-in-right"></i>Cadastrar Movimentação</button>

        </form>
    </section>

    <!-- MODAL EDIT -->
    <section class="modal-fundo" id="modalEdicao">
        <form class="modal-form" action="php/editar_produto.php" method="POST">
            <button type="button" onclick="closeEdit()" class="modal-close"><i class="bi bi-x"></i></button>

            <h3 class="modal-titulo">Editar Produto</h3>

            <div class="modal-item" style="display: none;">
                <label>ID Produto</label>
                <input type="number" name="edit-id" id="edit-id" value="sem Valor">
            </div>

            <div class="modal-item">
                <label>Nome Produto</label>
                <input type="text" name="edit-produto" id="edit-produto">
            </div>

            <div class="modal-item">
                <label>Descrição</label>
                <input type="text" name="edit-descricao" id="edit-descricao">
            </div>

            <div class="modal-item">
                <label>Unidade</label>
                <input type="text" name="edit-unidade" id="edit-unidade">
            </div>

            <div class="modal-item">
                <label>Estoque Mínimo</label>
                <input type="number" name="edit-minimo" id="edit-minimo">
            </div>

            <button class="botao-confirmar" type="submit"><i class="bi bi-save"></i>Salvar Alterações</button>
        </form>
    </section>
    <script>
        document.getElementById('pesquisa').addEventListener('input', function() {
            const termo = this.value.toLowerCase();
            const linhas = document.querySelectorAll('tbody tr');

            linhas.forEach(linha => {
                const textoLinha = linha.innerText.toLowerCase();

                if (textoLinha.includes(termo)) {
                    linha.style.display = '';
                } else {
                    linha.style.display = 'none';
                }
            });
        });
    </script>
    <script src="scripts/script.js" defer></script>
</body>

</html>
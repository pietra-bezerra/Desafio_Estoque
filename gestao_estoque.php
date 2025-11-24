<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP</title>

    <!-- Estilização -->
    <link rel="stylesheet" href="css/gestao_estoque.css">
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
            <label for="pesquisa"><i class="bi bi-search"></i></label>
            <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar Produto">
            <img src="assets/imgs/logo.png" alt="Logo" width="100px">
        </section>
        <header>
            <h2>Gestão de Estoque</h2>
        </header>
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
                <!-- Só coloquei para testes tem que substituir pelos itens cadastrados no banco -->
                <tr>
                    <td>1</td>
                    <td>Cimento</td>
                    <td>Clíquer, gesso</td>
                    <td>50 Kg</td>
                    <td>20</td>
                    <td>15</td>
                    <td>
                        <div>
                            <button id="editar">Editar<i class="bi bi-pencil-square"></i></button>
                            <button id="remover">Remover<i class="bi bi-trash3-fill"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Cimento</td>
                    <td>Clíquer, gesso</td>
                    <td>50 Kg</td>
                    <td>20</td>
                    <td>15</td>
                    <td>
                        <div>
                            <button id="editar">Editar<i class="bi bi-pencil-square"></i></button>
                            <button id="remover">Remover<i class="bi bi-trash3-fill"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Cimento</td>
                    <td>Clíquer, gesso</td>
                    <td>50 Kg</td>
                    <td>20</td>
                    <td>15</td>
                    <td>
                        <div>
                            <button id="editar">Editar<i class="bi bi-pencil-square"></i></button>
                            <button id="remover">Remover<i class="bi bi-trash3-fill"></i></button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <button id="add_movimentacao" onclick="showMovimentacao()">Adicionar Movimentação</button>

    </main>

    <section class="caixa-sec-movimentacao">
        <form action="" class="caixa-form-movimentacao">
            <button id="btnDiferente" onclick="document.querySelector('.caixa-sec-movimentacao').style.display = 'none'"><i class="bi bi-x"></i></button>
            <div class="caixa-div-movimentacao">
                <div class="caixa-input-movimentacao">
                    <label for="id_produto"><i class="bi bi-box-fill"></i>ID</label>
                    <input type="number" id="id_produto" name="id_produto" placeholder="ID do Produto">
                </div>
                <div class="caixa-input-movimentacao">
                    <label for="entrada_saida"><i class="bi bi-box-arrow-right"></i>Entrada & Saída</label>
                    <select name="entrada_saida" id="entrada_saida" name="entrada_saida">
                        <option value="Sem Valor" disabled selected>Selecione uma Opção</option>
                        <option value="Entrada">Entrada</option>
                        <option value="Saída">Saída</option>
                    </select>
                </div>
                <div class="caixa-input-movimentacao">
                    <label for="data_movimentacao"><i class="bi bi-calendar-date-fill"></i>Data Movimentação</label>
                    <input type="date" id="data_movimentacao" value="">
                </div>
            </div>
            <div class="caixa-btn-movimentacao">
                <button type="submit">Cadastrar <i class="bi bi-box-arrow-in-right"></i></button>
            </div>
        </form>
    </section>

<section class="caixa-sec-edit">
    <form action="" class="caixa-form-edit">
        <button type="button" class="btnFecharEdit" onclick="fecharEdit()"><i class="bi bi-x"></i></button>

        <div class="caixa-div-edit">
            <div class="caixa-input-edit">
                <label for="edit_nome">Nome Produto</label>
                <input type="text" id="edit_nome" name="nome">
            </div>

            <div class="caixa-input-edit">
                <label for="edit_descricao">Descrição</label>
                <input type="text" id="edit_descricao" name="descricao">
            </div>

            <div class="caixa-input-edit">
                <label for="edit_unidade">Unidade</label>
                <input type="text" id="edit_unidade" name="unidade">
            </div>

            <div class="caixa-input-edit">
                <label for="edit_quantidade">Quantidade</label>
                <input type="number" id="edit_quantidade" name="quantidade">
            </div>

            <div class="caixa-input-edit">
                <label for="edit_minimo">Mínimo</label>
                <input type="number" id="edit_minimo" name="minimo">
            </div>

            <div class="caixa-btn-edit">
                <button type="submit">Salvar</button>
            </div>
        </div>
    </form>
</section>


    <script src="scripts/script.js" defer></script>


</body>

</html>
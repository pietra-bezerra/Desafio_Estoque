<?php
# inicio a sessão
session_start();

# caso o usuario não estiver logado mando ele para tela de login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

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

    <?php include 'php/componentes/nav.php'; # incluo na página a navbar ?>

    <main class="conteudo-principal">

        <section class="sec-config">
            <div class="caixa-pesquisa">
                <label for="pesquisa" class="icone-pesquisa"><i class="bi bi-search"></i></label>
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar Produto..." oninput="pesquisar()">
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
                    # inicio conexao

                    $coletando = "SELECT * FROM gestao";
                    $executando = mysqli_query($conn, $coletando);
                    # coleto todos os produtos

                    # se tiver algum registro execute...
                    if (mysqli_num_rows($executando) > 0) {
                        while ($linha = mysqli_fetch_array($executando)) {
                            echo "<tr>";
                            echo "<td>" . $linha['idgestao'] . "</td>";
                            echo "<td>" . $linha['nome'] . "</td>";
                            echo "<td>" . $linha['descricao'] . "</td>";
                            echo "<td>" . $linha['unidade'] . "</td>";
                            # se a quantidade for 0, exibo uma celula com a classe alerta baixo, um title (aparece quando você deixa o cursor encima) e o texto com cor vermelha informando que estamos sem estoque
                            if ($linha['quantidade'] == 0) {
                                echo "<td class='alerta-baixo' title='⚠ Sem Estoque' style='color: red;'> SEM ESTOQUE </td>";
                                # caso a quantidade seja menor ou igual ao minimo a celula exibida terá classe alerta-baixo com um title informando que estamos com estoque baixo
                            } else if ($linha['quantidade'] <= $linha['minimo']) {
                                echo "<td class='alerta-baixo' title='⚠ Alerta Estoque Baixo'>" . $linha['quantidade'] . "</td>";
                            } else {
                                # aqui exibo a quantidade normalmente, já que não estamos com estoque baixo ou sem estoque
                                echo "<td>" . $linha['quantidade'] . "</td>";
                            }
                            echo "<td>" . $linha['minimo'] . "</td>";
                            include "php/componentes/btn-acoes.php"; # inclui os botões de ação para os produto
                            echo "</tr>";
                        }
                        # caso contrario exiba uma linha com uma celula que ocupe 7 colunas informando que nenhum produto foi registrado 
                    } else {
                        echo "<tr><td colspan='7'>Nenhum Produto Registrado.</td></tr>";
                    }

                    mysqli_close($conn);
                    # fecho a conexao
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
        <form class="modal-form" action="php/cad_movimentacao.php" method="POST" onsubmit="return validarMovimentacao()">
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
                        # conecto no banco
                        
                        $coletando = "SELECT idgestao, nome, quantidade FROM gestao";
                        $executando = mysqli_query($conn, $coletando);
                        # coleto o id, nome e quantidade dos produtos cadastrados
                        
                        # se o numero de linhas for maior q 0 ou seja exista algum produto cadastrado execute... 
                        if (mysqli_num_rows($executando) > 0) {
                            echo "<option disabled selected>Selecione uma Opção</option>";
                            while ($linha = mysqli_fetch_array($executando)) {
                                // echo "<option value='".$linha['idgestao']."'>".$linha['nome']."</option>";
                                echo "<option value='" . $linha['idgestao'] . "'data-qntd='".$linha['quantidade']."'>" . $linha['nome'] . "</option>";
                            }
                            # caso contrario informe que não temos produtos registrados
                        } else {
                            echo "<option disbled select>Nenhum Produto Registrado</option>";
                        }
                        
                        mysqli_close($conn);
                        # fecho a conexão
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
            
            <p id="erro-msg" style="color: red;"></p>
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
    <script src="scripts/script.js" defer></script>
</body>

</html>
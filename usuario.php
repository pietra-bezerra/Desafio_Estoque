<?php
# inicio a sessão
session_start();

# verifico se não está logado, caso realmente não esteja mando de volta pro index.php
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

# caso o usuario não tiver permissão nível ADMIN e tente acessar essa página mando ele para a dashboard no caso principal.php
if ($_SESSION['user_permissao'] != "ADMIN") {
    header("Location: principal.php");
    exit;
}

# coleto o nome do usuario
$user_name = $_SESSION['user_nome'];
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlockStone - Controle</title>

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

    <?php include 'php/componentes/nav.php'; # incluo a navbar 
    ?>

    <main class="conteudo-principal">

        <section class="sec-config">
            <div class="caixa-pesquisa">
                <label for="pesquisa" class="icone-pesquisa"><i class="bi bi-search"></i></label>
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar Usuário..." oninput="pesquisar()">
            </div>
            <img src="assets/imgs/logo.png" class="logo-sec">
        </section>

        <header class="cabecalho">
            <h2 class="titulo-principal">Gestão de Usuários</h2>
            <button id="add_movimentacao" onclick="showMovimentacao()" class="botao-add">
                <i class="bi bi-plus-circle"></i>
                <span>Adicionar Usuário</span>
            </button>
        </header>

        <div class="caixa-tabela">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>CPF</th>
                        <th>Senha</th>
                        <th>Permissão</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require "php/conectar.php";
                    # conecto no banco de dados

                    # exibo as informações cadastradas de todos os funcionarios se tiver algum registro
                    $coletando = "SELECT * FROM usuarios";
                    $executando = mysqli_query($conn, $coletando);
                    if (mysqli_num_rows($executando) > 0) {
                        while ($linha = mysqli_fetch_array($executando)) {
                            echo "<tr>";
                            echo "<td>" . $linha['id'] . "</td>";
                            echo "<td>" . htmlspecialchars($linha['nome']) . "</td>";
                            echo "<td>" . htmlspecialchars($linha['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($linha['cpf']) . "</td>";
                            echo "<td> ****** </td>";
                            echo "<td>" . $linha['permissao'] . "</td>";
                            include "php/componentes/btn-acoes-users.php"; # inclui os botoes de ações (editar e excluir usuários)
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Nenhum Usuário Registrado.</td></tr>";
                    }

                    mysqli_close($conn);
                    # fechei a conexao
                    ?>

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

    <!-- MODAL DE cadastro -->
    <section class="modal-fundo" id="modalMovimentacao" <?php if(isset($_SESSION['sucesso']) || isset($_SESSION['erro_nome']) || isset($_SESSION['erro_cpf']) || isset($_SESSION['erro_email'])) echo "style='display:flex;'";  ?>>
        <form class="modal-form" action="php/usuarios/cad_usuario.php" method="POST" onsubmit="return validarCPF()">
            <button type="button" onclick="closeMovimentacao2()" class="modal-close"><i class="bi bi-x"></i></button>

            <h3 class="modal-titulo">Adicionar Usuário</h3>
            <?php if (isset($_SESSION['sucesso']))
                echo '<div style="background:#4F46E5; color:#FFF; padding:12px; border-radius:8px;
                                    width:100%; max-width:750px; margin:10px auto; text-align:center; 
                                    font-weight:bold;"><p>' . $_SESSION['sucesso'] . "</p></div>";
                unset($_SESSION['sucesso']);
            ?>
            <div class="modal-linha">
                <div class="modal-item">
                    <label>Nome</label>
                    <input type="text" name="nome" id="nome" placeholder="Exemplo" required>
                    <?php if (isset($_SESSION['erro_nome'])) echo "<p style='color:red;'>Nome de Usuário já utilizado!</p>"; unset($_SESSION['erro_nome']); ?>
                </div>
                <div class="modal-item">
                    <label>E-mail</label>
                    <input type="email" name="email" id="email" placeholder="exemplo@exemplo.com" required>
                    <?php if (isset($_SESSION['erro_email'])) echo "<p style='color:red;'>E-mail já utilizado!</p>"; unset($_SESSION['erro_email']); ?>
                </div>
            </div>
            
            <div class="modal-linha">
                <div class="modal-item">
                    <label>Senha</label>
                    <input type="password" id='senha' name="senha" minlength="6" placeholder="******" required>
                </div>
                <div class="modal-item">
                    <label>CPF</label>
                    <input type="text" name="cpf" id="cpf" placeholder="123.456.789-10" oninput="maskCPF(this)" maxlength="14" required>
                    <p id="erro-msg-cpf" style="color: red;"></p>
                    <?php if (isset($_SESSION['erro_cpf'])) echo "<p style='color:red;'>CPF já utilizado!</p>"; unset($_SESSION['erro_cpf']); ?>
                </div>
            </div>
            
            <div class="modal-item">
                <label>Nível de Permissão</label>
                <select name="permissao" id="permissao">
                    <!-- <option value="" disabled selected>Selecione uma Opção</option> -->
                    <option value="PADRAO">PADRÃO</option>
                    <option value="ADMIN">ADMIN</option>
                </select>
            </div>
            
            <button class="botao-confirmar"><i class="bi bi-box-arrow-in-right"></i>Cadastrar Usuário</button>
            
        </form>
    </section>
    
    <!-- MODAL EDIT -->
    <section class="modal-fundo" id="modalEdicao" <?php if(isset($_SESSION['sucesso2']) || isset($_SESSION['erro_nome2']) || isset($_SESSION['erro_cpf2']) || isset($_SESSION['erro_email2'])) echo "style='display:flex;'";  ?>>
        <form class="modal-form" action="php/usuarios/editar_usuario.php" method="POST" onsubmit="return validarEditCPF()">
            <button type="button" onclick="closeEdit2()" class="modal-close"><i class="bi bi-x"></i></button>
            
            <h3 class="modal-titulo">Editar Usuário:</h3>

            <?php if (isset($_SESSION['sucesso2']))
                echo '<div style="background:#4F46E5; color:#FFF; padding:12px; border-radius:8px;
                                    width:100%; max-width:750px; margin:10px auto; text-align:center; 
                                    font-weight:bold;"><p>' . $_SESSION['sucesso2'] . "</p></div>";
                unset($_SESSION['sucesso2']);
            ?>
            
            <div class="modal-item" style="display: none;">
                <label>ID Usuário</label>
                <input type="number" name="edit-id" id="edit-id" <?php if(isset($_SESSION['previne2'])) echo "value='".$_SESSION['previne2']."'"; unset($_SESSION['previne2']); ?>>
            </div>
            
            <div class="modal-item">
                <label>Nome</label>
                <input type="text" name="edit-nome" id="edit-nome">
                <?php if (isset($_SESSION['erro_nome2'])) echo "<p style='color:red;'>Nome de Usuário já utilizado!</p>"; unset($_SESSION['erro_nome2']); ?>
            </div>
            
            <div class="modal-item">
                <label>E-mail</label>
                <input type="email" name="edit-email" id="edit-email">
                <?php if (isset($_SESSION['erro_email2'])) echo "<p style='color:red;'>E-mail já utilizado!</p>"; unset($_SESSION['erro_email2']); ?>
            </div>
            
            <div class="modal-item">
                <label>CPF</label>
                <input type="text" name="edit-cpf" id="edit-cpf" oninput="maskCPF(this)" maxlength="14">
                <p id="erro-msg-edit-cpf" style="color:red;"></p>
                <?php if (isset($_SESSION['erro_cpf2'])) echo "<p style='color:red;'>CPF já utilizado!</p>"; unset($_SESSION['erro_cpf2']); ?>
            </div>
            
            <div class="modal-item">
                <label>Senha</label>
                <input type="password" name="edit-senha" id="edit-senha" minlength="6">
            </div>

            <div class="modal-item">
                <label>Permissão</label>
                <!-- <input type="number" name="edit-minimo" id="edit-minimo"> -->
                <select name="edit-permissao" id="edit-permissao">
                    <option value='' selected>Selecione uma Opção</option>
                    <option value="PADRAO">PADRÃO</option>
                    <option value="ADMIN">ADMIN</option>
                </select>
            </div>

            <button class="botao-confirmar" type="submit"><i class="bi bi-save"></i>Salvar Alterações</button>
        </form>
    </section>

    <script src="scripts/script.js" defer></script>
</body>

</html>
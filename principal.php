<?php
# inicio a sessão
session_start();

# aqui verifico se se a variavel de sessao que armazena o id do usuario existe
# ou seja verifico se ele realmente esta logado
if (!isset($_SESSION['user_id'])) {
    # so uma obs: isset verifica se uma variavel existe e tem algum valor, !isset estamos negando então fica: se a váriavel de user_id não existir execute...
    # caso nao estiver mando ele para a tela de login no caso nosso index.php
    header("Location: index.php");
    exit;
    # encerro a execução do código
}

# armazeno o nome do usuario logado em uma variavel
$user_name = $_SESSION['user_nome'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP - Dashboard</title>

    <!-- Fonte e CSS -->
    <link rel="stylesheet" href="css/principal.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="shortcut icon" href="assets/imgs/logo.png" type="image/x-icon">
</head>

<body>

    <?php
    include "php/componentes/nav.php";
    # incluo na página a navbar (sidebar)
    require 'php/conectar.php';

    $sql = "SELECT * FROM gestao WHERE quantidade <= minimo";
    $executando = mysqli_query($conn,$sql);
    $qntd = mysqli_num_rows($executando);

    if($qntd > 0){
        echo "<div class='modalzinha-fundo' style='display:flex;'><div class='modal'>";
        echo "<h3>ALERTA</h3>";
        echo "<p>Estamos com estoque baixo: $qntd Produtos</p>";
        echo "<button onclick=\"document.querySelector('.modalzinha-fundo').style.display='none'\">OK</button>";
        echo "</div></div>";
    }

    ?>

    <!-- Conteúdo -->
    <main class="main-conteudo">

        <!-- Topo -->
        <section class="sec-config">
            <div class="sec-config-info">
                <div class="sec-config-avatar">
                    <!-- aqui eu é onde fica uma fotinha/avatar do usuario -->
                     <!-- pegamos a variavel que contem o nome do usuario então subtraimos ela, começando da primeira letra 0 e como queremos q ela fique somente com a 1° letra
                        colocamos 1 de length -->
                    <?php echo substr($user_name, 0, 1); ?>
                </div>
                <div>
                    <!-- uma mensagem personalizada com o nome do usuario logado, htmlspecialchars() é uma forma de exibir uma informação com segurança, evitando xss -->
                    <p class="sec-config-nome">Olá, <?php echo htmlspecialchars($user_name); ?>!</p>
                    <small>Bem-vindo(a) ao seu painel de controle.</small>
                </div>
            </div>
            <img src="assets/imgs/logo3.png" class="sec-config-logo">
        </section>

        <header class="sec-titulo">
            <h2>Gerenciamento Estoque</h2>
        </header>

        <!-- Cards -->
        <section class="sec-caixas">

            <div class="dashboard-card card-saida">
                <div class="card-topo">
                    <h4>Saída (Últimas 24h)</h4>
                    <i class="bi bi-arrow-down-right-circle"></i>
                </div>
                <h2 class="card-numero"><?php 
                    require "php/conectar.php";
                    # conecto no banco

                    $coletandoEstoque = "SELECT idmovimentacao FROM movimentacao WHERE tipo = 'Saída' AND data_movimentacao >= NOW() - INTERVAL 1 DAY ";
                    # faço um select colentando o id da movimentacao quando o tipo for saida e a data da movimentacao for maior ou igual ao intervalo de 24hrs
                    $executando = mysqli_query($conn,$coletandoEstoque);
                    $numero = mysqli_num_rows($executando);
                    # executamos e salvamos o numero de linhas na variavel numero

                    echo $numero;
                    # exibo o numero (no caso seria o numero de movimentacoes que aconteceram nas ultimas 24hrs)
                    mysqli_close($conn);
                    # fecho a conexao
                ?></h2>
                <p>Movimentação recente</p>
            </div>

            <div class="dashboard-card card-minimo">
                <div class="card-topo">
                    <h4>Produtos no Mínimo ou Sem Estoque</h4>
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <h2 class="card-numero"><?php 
                    require "php/conectar.php";
                    # conecto no banco de dados

                    $coletandoEstoque = "SELECT idgestao FROM gestao WHERE quantidade <= minimo";
                    $executando = mysqli_query($conn,$coletandoEstoque);
                    $numero = mysqli_num_rows($executando);
                    # coleto e armazeno o numero de produtos que estao com a quantidade abaixo ou igual ao minimo

                    echo $numero;
                    # exibo esse numero

                    mysqli_close($conn);
                    # fecho a conexao
                ?></h2>
                <p>Exige atenção imediata</p>
            </div>

            <div class="dashboard-card card-total">
                <div class="card-topo">
                    <h4>Total em Estoque</h4>
                    <i class="bi bi-box"></i>
                </div>
                <h2 class="card-numero"><?php 
                    require "php/conectar.php";
                    # coneco no banco
                    $coletandoEstoque = "SELECT idgestao FROM gestao";
                    $executando = mysqli_query($conn,$coletandoEstoque);
                    $numero = mysqli_num_rows($executando);

                    echo $numero;
                    # exibo o numero de produtos que estao cadastrados

                    mysqli_close($conn);
                    #fecho a conexao
                ?></h2>
                <p>Itens em prateleira</p>
            </div>

        </section>

        <!-- Tabela -->
        <section class="sec-tabela">
            <h3>Últimas Movimentações</h3>

            <div class="tabela-wrapper">
                <table class="tabela">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Status</th>
                            <th>Tipo</th>
                            <th>Quantidade</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require "php/conectar.php";

                        $coletando = "SELECT * FROM movimentacao ORDER BY data_movimentacao DESC LIMIT 5";
                        $executando = mysqli_query($conn, $coletando);
                        # executo um select que me retornara as 5 movimentacoes ordenadas da mais recente para a mais antiga
                        
                        # se o select tiver mais de 0 linhas ou seja se exitir movimentacoes execute...
                        if (mysqli_num_rows($executando) > 0) {
                            while ($linha = mysqli_fetch_array($executando)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($linha['nome']) . "</td>";
                                if($linha['status_produto'] == "ATIVO"){
                                    # quando o status do pedido for ativo a celula ganha classe ativa
                                    echo "<td class='ativo'>" . $linha['status_produto'] . "</td>";
                                } else{
                                    # caso contrario a celular ganha classe deletado
                                    echo "<td class='deletado'>" . $linha['status_produto'] . "</td>";
                                }
                                echo "<td>" . $linha['tipo'] . "</td>";
                                if($linha['tipo'] == "Entrada"){
                                    # se o tipo de movimentacao for entrada, a celular ganha classe entrada e um + antes da quantidade movimentada
                                    echo "<td class='entrada'> +" . $linha['quantidade'] . "</td>";
                                } else{
                                    # caso contrario a celula ganha classe saida e um - antes da quantidade movimentada
                                    echo "<td class='saida'> -" . $linha['quantidade'] . "</td>";
                                }
                                # aqui eu converto a data movimentacao de string para time e mostro a data no formato dia/mes/ano Horas:minutos
                                echo "<td>" . date('d/m/Y H:i', strtotime($linha['data_movimentacao'])) . "</td>";
                                echo "</tr>";
                            }
                            # caso não exista nenhuma movimentacao eu exibo na tabela uma linha com uma celula ocupando 6 colunas, informando que nao há movimentação registrada
                        } else {
                            echo "<tr><td colspan='6'>Nenhuma Movimentação Registrado.</td></tr>";
                        }

                        mysqli_close($conn);
                        # fecho a conexao com o banco

                        ?>
                        <!-- <tr>
                            <td>Teclado Mecânico X</td>
                            <td class="saida">Saída</td>
                            <td>-1</td>
                            <td>25/11/2025</td>
                        </tr>
                        <tr>
                            <td>Mouse Gamer G9</td>
                            <td class="entrada">Entrada</td>
                            <td>+5</td>
                            <td>24/11/2025</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </section>

    </main>
</body>

</html>
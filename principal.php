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
    ?>

    <!-- Conteúdo -->
    <main class="main-conteudo">

        <!-- Topo -->
        <section class="sec-config">
            <div class="sec-config-info">
                <div class="sec-config-avatar">
                    <?php echo substr($user_name, 0, 1); ?>
                </div>
                <div>
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

                    $coletandoEstoque = "SELECT idmovimentacao FROM movimentacao WHERE tipo = 'Saída' AND data_movimentacao >= NOW() - INTERVAL 1 DAY ";
                    $executando = mysqli_query($conn,$coletandoEstoque);
                    $numero = mysqli_num_rows($executando);

                    echo $numero;

                    mysqli_close($conn);
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

                    $coletandoEstoque = "SELECT idgestao FROM gestao WHERE quantidade <= minimo";
                    $executando = mysqli_query($conn,$coletandoEstoque);
                    $numero = mysqli_num_rows($executando);

                    echo $numero;

                    mysqli_close($conn);
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

                    $coletandoEstoque = "SELECT idgestao FROM gestao";
                    $executando = mysqli_query($conn,$coletandoEstoque);
                    $numero = mysqli_num_rows($executando);

                    echo $numero;

                    mysqli_close($conn);
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

                        $coletando = "SELECT * FROM movimentacao ORDER BY data_movimentacao DESC LIMIT 7";
                        $executando = mysqli_query($conn, $coletando);

                        if (mysqli_num_rows($executando) > 0) {
                            while ($linha = mysqli_fetch_array($executando)) {
                                echo "<tr>";
                                echo "<td>" . $linha['nome'] . "</td>";
                                if($linha['status_produto'] == "ATIVO"){
                                    echo "<td class='ativo'>" . $linha['status_produto'] . "</td>";
                                } else{
                                    echo "<td class='deletado'>" . $linha['status_produto'] . "</td>";
                                }
                                echo "<td>" . $linha['tipo'] . "</td>";
                                if($linha['tipo'] == "Entrada"){
                                    echo "<td class='entrada'> +" . $linha['quantidade'] . "</td>";
                                } else{
                                    echo "<td class='saida'> -" . $linha['quantidade'] . "</td>";
                                }
                                echo "<td>" . date('d/m/Y H:i', strtotime($linha['data_movimentacao'])) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Nenhum Produto Registrado.</td></tr>";
                        }

                        mysqli_close($conn);

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
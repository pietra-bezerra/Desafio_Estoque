<?php
// 1. Inicia a sessão (necessário para checar a autenticação)
session_start();

// 2. Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    // Se não estiver logado, redireciona para a tela de login
    header("Location: index.html?status=erro&msg=" . urlencode("Acesso restrito. Faça login para continuar."));
    exit;
}

// Obtém o nome do usuário da sessão para exibição
$user_name = $_SESSION['user_nome'] ?? 'Funcionário';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP - Dashboard</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons (já estava no seu original) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Configuração da Fonte e Estilos -->
    <style>
        /* Define a fonte Geologica como a principal */
        @import url('https://fonts.googleapis.com/css2?family=Geologica:wght@100..900&display=swap');
        
        /* Configurações globais para o tema dark */
        body {
            font-family: 'Geologica', sans-serif;
            min-height: 100vh;
            display: flex; /* Para layout de sidebar + conteúdo */
            background-color: #111827; /* bg-gray-900 (Fundo principal dark) */
            color: #E5E7EB; /* text-gray-200 */
        }

        /* Classes customizadas para a barra lateral */
        .sidebar {
            width: 16rem; /* w-64 */
            flex-shrink: 0;
            background-color: #1F2937; /* bg-gray-800 */
        }

        /* Estilo para a imagem de perfil/logo na config */
        .sec-config img {
            transition: transform 0.3s ease;
        }
        .sec-config img:hover {
            transform: scale(1.05);
        }

        /* Estilo para os cards do dashboard */
        .dashboard-card {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -2px rgba(0, 0, 0, 0.5);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5), 0 4px 6px -4px rgba(0, 0, 0, 0.5);
        }
    </style>

    <!-- Icone da Página -->
    <link rel="shortcut icon" href="assets/imgs/logo.png" type="image/x-icon">
</head>

<body>
    
    <!-- BARRA DE NAVEGAÇÃO / SIDEBAR (Substitui 'php/componentes/nav.php') -->
    <nav class="sidebar p-4 border-r border-gray-700 h-screen sticky top-0">
        <!-- Logo e Título do Sistema -->
        <div class="flex items-center space-x-3 mb-8 pb-4 border-b border-gray-700">
            <img src="assets/imgs/logo.png" alt="Logo ERP" class="w-10 h-10 rounded-full">
            <h1 class="text-xl font-extrabold text-indigo-400">ERP System</h1>
        </div>
        
        <!-- Links de Navegação -->
        <div class="space-y-2">
            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-indigo-400 bg-gray-700 font-semibold hover:bg-gray-600 transition duration-150">
                <i class="bi bi-speedometer2 text-lg"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-150">
                <i class="bi bi-box-seam text-lg"></i>
                <span>Estoque</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-150">
                <i class="bi bi-cart4 text-lg"></i>
                <span>Vendas</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-150">
                <i class="bi bi-people text-lg"></i>
                <span>Clientes</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-150">
                <i class="bi bi-gear text-lg"></i>
                <span>Configurações</span>
            </a>
        </div>

        <!-- Botão de Sair -->
        <div class="absolute bottom-4 w-[calc(16rem-2rem)]">
            <a href="logout.php" class="flex items-center justify-center space-x-3 p-3 rounded-lg bg-red-600 text-white font-medium hover:bg-red-700 transition duration-150 w-full">
                <i class="bi bi-box-arrow-right text-lg"></i>
                <span>Sair</span>
            </a>
        </div>
    </nav>
    <!-- FIM DA SIDEBAR -->

    <!-- CONTEÚDO PRINCIPAL -->
    <main class="flex-1 p-6 md:p-10 main-conteudo">
        
        <!-- Seção de Configuração do Usuário (Topo) -->
        <section class="sec-config flex items-center justify-between pb-6 border-b border-gray-700 mb-8">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center text-xl font-bold">
                    <?php echo substr($user_name, 0, 1); // Inicial do nome ?>
                </div>
                <div>
                    <p class="text-xl font-semibold text-white">Olá, <?php echo htmlspecialchars($user_name); ?>!</p>
                    <small class="text-gray-400">Bem-vindo(a) ao seu painel de controle.</small>
                </div>
            </div>
            <!-- Logo Grande no Canto (Reduzida para ficar mais limpa no dark mode) -->
            <img src="assets/imgs/logo.png" alt="Logo" class="w-16 h-16 rounded-full opacity-75">
        </section>

        <!-- Título da Seção -->
        <header class="mb-8">
            <h2 class="text-3xl font-extrabold text-indigo-400 tracking-tight">Gerenciamento Estoque</h2>
        </header>

        <!-- Seção dos Caixas (Cards de KPI) -->
        <section class="sec-caixas grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-8">
            
            <!-- Card de SAÍDA -->
            <div class="dashboard-card p-6 bg-gray-800 rounded-xl shadow-lg border-t-4 border-red-500">
                <div class="flex justify-between items-center">
                    <h4 class="caixa-titulo text-sm font-medium uppercase text-red-400">Saída (Últimas 24h)</h4>
                    <i class="bi bi-arrow-down-right-circle text-2xl text-red-500"></i>
                </div>
                <div class="caixa-numero mt-4">
                    <h2 class="text-4xl font-bold text-white">2</h2>
                </div>
                <p class="text-xs text-gray-500 mt-2">Movimentação recente</p>
            </div>
            
            <!-- Card de MÍNIMO (Alerta) -->
            <div class="dashboard-card p-6 bg-gray-800 rounded-xl shadow-lg border-t-4 border-yellow-500">
                <div class="flex justify-between items-center">
                    <h4 class="caixa-titulo text-sm font-medium uppercase text-yellow-400">Produtos no Mínimo</h4>
                    <i class="bi bi-exclamation-triangle text-2xl text-yellow-500"></i>
                </div>
                <div class="caixa-numero mt-4">
                    <h2 class="text-4xl font-bold text-white">1</h2>
                </div>
                <p class="text-xs text-gray-500 mt-2">Exige atenção imediata</p>
            </div>
            
            <!-- Card de ESTOQUE TOTAL -->
            <div class="dashboard-card p-6 bg-gray-800 rounded-xl shadow-lg border-t-4 border-green-500">
                <div class="flex justify-between items-center">
                    <h4 class="caixa-titulo text-sm font-medium uppercase text-green-400">Total em Estoque</h4>
                    <i class="bi bi-box text-2xl text-green-500"></i>
                </div>
                <div class="caixa-numero mt-4">
                    <h2 class="text-4xl font-bold text-white">4</h2>
                </div>
                <p class="text-xs text-gray-500 mt-2">Itens em prateleira</p>
            </div>

        </section>
        
        <!-- Conteúdo Adicional (Placeholder para a tabela de produtos) -->
        <section class="mt-10 p-6 bg-gray-800 rounded-xl border border-gray-700">
            <h3 class="text-xl font-semibold mb-4 text-indigo-300">Últimas Movimentações</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Produto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Quantidade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        <tr class="hover:bg-gray-700 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">Teclado Mecânico X</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-400">Saída</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">-1</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">25/11/2025</td>
                        </tr>
                        <tr class="hover:bg-gray-700 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">Mouse Gamer G9</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-400">Entrada</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">+5</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">24/11/2025</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

    </main>
</body>

</html>
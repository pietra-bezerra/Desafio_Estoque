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
    <title>ERP - Gestão de Estoque</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

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

        /* Estilo para a Tabela e Modal de Movimentação (Para imitar o CSS original onde não há classes Tailwind prontas) */
        
        .caixa-sec-movimentacao {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: none; /* Inicia oculto */
            justify-content: center;
            align-items: center;
            z-index: 100;
        }

        .caixa-form-movimentacao, .caixa-form-edit {
            background-color: #1F2937; /* bg-gray-800 */
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5), 0 4px 6px -4px rgba(0, 0, 0, 0.5);
            width: 90%;
            max-width: 500px;
            position: relative;
        }
    </style>

    <link rel="shortcut icon" href="assets/imgs/logo.png" type="image/x-icon">
</head>

<body>
    
    <nav class="sidebar p-4 border-r border-gray-700 h-screen sticky top-0">
        <div class="flex items-center space-x-3 mb-8 pb-4 border-b border-gray-700">
            <img src="assets/imgs/logo.png" alt="Logo ERP" class="w-10 h-10 rounded-full">
            <h1 class="text-xl font-extrabold text-indigo-400">ERP System</h1>
        </div>
        
        <div class="space-y-2">
            <a href="./principal.php" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-150">
                <i class="bi bi-speedometer2 text-lg"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-indigo-400 bg-gray-700 font-semibold hover:bg-gray-600 transition duration-150">
                <i class="bi bi-box-seam text-lg"></i>
                <span>Estoque</span>
            </a>
            <a href="./produtos.php" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-150">
                <i class="bi bi-cart4 text-lg"></i>
                <span>Produtos</span>
            </a>
        
            </a>
        </div>

        <div class="absolute bottom-4 w-[calc(16rem-2rem)]">
            <a href="./deus.html" class="flex items-center justify-center space-x-3 p-3 rounded-lg bg-red-600 text-white font-medium hover:bg-red-700 transition duration-150 w-full">
                <i class="bi bi-box-arrow-right text-lg"></i>
                <span>Sair</span>
            </a>
        </div>
    </nav>
    <main class="flex-1 p-6 md:p-10 main-conteudo">
        
        <section class="sec-config flex items-center justify-between pb-6 border-b border-gray-700 mb-8">
            <div class="flex items-center space-x-2 w-full max-w-md bg-gray-800 rounded-lg p-3 border border-gray-700">
                <label for="pesquisa" class="text-gray-400"><i class="bi bi-search text-xl"></i></label>
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar Produto..." class="bg-gray-800 focus:outline-none w-full text-white placeholder-gray-500">
            </div>
            <img src="assets/imgs/logo.png" alt="Logo" class="w-16 h-16 rounded-full opacity-75 hidden md:block">
        </section>

        <header class="mb-6 flex justify-between items-center">
            <h2 class="text-3xl font-extrabold text-indigo-400 tracking-tight">Gestão de Estoque</h2>
            <button id="add_movimentacao" onclick="showMovimentacao()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition duration-150 flex items-center space-x-2">
                <i class="bi bi-plus-circle"></i>
                <span>Adicionar Movimentação</span>
            </button>
        </header>

        <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-400">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Descrição</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Unidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Quantidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Mínimo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    <tr class="hover:bg-gray-700 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">1</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">Cimento</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">Clíquer, gesso</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">50 Kg</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-yellow-400">10</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">15</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <button onclick="showEdit()" class="flex items-center space-x-1 px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition duration-150">
                                    <i class="bi bi-pencil-square"></i>
                                    <span>Editar</span>
                                </button>
                                <button class="flex items-center space-x-1 px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition duration-150">
                                    <i class="bi bi-trash3-fill"></i>
                                    <span>Remover</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-700 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">2</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">Mouse Gamer G9</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">Mouse óptico RGB</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">Unidade</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-400">50</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">10</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <button onclick="showEdit()" class="flex items-center space-x-1 px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition duration-150">
                                    <i class="bi bi-pencil-square"></i>
                                    <span>Editar</span>
                                </button>
                                <button class="flex items-center space-x-1 px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition duration-150">
                                    <i class="bi bi-trash3-fill"></i>
                                    <span>Remover</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-700 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">3</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">Placa de Vídeo RTX</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">Placa de vídeo 12GB</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">Unidade</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-400">5</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">2</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <button onclick="showEdit()" class="flex items-center space-x-1 px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition duration-150">
                                    <i class="bi bi-pencil-square"></i>
                                    <span>Editar</span>
                                </button>
                                <button class="flex items-center space-x-1 px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition duration-150">
                                    <i class="bi bi-trash3-fill"></i>
                                    <span>Remover</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
    <section class="caixa-sec-movimentacao" id="modalMovimentacao">
        <form action="" class="caixa-form-movimentacao space-y-6">
            <button type="button" onclick="closeMovimentacao()" class="absolute top-3 right-3 text-gray-400 hover:text-white transition duration-150 p-1">
                <i class="bi bi-x text-2xl"></i>
            </button>
            <h3 class="text-2xl font-bold text-indigo-400 mb-6 border-b border-gray-700 pb-2">Registrar Movimentação</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="id_produto" class="text-gray-300 flex items-center space-x-2 font-medium">
                        <i class="bi bi-box-fill text-indigo-400"></i>
                        <span>ID do Produto</span>
                    </label>
                    <input type="number" id="id_produto" name="id_produto" placeholder="Ex: 101" class="w-full p-2.5 rounded-lg bg-gray-700 border border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 text-white">
                </div>

                <div class="space-y-2">
                    <label for="entrada_saida" class="text-gray-300 flex items-center space-x-2 font-medium">
                        <i class="bi bi-arrow-left-right text-indigo-400"></i>
                        <span>Tipo de Movimentação</span>
                    </label>
                    <select id="entrada_saida" name="entrada_saida" class="w-full p-2.5 rounded-lg bg-gray-700 border border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 text-white">
                        <option value="Sem Valor" disabled selected>Selecione uma Opção</option>
                        <option value="Entrada">Entrada</option>
                        <option value="Saída">Saída</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="quantidade_movimentacao" class="text-gray-300 flex items-center space-x-2 font-medium">
                        <i class="bi bi-hash text-indigo-400"></i>
                        <span>Quantidade</span>
                    </label>
                    <input type="number" id="quantidade_movimentacao" name="quantidade_movimentacao" placeholder="Ex: 5" class="w-full p-2.5 rounded-lg bg-gray-700 border border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 text-white">
                </div>
                
                <div class="space-y-2">
                    <label for="data_movimentacao" class="text-gray-300 flex items-center space-x-2 font-medium">
                        <i class="bi bi-calendar-date-fill text-indigo-400"></i>
                        <span>Data da Movimentação</span>
                    </label>
                    <input type="date" id="data_movimentacao" name="data_movimentacao" class="w-full p-2.5 rounded-lg bg-gray-700 border border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 text-white" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition duration-150 flex items-center justify-center space-x-2">
                    <span>Cadastrar Movimentação</span>
                    <i class="bi bi-box-arrow-in-right"></i>
                </button>
            </div>
        </form>
    </section>

    <section class="caixa-sec-movimentacao" id="modalEdicao">
        <form action="" class="caixa-form-edit space-y-6">
            <button type="button" onclick="closeEdit()" class="absolute top-3 right-3 text-gray-400 hover:text-white transition duration-150 p-1">
                <i class="bi bi-x text-2xl"></i>
            </button>
            <h3 class="text-2xl font-bold text-indigo-400 mb-6 border-b border-gray-700 pb-2">Editar Produto</h3>

            <div class="grid grid-cols-1 gap-4">
                <div class="space-y-2">
                    <label for="edit_nome" class="text-gray-300 font-medium">Nome Produto</label>
                    <input type="text" id="edit_nome" name="nome" class="w-full p-2.5 rounded-lg bg-gray-700 border border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 text-white">
                </div>

                <div class="space-y-2">
                    <label for="edit_descricao" class="text-gray-300 font-medium">Descrição</label>
                    <input type="text" id="edit_descricao" name="descricao" class="w-full p-2.5 rounded-lg bg-gray-700 border border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 text-white">
                </div>

                <div class="space-y-2">
                    <label for="edit_unidade" class="text-gray-300 font-medium">Unidade</label>
                    <input type="text" id="edit_unidade" name="unidade" class="w-full p-2.5 rounded-lg bg-gray-700 border border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 text-white">
                </div>

                <div class="space-y-2">
                    <label for="edit_minimo" class="text-gray-300 font-medium">Estoque Mínimo</label>
                    <input type="number" id="edit_minimo" name="minimo" class="w-full p-2.5 rounded-lg bg-gray-700 border border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 text-white">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition duration-150 flex items-center justify-center space-x-2">
                    <i class="bi bi-save"></i>
                    <span>Salvar Alterações</span>
                </button>
            </div>
        </form>
    </section>

    <script>
        function showMovimentacao() {
            document.getElementById('modalMovimentacao').style.display = 'flex';
        }

        function closeMovimentacao() {
            document.getElementById('modalMovimentacao').style.display = 'none';
        }

        function showEdit() {
            // Em uma aplicação real, você preencheria os campos do modal com os dados do produto clicado.
            document.getElementById('modalEdicao').style.display = 'flex';
        }

        function closeEdit() {
            document.getElementById('modalEdicao').style.display = 'none';
        }
        
        // Inicializa o modal de movimentação como oculto
        document.addEventListener('DOMContentLoaded', () => {
             document.getElementById('modalMovimentacao').style.display = 'none';
             document.getElementById('modalEdicao').style.display = 'none';
        });
    </script>
</body>

</html>
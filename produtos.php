<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP - Cadastro de Produtos</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Ícone -->
    <link rel="shortcut icon" href="assets/imgs/logo.png" type="image/x-icon">

    <!-- CSS Personalizado -->
    <style>
        /* Fonte Geral */
        @import url('https://fonts.googleapis.com/css2?family=Geologica:wght@100..900&display=swap');

        body {
            font-family: 'Geologica', sans-serif;
            min-height: 100vh;
            display: flex;
            background-color: #111827; 
            color: #E5E7EB;
        }

        /* Sidebar */
        .sidebar {
            width: 16rem;
            flex-shrink: 0;
            background-color: #1F2937;
        }

        /* Cards e blocos padrão */
        .dashboard-card {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3),
                        0 2px 4px -2px rgba(0, 0, 0, 0.5);
            transition: 0.2s;
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5),
                        0 4px 6px -4px rgba(0, 0, 0, 0.5);
        }

        /* INPUTS PADRONIZADOS */
        .caixa-input-prod input {
            width: 100%;
            padding: 12px;
            background-color: #374151;
            border: 1px solid #4B5563;
            border-radius: 8px;
            color: white;
            transition: 0.2s;
        }

        .caixa-input-prod input:focus {
            outline: none;
            border-color: #6366F1;
            box-shadow: 0 0 7px #6366F155;
        }

        /* Botão de cadastrar */
        .btn-cadastro {
            background-color: #4F46E5;
            transition: 0.2s;
        }

        .btn-cadastro:hover {
            background-color: #4338CA;
            transform: scale(1.03);
        }

        /* Logo hover */
        .sec-config img {
            transition: 0.3s;
        }

        .sec-config img:hover {
            transform: scale(1.07);
            opacity: 1;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <nav class="sidebar p-4 border-r border-gray-700 h-screen sticky top-0">
        <div class="flex items-center space-x-3 mb-8 pb-4 border-b border-gray-700">
            <img src="assets/imgs/logo.png" class="w-10 h-10 rounded-full">
            <h1 class="text-xl font-extrabold text-indigo-400">ERP System</h1>
        </div>

        <div class="space-y-2">
            <a href="./principal.php" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700">
                <i class="bi bi-speedometer2 text-lg"></i>
                <span>Dashboard</span>
            </a>

            <a href="./estoque.php" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700">
                <i class="bi bi-box-seam text-lg"></i>
                <span>Estoque</span>
            </a>

            <a href="./produtos.php" class="flex items-center space-x-3 p-3 rounded-lg bg-gray-700 text-indigo-400 font-semibold">
                <i class="bi bi-cart4 text-lg"></i>
                <span>Produtos</span>
            </a>

        
        </div>

        <div class="absolute bottom-4 w-[calc(16rem-2rem)]">
            <a href="./deus.html" class="flex items-center justify-center space-x-3 p-3 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium w-full">
                <i class="bi bi-box-arrow-right text-lg"></i>
                <span>Sair</span>
            </a>
        </div>
    </nav>

    <!-- CONTEÚDO PRINCIPAL -->
    <main class="flex-1 p-6 md:p-10">

        <!-- TÍTULO -->
        <section class="sec-config flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold text-indigo-400">Cadastro de Produtos 📦</h1>

            <img src="assets/imgs/logo.png" class="w-16 h-16 rounded-full opacity-75">
        </section>

        <!-- DESCRIÇÃO -->
        <header class="mb-8">
            <h2 class="text-xl font-semibold text-gray-300">Insira os dados do novo item.</h2>
            <p class="text-gray-400 text-sm italic">Todos os campos são obrigatórios.</p>
        </header>

        <!-- FORMULÁRIO -->
        <section class="p-8 bg-gray-800 rounded-xl shadow-2xl border border-gray-700">

            <form method="POST" class="flex flex-col lg:flex-row gap-8">

                <!-- Lado 1 -->
                <div class="flex-1 space-y-6">
                    <h3 class="text-2xl font-semibold text-indigo-300 border-b border-gray-700 pb-3">
                        Detalhes do Produto
                    </h3>

                    <div class="caixa-input-prod">
                        <label class="text-sm text-gray-400 mb-1 block">Nome do Produto</label>
                        <input type="text" name="nome" placeholder="Ex: Parafuso Sextavado M10" required>
                    </div>

                    <div class="caixa-input-prod">
                        <label class="text-sm text-gray-400 mb-1 block">Descrição Detalhada</label>
                        <input type="text" name="descricao" placeholder="Ex: Aço inox, 50mm" required>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="caixa-input-prod">
                            <label class="text-sm text-gray-400 mb-1 block">Unidade de Medida</label>
                            <input type="text" name="unidade" placeholder="UN, KG, METRO" required>
                        </div>

                        <div class="caixa-input-prod">
                            <label class="text-sm text-gray-400 mb-1 block">Quantidade Inicial</label>
                            <input type="number" name="quantidade" min="0" placeholder="0" required>
                        </div>
                    </div>
                </div>

                <!-- Lado 2 -->
                <div class="w-full lg:w-80 bg-gray-700 p-6 rounded-lg border border-gray-600 space-y-6">

                    <header>
                        <h1 class="text-xl font-bold text-white">Parâmetros</h1>
                        <p class="text-sm text-gray-400">Ponto de reabastecimento.</p>
                    </header>

                    <div class="caixa-input-prod">
                        <label class="text-sm text-gray-300 mb-1 block">Estoque Mínimo</label>
                        <input type="number" name="minimo" min="0" placeholder="50" required>
                    </div>

                    <button type="submit" class="btn-cadastro w-full p-3 text-white font-bold rounded-lg text-lg">
                        <i class="bi bi-plus-circle-fill mr-2"></i> Cadastrar Produto
                    </button>
                </div>
            </form>
        </section>
    </main>

</body>
</html>

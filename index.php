<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP</title>

    <!-- Estilização -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/reset.css">

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
    <main class="caixa-main-login">
        <form class="caixa-form-login" method="POST">
            <img src="assets/imgs/logo.png" alt="Logo">
            <?php
            // Se tiver um post
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                require 'php/conectar.php';
                // Conecto no banco

                $email = $_POST['email'];
                $senha = $_POST['senha'];
                // coleto o email e senha inserido pelo usuario

                // Usamos Prepared Statements (s: string) para segurança
                # ele separa a query dos valores inseridos pelo usuario
                $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
                // o ? é um placeholder ou seja ali vai entrar alguma informação

                $stmt->bind_param("s", $email);
                # bind_param diz ao php que o valor que vai entrar no lugar do ?
                # no caso é 's' (string) e o valor será o e-mail coletado anteriormente
                $stmt->execute();
                # executo a query
                $result = $stmt->get_result();
                # armazeno o resultado

                if ($result->num_rows === 1) {
                    # se o usuario for encontrado execute...

                    $usuario = $result->fetch_assoc();
                    # transforma o resultado em array associativo
                    $senha_hash_bd = $usuario['senha'];
                    # pega a senha que tava no banco no caso o hash

                    if (password_verify($senha, $senha_hash_bd)) {
                        # verifico se a senha digitada bate com a senha armazenada no banco

                        # inicio a sessão
                        session_start();
                        # armazeno alguns valores coletados do banco em variaveis de sessão
                        $_SESSION['user_id'] = $usuario['id'];
                        $_SESSION['user_nome'] = $usuario['nome'];
                        $_SESSION['user_permissao'] = $usuario['permissao'];

                        # envio o usuario para principal.php (tela inicial = dashboard)
                        header("Location: principal.php");
                        exit;
                        # finalizo a execucao com script por aq
                    } else {
                        // Senha incorreta
                        $erro = "Senha Incorreta!";
                        echo '<div style="background:#EF4444; color:#FFF; padding:12px; border-radius:8px;
                                width:80%; max-width:750px; margin:10px auto; text-align:center; 
                                font-weight:bold;">' . "<p>$erro</p>" . "</div>";
                    }
                } else {
                    // Usuário não encontrado
                    $erro = "Usuário não Encontrado!";
                    echo '<div style="background:#EF4444; color:#FFF; padding:12px; border-radius:8px;
                                width:80%; max-width:750px; margin:10px auto; text-align:center; 
                                font-weight:bold;">' . "<p>$erro</p>" . "</div>";
                }

                $stmt->close();
                # fecho o prepared statement
                $conn->close();
                # fecho a conexao com o banco
            }

            ?>
            <div class="caixa-div-login">
                <div class="caixa-input-login">
                    <label for="email"><i class="bi bi-person"></i>E-mail</label>
                    <input type="email" id="email" placeholder="exemplo@exemplo.com" name="email">
                </div>
                <div class="caixa-input-login">
                    <label for="senha"><i class="bi bi-shield-lock"></i>Senha</label>
                    <input type="password" id="senha" placeholder="********" name="senha">
                </div>
            </div>
            <div class="caixa-btn-login">
                <button type="submit">Entrar<i class="bi bi-box-arrow-in-right"></i></button>
            </div>
        </form>
    </main>

    <!-- JS -->
    <script src="scripts/script.js"></script>
</body>

</html>
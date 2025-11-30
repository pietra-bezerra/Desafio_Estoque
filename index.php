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

                // Usamos Prepared Statements (s: string) para segurança
                $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");

                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 1) {
                    // Usuário encontrado
                    $usuario = $result->fetch_assoc();
                    $senha_hash_bd = $usuario['senha'];

                    // C. Verifica se a senha digitada corresponde ao hash seguro no banco
                    if (password_verify($senha, $senha_hash_bd)) {

                        // Login BEM-SUCEDIDO! 🎉

                        // Recomenda-se iniciar uma sessão AQUI para manter o usuário logado
                        session_start();
                        $_SESSION['user_id'] = $usuario['id'];
                        $_SESSION['user_nome'] = $usuario['nome'];
                        $_SESSION['user_permissao'] = $usuario['permissao'];

                        // Redireciona para a área restrita do sistema
                        header("Location: principal.php");
                        exit;
                    } else {
                        // Senha incorreta
                        $erro = "Senha Incorreta!";
                        echo '<div style="
                background:#EF4444;
                color:#FFF;
                padding:12px;
                border-radius:8px;
                width:80%;
                max-width:750px;
                margin:10px auto;
                text-align:center;
                font-weight:bold;
                ">' . "<p>$erro</p>" . "</div>";
                    }
                } else {
                    // Usuário não encontrado
                    $erro = "Usuário não Encontrado!";
                    echo '<div style="
                background:#EF4444;
                color:#FFF;
                padding:12px;
                border-radius:8px;
                width:80%;
                max-width:750px;
                margin:10px auto;
                text-align:center;
                font-weight:bold;
                ">' . "<p>$erro</p>" . "</div>";
                }

                $stmt->close();

                $conn->close();
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
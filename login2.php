<?php
// ======================================================================
// 1. CONFIGURAÇÃO E CONEXÃO DO BANCO DE DADOS
// ======================================================================

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "estoque"; 

// Cria a conexão
$conn = new mysqli($host, $user, $pass, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na Conexão com o Banco de Dados: " . $conn->connect_error);
}

// ======================================================================
// 2. PROCESSAMENTO DO LOGIN
// ======================================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // A. Coleta dos dados usando os names do seu formulário: email2 e senha2
    $email = $_POST['email2'];
    $senha_digitada = $_POST['senha2'];

    // B. Prepara a consulta para buscar o usuário pelo e-mail
    // Usamos Prepared Statements (s: string) para segurança
    $stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
    
    // Verifica se a preparação foi bem-sucedida
    if ($stmt === false) {
        // Redireciona em caso de erro interno na consulta
        header("Location: index.html?status=erro&msg=" . urlencode("Erro interno na preparação da consulta."));
        exit;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Usuário encontrado
        $usuario = $result->fetch_assoc();
        $senha_hash_bd = $usuario['senha'];

        // C. Verifica se a senha digitada corresponde ao hash seguro no banco
        if (password_verify($senha_digitada, $senha_hash_bd)) {
            
            // Login BEM-SUCEDIDO! 🎉
            
            // Recomenda-se iniciar uma sessão AQUI para manter o usuário logado
            session_start();
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_nome'] = $usuario['nome']; 
            
            // Redireciona para a área restrita do sistema
            header("Location: paginaAdmin.php"); 
            exit;

        } else {
            // Senha incorreta
            header("Location: index.html?status=erro&msg=" . urlencode("E-mail ou senha incorretos."));
            exit;
        }

    } else {
        // Usuário não encontrado
        header("Location: index.html?status=erro&msg=" . urlencode("E-mail ou senha incorretos."));
        exit;
    }
    
    $stmt->close();

} else {
    // Acesso direto ao arquivo sem submissão de formulário
    header("Location: index.html");
    exit;
}

$conn->close();
?>
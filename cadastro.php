<?php
// ======================================================================
// 1. CONFIGURAÇÃO E CONEXÃO DO BANCO DE DADOS
// ======================================================================

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "estoque"; // Seu nome de banco de dados

// Cria a conexão
$conn = new mysqli($host, $user, $pass, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na Conexão com o Banco de Dados: " . $conn->connect_error);
}

// ----------------------------------------------------------------------
// 2. CRIAR TABELA 'usuarios' SE NÃO EXISTIR
// ----------------------------------------------------------------------

// Adiciona IF NOT EXISTS e as restrições UNIQUE para Email, CPF e CodigoId
$sql_create_table = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    cpf VARCHAR(20) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
)";

if ($conn->query($sql_create_table) === FALSE) {
    // Em caso de erro na criação da tabela (muito raro, mas bom tratar)
    die("Erro ao criar a tabela: " . $conn->error);
}

// ======================================================================
// 3. PROCESSAMENTO DO FORMULÁRIO DE INSERT (CADASTRO)
// ======================================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // A. Coleta dos dados do formulário
    // Coleta "seca" dos dados, conforme solicitado.
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $senha_texto_claro = $_POST['senha']; 

    // B. Validação básica
    if (empty($nome) || empty($email) || empty($cpf) || empty($senha_texto_claro)) {
        header("Location: index.html?status=erro&msg=" . urlencode("Todos os campos são obrigatórios."));
        exit;
    }

    // C. Gerar o HASH da senha (SEGURANÇA CRUCIAL)
    $senha_hash = password_hash($senha_texto_claro, PASSWORD_DEFAULT);

    // D. Preparar a instrução SQL para INSERT
    $sql_insert = "INSERT INTO usuarios (nome, email, cpf, senha) VALUES (?, ?, ?, ?)";
    
    // Preparar a declaração
    $stmt = $conn->prepare($sql_insert);

    // Verifica se a preparação foi bem-sucedida
    if ($stmt === false) {
        die("Erro na preparação do comando SQL: " . $conn->error);
    }
    
    // Ligar os parâmetros (5 strings)
    $stmt->bind_param("ssss", $nome, $email, $cpf, $senha_hash);

    // EXECUÇÃO E TRATAMENTO DE ERROS (LINHA 77 NO SEU ERRO ORIGINAL)
    if ($stmt->execute()) {
        // Sucesso
        header("Location: index.html?status=sucesso&msg=" . urlencode("Cadastro realizado com sucesso! Faça login."));
        
    } else {
        // TRATAMENTO DO ERRO DE CHAVE DUPLICADA (MySQL error code 1062)
        $erro_msg = "Erro ao cadastrar. ";
        
        if ($conn->errno == 1062) { 
             $erro_msg .= "Um usuário com este E-mail, CPF ou Código de Identificação já está cadastrado.";
        } else {
             // Outro erro de banco de dados
             $erro_msg .= "Erro: " . $stmt->error;
        }
        
        header("Location: index.html?status=erro&msg=" . urlencode($erro_msg));
    }

    $stmt->close();
}

// Fecha a conexão ao final
$conn->close();

// Se o arquivo for acessado diretamente sem POST, ele só verifica/cria a tabela e sai.
?>